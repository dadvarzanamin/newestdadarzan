<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'bucket' => 'nullable|in:daily,weekly,monthly',
            'top_n' => 'nullable|integer|min:1|max:50',
        ]);

        $bucket = $validated['bucket'] ?? 'daily';
        $topN = (int) ($validated['top_n'] ?? 10);
        $dateFrom = !empty($validated['date_from']) ? Carbon::parse($validated['date_from'])->startOfDay() : null;
        $dateTo = !empty($validated['date_to']) ? Carbon::parse($validated['date_to'])->endOfDay() : null;

        $thispage = [
            'title'   => 'گزارشات پویا',
            'list'    => 'داشبورد گزارشات',
            'add'     => '',
            'create'  => '',
            'enter'   => '',
            'edit'    => '',
            'delete'  => '',
        ];

        $charts = [
            'revenueOverTime' => $this->buildRevenueOverTime($bucket, $dateFrom, $dateTo),
            'grossVsNetOverTime' => $this->buildGrossVsNetOverTime($bucket, $dateFrom, $dateTo),
            'walletCashFlowOverTime' => $this->buildWalletCashFlowOverTime($bucket, $dateFrom, $dateTo),
            'outstandingOverTime' => $this->buildOutstandingOverTime($bucket, $dateFrom, $dateTo),
            'revenueShareByProductType' => $this->buildRevenueShareByProductType($dateFrom, $dateTo),
            'topProductsByRevenue' => $this->buildTopProductsByRevenue($topN, $dateFrom, $dateTo),
            'salesCountByProduct' => $this->buildSalesCountByProduct($topN, $dateFrom, $dateTo),
            'avgSellingPriceByProduct' => $this->buildAvgSellingPriceByProduct($topN, $dateFrom, $dateTo),
            'offerImpact' => $this->buildOfferImpact($dateFrom, $dateTo),
            'offerUsageRate' => $this->buildOfferUsageRate($dateFrom, $dateTo),
            'uniquePayingUsersOverTime' => $this->buildUniquePayingUsersOverTime($bucket, $dateFrom, $dateTo),
            'invoiceStatusDistribution' => $this->buildInvoiceStatusDistribution($dateFrom, $dateTo),
            'paymentSuccessRate' => $this->buildPaymentSuccessRate($dateFrom, $dateTo),
            'paymentFunnel' => $this->buildPaymentFunnel($dateFrom, $dateTo),
            'workshopSalesAmountByItem' => $this->buildCatalogTypeSalesAmountByItem('workshop', $dateFrom, $dateTo),
            'workshopSalesCountByItem' => $this->buildCatalogTypeSalesCountByItem('workshop', $dateFrom, $dateTo),
            'contractSalesAmountByItem' => $this->buildCatalogTypeSalesAmountByItem('contract', $dateFrom, $dateTo),
            'contractSalesCountByItem' => $this->buildCatalogTypeSalesCountByItem('contract', $dateFrom, $dateTo),
            'estelamSalesAmountByItem' => $this->buildCatalogTypeSalesAmountByItem('estelam', $dateFrom, $dateTo),
            'estelamSalesCountByItem' => $this->buildCatalogTypeSalesCountByItem('estelam', $dateFrom, $dateTo),
            'requestSalesAmountByType' => $this->buildRequestSalesAmountByType($dateFrom, $dateTo),
            'requestSalesCountByType' => $this->buildRequestSalesCountByType($dateFrom, $dateTo),
        ];

        return view('panel.report')->with(compact('thispage', 'charts', 'bucket', 'topN', 'dateFrom', 'dateTo'));
    }

    private function applyDateRange(Builder $query, string $column, ?Carbon $dateFrom, ?Carbon $dateTo): Builder
    {
        if ($dateFrom !== null) {
            $query->where($column, '>=', $dateFrom);
        }
        if ($dateTo !== null) {
            $query->where($column, '<=', $dateTo);
        }
        return $query;
    }

    private function bucketExpression(string $column, string $bucket): string
    {
        return match ($bucket) {
            'weekly' => "DATE_FORMAT(DATE_SUB(DATE($column), INTERVAL WEEKDAY($column) DAY), '%Y-%m-%d')",
            'monthly' => "DATE_FORMAT($column, '%Y-%m-01')",
            default => "DATE($column)",
        };
    }

    private function localizeDateLabels(array $labels, string $bucket): array
    {
        return array_map(function ($value) use ($bucket) {
            if (empty($value)) {
                return '';
            }

            try {
                $carbon = Carbon::parse($value);
                $jalali = Jalalian::fromCarbon($carbon);

                $text = match ($bucket) {
                    'monthly' => $jalali->format('Y/m'),
                    default => $jalali->format('Y/m/d'),
                };

                return $this->toPersianDigits($text);
            } catch (\Throwable $e) {
                return $this->toPersianDigits((string) $value);
            }
        }, $labels);
    }

    private function toPersianDigits(string $value): string
    {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return str_replace($en, $fa, $value);
    }

    private function grossExpression(): string
    {
        return "CAST(COALESCE(NULLIF(invoices.product_price, ''), NULLIF(invoices.price, ''), '0') AS DECIMAL(18,2))";
    }

    private function netExpression(): string
    {
        return "CAST(COALESCE(NULLIF(invoices.final_price, ''), '0') AS DECIMAL(18,2))";
    }

    private function withOfferCondition(): string
    {
        return "(COALESCE(NULLIF(invoices.offer_discount, ''), '0') <> '0' OR COALESCE(NULLIF(REPLACE(invoices.offer_percentage, '%', ''), ''), '0') <> '0')";
    }

    private function applyPaidScope(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('invoices.price_status', 4)
                ->orWhere('invoices.price_status', '4')
                ->orWhere('invoices.price_status', 'paid');
        });
    }

    private function applyUnpaidScope(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereNull('invoices.price_status')
                ->orWhereNotIn('invoices.price_status', [4, '4', 'paid']);
        });
    }

    private function buildRevenueOverTime(string $bucket, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $bucketExpr = $this->bucketExpression('invoices.created_at', $bucket);
        $query = DB::table('invoices')
            ->selectRaw("$bucketExpr as bucket")
            ->selectRaw("SUM(" . $this->netExpression() . ") as net_revenue");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->get();

        return [
            'labels' => $this->localizeDateLabels($rows->pluck('bucket')->toArray(), $bucket),
            'series' => [
                'netRevenue' => $rows->pluck('net_revenue')->map(fn ($v) => (float) $v)->values(),
            ],
        ];
    }

    private function buildGrossVsNetOverTime(string $bucket, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $bucketExpr = $this->bucketExpression('invoices.created_at', $bucket);
        $query = DB::table('invoices')
            ->selectRaw("$bucketExpr as bucket")
            ->selectRaw("SUM(" . $this->grossExpression() . ") as gross_revenue")
            ->selectRaw("SUM(" . $this->netExpression() . ") as net_revenue");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->get();

        return [
            'labels' => $this->localizeDateLabels($rows->pluck('bucket')->toArray(), $bucket),
            'series' => [
                'grossRevenue' => $rows->pluck('gross_revenue')->map(fn ($v) => (float) $v)->values(),
                'netRevenue' => $rows->pluck('net_revenue')->map(fn ($v) => (float) $v)->values(),
            ],
        ];
    }

    private function buildWalletCashFlowOverTime(string $bucket, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $bucketExpr = $this->bucketExpression('wallet_transactions.created_at', $bucket);
        $query = DB::table('wallet_transactions')
            ->selectRaw("$bucketExpr as bucket")
            ->selectRaw("SUM(CASE WHEN wallet_transactions.type = 'deposit' THEN wallet_transactions.amount ELSE 0 END) as deposit_amount")
            ->selectRaw("SUM(CASE WHEN wallet_transactions.type = 'withdraw' THEN wallet_transactions.amount ELSE 0 END) as withdraw_amount");
        $this->applyDateRange($query, 'wallet_transactions.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->get();

        return [
            'labels' => $this->localizeDateLabels($rows->pluck('bucket')->toArray(), $bucket),
            'series' => [
                'deposit' => $rows->pluck('deposit_amount')->map(fn ($v) => (float) $v)->values(),
                'withdraw' => $rows->pluck('withdraw_amount')->map(fn ($v) => (float) $v)->values(),
            ],
        ];
    }

    private function buildOutstandingOverTime(string $bucket, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $bucketExpr = $this->bucketExpression('invoices.created_at', $bucket);
        $query = DB::table('invoices')
            ->selectRaw("$bucketExpr as bucket")
            ->selectRaw("SUM(" . $this->netExpression() . ") as outstanding_amount");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $this->applyUnpaidScope($query);
        $rows = $query
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->get();

        return [
            'labels' => $this->localizeDateLabels($rows->pluck('bucket')->toArray(), $bucket),
            'series' => [
                'outstanding' => $rows->pluck('outstanding_amount')->map(fn ($v) => (float) $v)->values(),
            ],
        ];
    }

    private function buildRevenueShareByProductType(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $requestTypes = "'contractDrafting','documentDrafting','judgement','lawsuit','legalAdvice','tokil'";

        $query = DB::table('invoices')
            ->selectRaw("SUM(CASE WHEN invoices.product_type = 'workshop' THEN " . $this->netExpression() . " ELSE 0 END) as workshop_revenue")
            ->selectRaw("SUM(CASE WHEN invoices.product_type = 'contract' THEN " . $this->netExpression() . " ELSE 0 END) as contract_revenue")
            ->selectRaw("SUM(CASE WHEN invoices.product_type = 'estelam' THEN " . $this->netExpression() . " ELSE 0 END) as estelam_revenue")
            ->selectRaw("SUM(CASE WHEN invoices.product_type IN ($requestTypes) THEN " . $this->netExpression() . " ELSE 0 END) as request_revenue");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $row = $query->first();

        return [
            'labels' => ['کارگاه‌ها', 'قراردادها', 'استعلامات', 'درخواست‌ها'],
            'series' => [
                'revenue' => [
                    (float) ($row->workshop_revenue ?? 0),
                    (float) ($row->contract_revenue ?? 0),
                    (float) ($row->estelam_revenue ?? 0),
                    (float) ($row->request_revenue ?? 0),
                ],
            ],
        ];
    }

    private function buildTopProductsByRevenue(int $topN, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->join('products', 'products.id', '=', 'invoices.product_id')
            ->selectRaw("COALESCE(products.title, 'بدون عنوان') as product_title")
            ->selectRaw("SUM(" . $this->netExpression() . ") as total_revenue");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('product_title')
            ->orderByDesc('total_revenue')
            ->limit($topN)
            ->get();

        return [
            'labels' => $rows->pluck('product_title')->values(),
            'series' => [
                'revenue' => $rows->pluck('total_revenue')->map(fn ($v) => (float) $v)->values(),
            ],
        ];
    }

    private function buildSalesCountByProduct(int $topN, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->join('products', 'products.id', '=', 'invoices.product_id')
            ->selectRaw("COALESCE(products.title, 'بدون عنوان') as product_title")
            ->selectRaw("COUNT(invoices.id) as sales_count");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('product_title')
            ->orderByDesc('sales_count')
            ->limit($topN)
            ->get();

        return [
            'labels' => $rows->pluck('product_title')->values(),
            'series' => [
                'salesCount' => $rows->pluck('sales_count')->map(fn ($v) => (int) $v)->values(),
            ],
        ];
    }

    private function buildAvgSellingPriceByProduct(int $topN, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->join('products', 'products.id', '=', 'invoices.product_id')
            ->selectRaw("COALESCE(products.title, 'بدون عنوان') as product_title")
            ->selectRaw("AVG(" . $this->netExpression() . ") as avg_price");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('product_title')
            ->orderByDesc('avg_price')
            ->limit($topN)
            ->get();

        return [
            'labels' => $rows->pluck('product_title')->values(),
            'series' => [
                'avgPrice' => $rows->pluck('avg_price')->map(fn ($v) => (float) $v)->values(),
            ],
        ];
    }

    private function buildOfferImpact(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->selectRaw("SUM(CASE WHEN " . $this->withOfferCondition() . " THEN " . $this->netExpression() . " ELSE 0 END) as with_offer")
            ->selectRaw("SUM(CASE WHEN " . $this->withOfferCondition() . " THEN 0 ELSE " . $this->netExpression() . " END) as without_offer");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query->first();

        return [
            'labels' => ['با تخفیف', 'بدون تخفیف'],
            'series' => [
                'revenue' => [
                    (float) ($rows->with_offer ?? 0),
                    (float) ($rows->without_offer ?? 0),
                ],
            ],
        ];
    }

    private function buildOfferUsageRate(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->selectRaw("SUM(CASE WHEN " . $this->withOfferCondition() . " THEN 1 ELSE 0 END) as with_offer")
            ->selectRaw("SUM(CASE WHEN " . $this->withOfferCondition() . " THEN 0 ELSE 1 END) as without_offer");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query->first();

        return [
            'labels' => ['با تخفیف', 'بدون تخفیف'],
            'series' => [
                'count' => [
                    (int) ($rows->with_offer ?? 0),
                    (int) ($rows->without_offer ?? 0),
                ],
            ],
        ];
    }

    private function buildUniquePayingUsersOverTime(string $bucket, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $bucketExpr = $this->bucketExpression('invoices.created_at', $bucket);
        $query = DB::table('invoices')
            ->selectRaw("$bucketExpr as bucket")
            ->selectRaw("COUNT(DISTINCT invoices.user_id) as unique_paying_users");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $this->applyPaidScope($query);
        $rows = $query
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->get();

        return [
            'labels' => $this->localizeDateLabels($rows->pluck('bucket')->toArray(), $bucket),
            'series' => [
                'users' => $rows->pluck('unique_paying_users')->map(fn ($v) => (int) $v)->values(),
            ],
        ];
    }

    private function buildInvoiceStatusDistribution(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->selectRaw("COALESCE(CAST(invoices.price_status AS CHAR), 'null') as status_label")
            ->selectRaw("COUNT(invoices.id) as total_count");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('status_label')
            ->orderByDesc('total_count')
            ->get();

        return [
            'labels' => $rows->pluck('status_label')->values(),
            'series' => [
                'count' => $rows->pluck('total_count')->map(fn ($v) => (int) $v)->values(),
            ],
        ];
    }

    private function buildPaymentSuccessRate(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->selectRaw("COUNT(invoices.id) as total_invoices")
            ->selectRaw("SUM(CASE WHEN invoices.price_status IN ('4', 'paid') OR invoices.price_status = 4 THEN 1 ELSE 0 END) as paid_invoices");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $totals = $query->first();

        $total = (int) ($totals->total_invoices ?? 0);
        $paid = (int) ($totals->paid_invoices ?? 0);
        $rate = $total > 0 ? round(($paid / $total) * 100, 2) : 0.0;

        return [
            'kpi' => [
                'totalInvoices' => $total,
                'paidInvoices' => $paid,
                'successRate' => $rate,
            ],
        ];
    }

    private function buildPaymentFunnel(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $invoiceQuery = DB::table('invoices');
        $this->applyDateRange($invoiceQuery, 'invoices.created_at', $dateFrom, $dateTo);
        $invoiceCreated = (int) $invoiceQuery->count('invoices.id');

        $transactionQuery = DB::table('wallet_transactions')
            ->whereNotNull('wallet_transactions.invoice_id');
        $this->applyDateRange($transactionQuery, 'wallet_transactions.created_at', $dateFrom, $dateTo);
        $walletCreated = (int) $transactionQuery->distinct()->count('wallet_transactions.invoice_id');

        $paidQuery = DB::table('invoices');
        $this->applyDateRange($paidQuery, 'invoices.created_at', $dateFrom, $dateTo);
        $this->applyPaidScope($paidQuery);
        $paidInvoices = (int) $paidQuery->count('invoices.id');

        return [
            'labels' => ['ایجاد فاکتور', 'ایجاد تراکنش کیف پول', 'پرداخت‌شده'],
            'series' => [
                'count' => [$invoiceCreated, $walletCreated, $paidInvoices],
            ],
        ];
    }

    private function requestTypeMap(): array
    {
        return [
            'contractDrafting' => 'تنظیم قرارداد',
            'documentDrafting' => 'تنظیم اسناد',
            'judgement' => 'داوری/حکم',
            'lawsuit' => 'دعوای حقوقی',
            'legalAdvice' => 'مشاوره حقوقی',
            'tokil' => 'وکیل',
        ];
    }

    private function buildCatalogTypeSalesAmountByItem(string $productType, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->join('products', 'products.id', '=', 'invoices.product_id')
            ->where('products.product_type', $productType)
            ->selectRaw("COALESCE(products.title, 'بدون عنوان') as item_label")
            ->selectRaw("SUM(" . $this->netExpression() . ") as total_amount");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('item_label')
            ->orderByDesc('total_amount')
            ->get();

        return [
            'labels' => $rows->pluck('item_label')->values(),
            'series' => [
                'amount' => $rows->pluck('total_amount')->map(fn ($v) => (float) $v)->values(),
            ],
        ];
    }

    private function buildCatalogTypeSalesCountByItem(string $productType, ?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $query = DB::table('invoices')
            ->join('products', 'products.id', '=', 'invoices.product_id')
            ->where('products.product_type', $productType)
            ->selectRaw("COALESCE(products.title, 'بدون عنوان') as item_label")
            ->selectRaw("COUNT(invoices.id) as total_count");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('item_label')
            ->orderByDesc('total_count')
            ->get();

        return [
            'labels' => $rows->pluck('item_label')->values(),
            'series' => [
                'count' => $rows->pluck('total_count')->map(fn ($v) => (int) $v)->values(),
            ],
        ];
    }

    private function buildRequestSalesAmountByType(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $map = $this->requestTypeMap();
        $requestTypes = array_keys($map);

        $query = DB::table('invoices')
            ->whereIn('invoices.product_type', $requestTypes)
            ->select('invoices.product_type')
            ->selectRaw("SUM(" . $this->netExpression() . ") as total_amount");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('invoices.product_type')
            ->get()
            ->keyBy('product_type');

        $labels = [];
        $series = [];
        foreach ($map as $type => $label) {
            $labels[] = $label;
            $series[] = (float) (($rows[$type]->total_amount ?? 0));
        }

        return [
            'labels' => $labels,
            'series' => [
                'amount' => $series,
            ],
        ];
    }

    private function buildRequestSalesCountByType(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $map = $this->requestTypeMap();
        $requestTypes = array_keys($map);

        $query = DB::table('invoices')
            ->whereIn('invoices.product_type', $requestTypes)
            ->select('invoices.product_type')
            ->selectRaw("COUNT(invoices.id) as total_count");
        $this->applyDateRange($query, 'invoices.created_at', $dateFrom, $dateTo);
        $rows = $query
            ->groupBy('invoices.product_type')
            ->get()
            ->keyBy('product_type');

        $labels = [];
        $series = [];
        foreach ($map as $type => $label) {
            $labels[] = $label;
            $series[] = (int) (($rows[$type]->total_count ?? 0));
        }

        return [
            'labels' => $labels,
            'series' => [
                'count' => $series,
            ],
        ];
    }
}

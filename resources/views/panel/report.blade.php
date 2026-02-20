@extends('layouts.base')

@section('title')
    <title>{{ $thispage['title'] }}</title>
@endsection

@section('content')
    <style>
        .report-wrap { direction: rtl; }
        .report-title { margin-bottom: 6px; font-weight: 700; }
        .report-subtitle { margin-top: 0; opacity: .75; }

        .kpi-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 18px;
        }
        .kpi-col { flex: 1 1 220px; }

        .kpi-card {
            border-radius: 14px;
            box-shadow: 0 8px 22px rgba(17,24,39,.08) !important;
        }
        .kpi-card .card-content { padding: 16px 16px; }
        .kpi-value { font-size: 22px; font-weight: 800; margin: 0; }
        .kpi-label { margin: 6px 0 0; opacity: .9; }

        .report-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }
        .report-col { flex: 1 1 calc(33.333% - 14px); min-width: 340px; }

        .report-card {
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(17,24,39,.08) !important;
            overflow: hidden;
        }
        .report-card .card-content { padding: 16px 16px 10px; }
        .card-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .card-head h6 { margin:0; font-weight:800; font-size: 14px; color: #1f2937; }
        .card-hint { font-size: 12px; opacity: .65; }

        .chart-box { position: relative; height: 240px; }
        .chart-box.tall { height: 280px; }
        .chart-box.full { height: 320px; }
        .chart-box canvas { width: 100% !important; height: 100% !important; }

        @media (max-width: 1100px) { .report-col { flex: 1 1 calc(50% - 14px); } }
        @media (max-width: 700px)  { .report-col { flex: 1 1 100%; min-width: unset; } }
    </style>

    <div class="report-wrap">
        <div class="row" style="margin-bottom:10px;">
            <div class="col s12">
                <h4 class="report-title">{{ $thispage['title'] }}</h4>
                <p class="report-subtitle">گزارش‌های پویا بر اساس محصولات، فاکتورها و تراکنش‌های کیف پول.</p>
            </div>
        </div>

        <div class="kpi-row">
            <div class="kpi-col">
                <div class="card kpi-card" style="background:#0ea5e9;color:#fff;">
                    <div class="card-content center">
                        <p class="kpi-value" id="kpiTotalInvoices">0</p>
                        <p class="kpi-label">کل فاکتورها</p>
                    </div>
                </div>
            </div>
            <div class="kpi-col">
                <div class="card kpi-card" style="background:#10b981;color:#fff;">
                    <div class="card-content center">
                        <p class="kpi-value" id="kpiPaidInvoices">0</p>
                        <p class="kpi-label">فاکتورهای پرداخت‌شده</p>
                    </div>
                </div>
            </div>
            <div class="kpi-col">
                <div class="card kpi-card" style="background:#6366f1;color:#fff;">
                    <div class="card-content center">
                        <p class="kpi-value" id="kpiSuccessRate">0%</p>
                        <p class="kpi-label">نرخ موفقیت پرداخت</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-grid">
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>روند درآمد در گذر زمان</h6></div><div class="chart-box"><canvas id="revenueOverTimeChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>درآمد ناخالص در برابر خالص</h6></div><div class="chart-box"><canvas id="grossVsNetChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>جریان نقدی کیف پول (واریز/برداشت)</h6></div><div class="chart-box"><canvas id="walletCashFlowChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>روند مبالغ تسویه‌نشده</h6></div><div class="chart-box"><canvas id="outstandingChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>سهم درآمد بر اساس نوع محصول</h6></div><div class="chart-box"><canvas id="revenueShareByTypeChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>پرفروش‌ترین محصولات بر اساس درآمد</h6></div><div class="chart-box"><canvas id="topProductsRevenueChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>تعداد فروش به تفکیک محصول</h6></div><div class="chart-box"><canvas id="salesCountByProductChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>میانگین قیمت فروش هر محصول</h6></div><div class="chart-box"><canvas id="avgSellingPriceChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>اثر تخفیف (با تخفیف / بدون تخفیف)</h6></div><div class="chart-box"><canvas id="offerImpactChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>نرخ استفاده از تخفیف</h6></div><div class="chart-box"><canvas id="offerUsageRateChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>کاربران یکتای پرداخت‌کننده در گذر زمان</h6></div><div class="chart-box"><canvas id="uniquePayingUsersChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>توزیع وضعیت فاکتورها</h6></div><div class="chart-box"><canvas id="invoiceStatusDistributionChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>کارگاه‌ها: فروش مبلغی</h6></div><div class="chart-box"><canvas id="workshopSalesAmountChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>کارگاه‌ها: فروش تعدادی</h6></div><div class="chart-box"><canvas id="workshopSalesCountChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>قراردادها: فروش مبلغی</h6></div><div class="chart-box"><canvas id="contractSalesAmountChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>قراردادها: فروش تعدادی</h6></div><div class="chart-box"><canvas id="contractSalesCountChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>استعلامات: فروش مبلغی</h6></div><div class="chart-box"><canvas id="estelamSalesAmountChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>استعلامات: فروش تعدادی</h6></div><div class="chart-box"><canvas id="estelamSalesCountChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>درخواست‌ها: فروش مبلغی بر اساس نوع درخواست</h6></div><div class="chart-box"><canvas id="requestSalesAmountChart"></canvas></div></div></div>
            </div>
            <div class="report-col">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>درخواست‌ها: فروش تعدادی بر اساس نوع درخواست</h6></div><div class="chart-box"><canvas id="requestSalesCountChart"></canvas></div></div></div>
            </div>
            <div class="report-col" style="flex:1 1 100%;">
                <div class="card report-card hoverable"><div class="card-content"><div class="card-head"><h6>قیف پرداخت: فاکتور → تراکنش کیف پول → پرداخت‌شده</h6></div><div class="chart-box full"><canvas id="paymentFunnelChart"></canvas></div></div></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (!window.Chart) return;

            const charts = @json($charts);

            const kpi = charts.paymentSuccessRate?.kpi ?? { totalInvoices: 0, paidInvoices: 0, successRate: 0 };
            document.getElementById('kpiTotalInvoices').innerText = Number(kpi.totalInvoices || 0).toLocaleString();
            document.getElementById('kpiPaidInvoices').innerText = Number(kpi.paidInvoices || 0).toLocaleString();
            document.getElementById('kpiSuccessRate').innerText = `${kpi.successRate || 0}%`;

            Chart.defaults.font.family = 'Vazirmatn, IRANSans, system-ui, -apple-system, Segoe UI, Roboto';
            Chart.defaults.color = '#374151';
            Chart.defaults.plugins.legend.labels.usePointStyle = true;
            Chart.defaults.plugins.legend.labels.boxWidth = 8;
            Chart.defaults.plugins.legend.labels.boxHeight = 8;

            const gridColor = 'rgba(17,24,39,.06)';
            const borderColor = 'rgba(17,24,39,.12)';
            const palette = {
                blue: 'rgba(14,165,233,.85)',
                green: 'rgba(16,185,129,.85)',
                orange: 'rgba(249,115,22,.85)',
                red: 'rgba(244,63,94,.85)',
                indigo: 'rgba(99,102,241,.85)',
                slate: 'rgba(148,163,184,.85)'
            };

            const baseOptions = {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        backgroundColor: 'rgba(17,24,39,.92)',
                        padding: 10,
                        cornerRadius: 10,
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                }
            };

            const toNumbers = (arr) => (arr || []).map(v => Number(v || 0));

            new Chart(document.getElementById('revenueOverTimeChart'), {
                type: 'line',
                data: {
                    labels: charts.revenueOverTime?.labels || [],
                    datasets: [{ label: 'درآمد خالص', data: toNumbers(charts.revenueOverTime?.series?.netRevenue), borderColor: palette.blue, backgroundColor: 'rgba(14,165,233,.14)', fill: true, tension: .35, pointRadius: 2 }]
                },
                options: { ...baseOptions, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('grossVsNetChart'), {
                type: 'line',
                data: {
                    labels: charts.grossVsNetOverTime?.labels || [],
                    datasets: [
                        { label: 'ناخالص', data: toNumbers(charts.grossVsNetOverTime?.series?.grossRevenue), borderColor: palette.orange, backgroundColor: 'rgba(249,115,22,.10)', fill: true, tension: .35, pointRadius: 2 },
                        { label: 'خالص', data: toNumbers(charts.grossVsNetOverTime?.series?.netRevenue), borderColor: palette.green, backgroundColor: 'rgba(16,185,129,.10)', fill: true, tension: .35, pointRadius: 2 }
                    ]
                },
                options: { ...baseOptions, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('walletCashFlowChart'), {
                type: 'bar',
                data: {
                    labels: charts.walletCashFlowOverTime?.labels || [],
                    datasets: [
                        { label: 'واریز', data: toNumbers(charts.walletCashFlowOverTime?.series?.deposit), backgroundColor: palette.green, stack: 'cashflow', borderRadius: 8 },
                        { label: 'برداشت', data: toNumbers(charts.walletCashFlowOverTime?.series?.withdraw), backgroundColor: palette.red, stack: 'cashflow', borderRadius: 8 }
                    ]
                },
                options: { ...baseOptions, scales: { x: { stacked: true, grid: { display: false }, border: { display: false } }, y: { stacked: true, grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('outstandingChart'), {
                type: 'line',
                data: {
                    labels: charts.outstandingOverTime?.labels || [],
                    datasets: [{ label: 'تسویه‌نشده', data: toNumbers(charts.outstandingOverTime?.series?.outstanding), borderColor: palette.red, backgroundColor: 'rgba(244,63,94,.10)', fill: true, tension: .35, pointRadius: 2 }]
                },
                options: { ...baseOptions, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('revenueShareByTypeChart'), {
                type: 'doughnut',
                data: { labels: charts.revenueShareByProductType?.labels || [], datasets: [{ data: toNumbers(charts.revenueShareByProductType?.series?.revenue), backgroundColor: [palette.blue, palette.green, palette.orange, palette.indigo, palette.slate], borderWidth: 0 }] },
                options: { ...baseOptions, cutout: '68%' }
            });

            new Chart(document.getElementById('topProductsRevenueChart'), {
                type: 'bar',
                data: { labels: charts.topProductsByRevenue?.labels || [], datasets: [{ label: 'درآمد', data: toNumbers(charts.topProductsByRevenue?.series?.revenue), backgroundColor: palette.indigo, borderRadius: 8 }] },
                options: { ...baseOptions, indexAxis: 'y', plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { color: gridColor }, border: { color: borderColor } }, y: { grid: { display: false }, border: { display: false } } } }
            });

            new Chart(document.getElementById('salesCountByProductChart'), {
                type: 'bar',
                data: { labels: charts.salesCountByProduct?.labels || [], datasets: [{ label: 'تعداد فروش', data: toNumbers(charts.salesCountByProduct?.series?.salesCount), backgroundColor: palette.blue, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('avgSellingPriceChart'), {
                type: 'bar',
                data: { labels: charts.avgSellingPriceByProduct?.labels || [], datasets: [{ label: 'میانگین قیمت', data: toNumbers(charts.avgSellingPriceByProduct?.series?.avgPrice), backgroundColor: palette.orange, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('offerImpactChart'), {
                type: 'bar',
                data: { labels: charts.offerImpact?.labels || [], datasets: [{ label: 'درآمد', data: toNumbers(charts.offerImpact?.series?.revenue), backgroundColor: [palette.green, palette.slate], borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('offerUsageRateChart'), {
                type: 'doughnut',
                data: { labels: charts.offerUsageRate?.labels || [], datasets: [{ data: toNumbers(charts.offerUsageRate?.series?.count), backgroundColor: [palette.green, palette.slate], borderWidth: 0 }] },
                options: { ...baseOptions, cutout: '68%' }
            });

            new Chart(document.getElementById('uniquePayingUsersChart'), {
                type: 'line',
                data: { labels: charts.uniquePayingUsersOverTime?.labels || [], datasets: [{ label: 'کاربران یکتای پرداخت‌کننده', data: toNumbers(charts.uniquePayingUsersOverTime?.series?.users), borderColor: palette.indigo, backgroundColor: 'rgba(99,102,241,.10)', fill: true, tension: .35, pointRadius: 2 }] },
                options: { ...baseOptions, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('invoiceStatusDistributionChart'), {
                type: 'doughnut',
                data: { labels: charts.invoiceStatusDistribution?.labels || [], datasets: [{ data: toNumbers(charts.invoiceStatusDistribution?.series?.count), backgroundColor: [palette.green, palette.blue, palette.orange, palette.red, palette.indigo, palette.slate], borderWidth: 0 }] },
                options: { ...baseOptions, cutout: '68%' }
            });

            new Chart(document.getElementById('paymentFunnelChart'), {
                type: 'bar',
                data: { labels: charts.paymentFunnel?.labels || [], datasets: [{ label: 'تعداد', data: toNumbers(charts.paymentFunnel?.series?.count), backgroundColor: [palette.blue, palette.orange, palette.green], borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('workshopSalesAmountChart'), {
                type: 'bar',
                data: { labels: charts.workshopSalesAmountByItem?.labels || [], datasets: [{ label: 'مبلغ فروش', data: toNumbers(charts.workshopSalesAmountByItem?.series?.amount), backgroundColor: palette.indigo, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('workshopSalesCountChart'), {
                type: 'bar',
                data: { labels: charts.workshopSalesCountByItem?.labels || [], datasets: [{ label: 'تعداد فروش', data: toNumbers(charts.workshopSalesCountByItem?.series?.count), backgroundColor: palette.blue, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('contractSalesAmountChart'), {
                type: 'bar',
                data: { labels: charts.contractSalesAmountByItem?.labels || [], datasets: [{ label: 'مبلغ فروش', data: toNumbers(charts.contractSalesAmountByItem?.series?.amount), backgroundColor: palette.green, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('contractSalesCountChart'), {
                type: 'bar',
                data: { labels: charts.contractSalesCountByItem?.labels || [], datasets: [{ label: 'تعداد فروش', data: toNumbers(charts.contractSalesCountByItem?.series?.count), backgroundColor: palette.orange, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('estelamSalesAmountChart'), {
                type: 'bar',
                data: { labels: charts.estelamSalesAmountByItem?.labels || [], datasets: [{ label: 'مبلغ فروش', data: toNumbers(charts.estelamSalesAmountByItem?.series?.amount), backgroundColor: palette.red, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('estelamSalesCountChart'), {
                type: 'bar',
                data: { labels: charts.estelamSalesCountByItem?.labels || [], datasets: [{ label: 'تعداد فروش', data: toNumbers(charts.estelamSalesCountByItem?.series?.count), backgroundColor: palette.slate, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('requestSalesAmountChart'), {
                type: 'bar',
                data: { labels: charts.requestSalesAmountByType?.labels || [], datasets: [{ label: 'مبلغ فروش', data: toNumbers(charts.requestSalesAmountByType?.series?.amount), backgroundColor: palette.indigo, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });

            new Chart(document.getElementById('requestSalesCountChart'), {
                type: 'bar',
                data: { labels: charts.requestSalesCountByType?.labels || [], datasets: [{ label: 'تعداد فروش', data: toNumbers(charts.requestSalesCountByType?.series?.count), backgroundColor: palette.blue, borderRadius: 8 }] },
                options: { ...baseOptions, plugins: { ...baseOptions.plugins, legend: { display: false } }, scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: gridColor }, border: { color: borderColor } } } }
            });
        });
    </script>
@endpush

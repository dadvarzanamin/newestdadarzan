<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتیجه پرداخت موفق</title>
    <style>
        :root {
            --bg-a: #e6ffef;
            --bg-b: #f3fbff;
            --card-bg: rgba(255, 255, 255, 0.88);
            --card-border: rgba(255, 255, 255, 0.72);
            --text: #10231a;
            --muted: #4f645a;
            --accent: #12a150;
            --accent-soft: #eafaf1;
            --line: #d9eadf;
            --btn: #0f8a44;
            --btn-hover: #0b6e35;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: radial-gradient(1200px 800px at 10% 15%, var(--bg-a), transparent),
            radial-gradient(1100px 700px at 100% 0%, #d8f8e5, transparent),
            linear-gradient(145deg, #f8fffb, var(--bg-b));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 22px;
            direction: rtl;
            color: var(--text);
        }

        .container {
            width: min(760px, 100%);
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 28px 26px 22px;
            backdrop-filter: blur(7px);
            box-shadow: 0 18px 48px rgba(18, 44, 30, 0.14);
            animation: rise .45s ease-out;
        }

        .success-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: grid;
            place-items: center;
            font-size: 34px;
            font-weight: 700;
            color: var(--accent);
            background: var(--accent-soft);
            border: 1px solid #cdeed9;
        }

        h1 {
            margin: 8px 0 6px;
            font-size: 30px;
            color: var(--accent);
            text-align: center;
        }

        p {
            margin: 8px 0;
            text-align: center;
            color: var(--muted);
            line-height: 1.9;
        }

        .status-chip {
            width: fit-content;
            margin: 12px auto 0;
            background: #dcf8e8;
            color: #0b6e35;
            border: 1px solid #bde8d0;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
        }

        .btn {
            display: inline-block;
            margin-top: 18px;
            padding: 10px 18px;
            background: var(--btn);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: .25s ease;
            font-weight: 700;
        }

        .btn:hover {
            background: var(--btn-hover);
            transform: translateY(-1px);
        }

        .details {
            margin-top: 18px;
            text-align: right;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            background: #ffffff;
        }

        .details-header {
            padding: 12px 14px;
            font-weight: 700;
            border-bottom: 1px solid var(--line);
            background: #f3fcf7;
            color: #165b34;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .details td {
            padding: 11px 12px;
            border-bottom: 1px solid #ecf3ee;
            vertical-align: top;
        }

        .details tr:last-child td {
            border-bottom: none;
        }

        .details td:first-child {
            font-weight: 700;
            width: 42%;
            color: #214636;
            background: #f9fdfb;
        }

        .details td:last-child {
            color: #24362e;
            word-break: break-word;
        }

        .actions {
            text-align: center;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .container {
                padding: 20px 14px 16px;
                border-radius: 16px;
            }

            h1 {
                font-size: 24px;
            }

            .details td {
                font-size: 13px;
                padding: 9px 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="success-icon">✓</div>
    <h1>پرداخت موفق</h1>
    <p>{{ $message ?? 'پرداخت شما با موفقیت انجام شد.' }}</p>
    <p>ثبت نام/سفارش شما تکمیل شد.</p>
    <div class="status-chip">تراکنش تایید شد</div>

    @if(!empty($paymentDetails) && is_array($paymentDetails))
        @php
            $labels = [
                'channel' => 'کانال پرداخت',
                'gateway_status' => 'وضعیت درگاه',
                'amount' => 'مبلغ',
                'status' => 'وضعیت تراکنش',
                'type' => 'نوع تراکنش',
                'description' => 'توضیحات',
                'transaction_id' => 'شناسه تراکنش',
                'reference_id' => 'کد رهگیری',
                'created_at' => 'تاریخ ثبت',
            ];

            $toFaDigits = function ($value) {
                return strtr((string) $value, [
                    '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
                    '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹',
                ]);
            };

            $valueMaps = [
                'channel' => [
                    'gateway' => 'درگاه بانکی',
                    'wallet' => 'کیف پول',
                ],
                'status' => [
                    'pending' => 'در انتظار',
                    'completed' => 'تکمیل شده',
                    'failed' => 'ناموفق',
                ],
                'type' => [
                    'deposit' => 'واریز',
                    'withdraw' => 'برداشت',
                    'order_payment' => 'پرداخت سفارش',
                    'wallet_usage' => 'استفاده از کیف پول',
                ],
                'gateway_status' => [
                    'OK' => 'موفق',
                    'NOK' => 'ناموفق',
                    'COMPLETED' => 'تکمیل شده',
                    'FAILED' => 'ناموفق',
                ],
            ];
        @endphp
        <div class="details">
            <div class="details-header">جزئیات کامل تراکنش</div>
            <table>
                <tbody>
                @foreach($labels as $key => $label)
                    @if(array_key_exists($key, $paymentDetails) && !is_null($paymentDetails[$key]) && $paymentDetails[$key] !== '')
                        <tr>
                            <td>{{ $label }}</td>
                            <td>
                                @if($key === 'amount')
                                    {{ $toFaDigits(number_format((int)$paymentDetails[$key])) }} تومان
                                @elseif($key === 'created_at')
                                    @php
                                        try {
                                            $formattedDate = jdate(\Illuminate\Support\Carbon::parse($paymentDetails[$key]))->format('Y/m/d - H:i:s');
                                        } catch (\Throwable $e) {
                                            $formattedDate = (string) $paymentDetails[$key];
                                        }
                                    @endphp
                                    {{ $toFaDigits($formattedDate) }}
                                @else
                                    @php
                                        $rawValue = (string) $paymentDetails[$key];
                                        $translatedValue = $valueMaps[$key][$rawValue] ?? $rawValue;
                                    @endphp
                                    {{ $toFaDigits($translatedValue) }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="actions">
        <a href="{{route('profile')}}" class="btn">بازگشت به حساب کاربری</a>
    </div>
</div>

</body>
</html>

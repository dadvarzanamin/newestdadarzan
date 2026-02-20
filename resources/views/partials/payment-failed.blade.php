<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتیجه پرداخت ناموفق</title>
{{--    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap" rel="stylesheet">--}}
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #ffe6e6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            direction: rtl;
        }

        .container {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 95%;
            max-width: 650px;
        }

        .error-icon {
            font-size: 50px;
            color: #dc3545;
        }

        h1 {
            color: #dc3545;
        }

        p {
            color: #555;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #c82333;
        }

        .details {
            margin-top: 20px;
            text-align: right;
            border: 1px solid #f0d3d6;
            border-radius: 8px;
            overflow: hidden;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .details td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }

        .details tr:last-child td {
            border-bottom: none;
        }

        .details td:first-child {
            font-weight: 700;
            width: 45%;
            background: #fff5f5;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="error-icon">❌</div>
    <h1>پرداخت ناموفق</h1>
    <p>{{ $message ?? 'متأسفانه پرداخت شما با مشکل مواجه شد.' }}</p>
    <p>لطفاً دوباره تلاش کنید.</p>

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
                'authority' => 'Authority',
                'created_at' => 'تاریخ ثبت',
                'error' => 'خطا',
            ];
        @endphp
        <div class="details">
            <table>
                <tbody>
                @foreach($labels as $key => $label)
                    @if(array_key_exists($key, $paymentDetails) && !is_null($paymentDetails[$key]) && $paymentDetails[$key] !== '')
                        <tr>
                            <td>{{ $label }}</td>
                            <td>
                                @if($key === 'amount')
                                    {{ number_format((int)$paymentDetails[$key]) }} تومان
                                @else
                                    {{ $paymentDetails[$key] }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{route('profile')}}" class="btn">بازگشت به حساب کاربری</a>
</div>

</body>
</html>

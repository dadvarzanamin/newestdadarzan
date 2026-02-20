<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتیجه پرداخت موفق</title>
{{--    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap" rel="stylesheet">--}}
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f0f8ff;
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 95%;
            max-width: 650px;
        }

        .success-icon {
            font-size: 50px;
            color: #28a745;
        }

        h1 {
            color: #28a745;
        }

        p {
            color: #555;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #218838;
        }

        .details {
            margin-top: 20px;
            text-align: right;
            border: 1px solid #e5e5e5;
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
            background: #f8fafc;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="success-icon">✔️</div>
    <h1>پرداخت موفق</h1>
    <p>{{ $message ?? 'پرداخت شما با موفقیت انجام شد.' }}</p>
    <p>ثبت نام/سفارش شما تکمیل شد.</p>

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

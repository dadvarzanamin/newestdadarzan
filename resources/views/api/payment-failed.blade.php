<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتیجه پرداخت ناموفق</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap" rel="stylesheet">
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
            width: 300px;
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
    </style>
</head>
<body>

<div class="container">
    <div class="error-icon">❌</div>
    <h1>پرداخت ناموفق</h1>
    <p>متأسفانه پرداخت شما با مشکل مواجه شد.</p>
    <p>لطفاً دوباره تلاش کنید.</p>
    <a href="myapp://payment-failed" class="btn">بازگشت به اپ </a>
</div>

</body>
</html>

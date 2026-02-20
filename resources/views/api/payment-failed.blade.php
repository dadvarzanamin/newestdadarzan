<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتیجه پرداخت ناموفق</title>
    <style>
        :root {
            --bg-a: #fff0f0;
            --bg-b: #fff8f7;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(255, 255, 255, 0.74);
            --text: #2d1113;
            --muted: #6f4f52;
            --accent: #cd2f45;
            --accent-soft: #ffeef0;
            --btn: #bb2438;
            --btn-hover: #9f1d2f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: radial-gradient(1200px 800px at 10% 15%, var(--bg-a), transparent),
            radial-gradient(1100px 700px at 100% 0%, #ffe2e5, transparent),
            linear-gradient(145deg, #fffdfd, var(--bg-b));
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
            box-shadow: 0 18px 48px rgba(71, 23, 27, 0.16);
            animation: rise .45s ease-out;
        }

        .error-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: grid;
            place-items: center;
            font-size: 30px;
            font-weight: 700;
            color: var(--accent);
            background: var(--accent-soft);
            border: 1px solid #f6cdd3;
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
            background: #ffe5e8;
            color: #9f1d2f;
            border: 1px solid #f7c6cd;
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
        }
    </style>
</head>
<body>

<div class="container">
    <div class="error-icon">!</div>
    <h1>پرداخت ناموفق</h1>
    <p>{{ $message ?? 'متأسفانه پرداخت شما با مشکل مواجه شد.' }}</p>
    <p>لطفاً دوباره تلاش کنید.</p>
    <div class="status-chip">تراکنش تایید نشد</div>
    <div class="actions">
        <a href="myapp://payment-failed" class="btn">بازگشت به اپ</a>
    </div>
</div>

</body>
</html>

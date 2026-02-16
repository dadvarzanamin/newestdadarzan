<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="AI image generator, image generation, AI art, digital">
<link rel="shortcut icon" href="{{ asset('site/assets/images/logo/favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('site/assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('site/assets/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('site/assets/css/magnific-popup.min.css') }}">
<link rel="stylesheet" href="{{ asset('site/assets/css/odometer.css') }}">
<link rel="stylesheet" href="{{ asset('site/assets/css/custom-animation.css') }}">
<link rel="stylesheet" href="{{ asset('site/assets/css/main.css') }}">
<style>
    .site-version-banner {
        background: linear-gradient(90deg, #0d2c54 0%, #164a7e 100%);
        color: #fff;
        font-size: 14px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 200;
        transform: translateY(0);
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
    .site-version-banner.is-closing {
        transform: translateY(-100%);
        opacity: 0;
    }
    .navbar-main {
        top: var(--version-banner-offset, 0px);
    }
    .site-version-banner__content {
        align-items: center;
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        flex-wrap: wrap;
    }
    .site-version-banner__text {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .site-version-banner__badge {
        background: #ffb703;
        color: #1b1b1b;
        border-radius: 999px;
        padding: 2px 10px;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
    }
    .site-version-banner__actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .site-version-banner__download {
        background: #ffffff;
        color: #0d2c54;
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 700;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .site-version-banner__download:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }
    .site-version-banner__close {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.6);
        color: #fff;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        line-height: 24px;
        text-align: center;
        cursor: pointer;
        font-size: 18px;
    }
    .site-version-banner__close:hover {
        background: rgba(255, 255, 255, 0.15);
    }
</style>

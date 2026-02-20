<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}" dir="rtl">
<head>
    @include('site.partials.head')
    <title>@yield('title', 'موسسه حقوقی دادورزان امین')</title>
    @stack('page_styles')
</head>
<body>

{{-- Preloader --}}
<div id="preloader">
    <div id="text">
{{--        <p> موسسه </p><p> حقوقی </p><p> دادورزان </p><p class="active"> امین </p>--}}
        <p>موسسه حقوقی دادورزان امین</p>
    </div>
</div>

{{-- Scroll top progress --}}
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

{{-- Version banner --}}
@include('site.partials.version-banner')

{{-- Navbar --}}
@include('site.partials.navbar')

<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('site.partials.footer')

{{-- Scripts عمومی --}}
<script src="{{ asset('site/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('site/assets/js/boostrap.bundle.min.js') }}"></script>
<script src="{{ asset('site/assets/js/gsap.min.js') }}"></script>
<script src="{{ asset('site/assets/js/ScrollTrigger.js') }}"></script>
<script src="{{ asset('site/assets/js/scrollreveal.min.js') }}"></script>
<script src="{{ asset('site/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('site/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('site/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('site/assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('site/assets/js/odometer.min.js') }}"></script>
<script src="{{ asset('site/assets/js/main.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var banner = document.querySelector('.site-version-banner');
        if (!banner) {
            return;
        }
        var version = banner.getAttribute('data-version') || 'unknown';
        var storageKey = 'site_version_banner_dismissed_' + version;
        var root = document.documentElement;
        var setOffset = function () {
            if (banner && banner.offsetHeight) {
                root.style.setProperty('--version-banner-offset', banner.offsetHeight + 'px');
            }
        };
        try {
            if (localStorage.getItem(storageKey) === '1') {
                root.style.setProperty('--version-banner-offset', '0px');
                banner.remove();
                return;
            }
        } catch (e) {}

        setOffset();
        window.addEventListener('resize', setOffset);

        var closeBtn = banner.querySelector('.site-version-banner__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                banner.classList.add('is-closing');
                root.style.setProperty('--version-banner-offset', '0px');
                try {
                    localStorage.setItem(storageKey, '1');
                } catch (e) {}
                setTimeout(function () {
                    if (banner && banner.parentNode) {
                        banner.parentNode.removeChild(banner);
                    }
                }, 220);
            });
        }
    });
</script>

@stack('page_scripts')
</body>
</html>

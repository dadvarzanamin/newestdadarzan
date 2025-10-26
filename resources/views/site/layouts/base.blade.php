<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}" dir="rtl">
<head>
    @include('site.partials.head')
    <title>@yield('title', 'موسسه حقوقی دادورزان امین')</title>
    @stack('page_styles')
</head>
<body>

{{-- Preloader --}}
<div id="preloader" dir="ltr">
    <div id="text">
        <p>امین</p><p>دادورزان</p><p>حقوقی</p><p class="active">موسسه</p>
    </div>
</div>

{{-- Scroll top progress --}}
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

{{-- Navbar --}}
@include('site.partials.navbar')

<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('site.partials.footer')

{{-- Scripts عمومی --}}
{{--<script data-cfasync="false" src="https://www.iarsalan.ir/template/pixgix/pixgix/index.htmlcdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>--}}
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

@stack('page_scripts')
</body>
</html>

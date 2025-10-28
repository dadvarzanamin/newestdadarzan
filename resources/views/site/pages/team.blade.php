@extends('site.layouts.base')

@section('title', 'اعضای تیم')

@section('content')


    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title"> با تیم ما آشنا شوید</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="{{url('/')}}"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> اعضای تیم</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-section section-one-bg py-120">
        <div class="container">
            <div class="row row-gap-4 justify-content-center">
                @foreach($emploees as $emploee)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item top-reveal">
                        <figure class="image-effect ">
                            <img src="{{asset('storage/'.$emploee->image)}}" alt="{{$emploee->fullname}}" class="img-fluid w-100">
                        </figure>
                        <ul class="social">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/" target="_blank">
                                    <i class="fa-brands fa-pinterest-p"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="name-details">
                            <h4><a href="{{url('تیم-ما/رزومه/'.$emploee->slug)}}">{{$emploee->fullname}}</a> </h4>
                            <p>{{$emploee->side}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


{{--    <div class="section-two-bg py-60 @@services-text-slide">--}}
{{--        <div class="text-slide swiper">--}}
{{--            <div class="swiper-wrapper slide-transition">--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        AI IMAGE GENERATE--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        <img src="assets/images/shape/star.svg" alt="icon">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        AI IMAGE GENERATE--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        <img src="assets/images/shape/star.svg" alt="icon">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        AI IMAGE GENERATE--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        <img src="assets/images/shape/star.svg" alt="icon">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        AI IMAGE GENERATE--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        <img src="assets/images/shape/star.svg" alt="icon">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="swiper-slide inner-slide-element">--}}
{{--                    <div class="slide-text">--}}
{{--                        <img src="assets/images/shape/star.svg" alt="icon">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- =====>> End Text-slide <<=====
    =========================== -->
@endsection

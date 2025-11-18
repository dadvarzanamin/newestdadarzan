@extends('site.layouts.base')

@section('title', 'درباره ما')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title"> درباره ما</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="index.html"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> درباره ما</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End breadcrumb <<=====
    =============================== -->
    <!-- ===========================
    =====>> About <<======= -->
    <section class="about-section section-two-bg py-120">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-lg-6 align-self-center">
                    <div class="about-section__content">
                        <div class="section-title">
                            <span class="sub-title right-reveal">درباره ما</span>
                            <h2 class="right-reveal">موسسه حقوقی دادورزان امین</h2>
                            <p class="right-reveal">

                                موسسه حقوقی دادورزان امین از سال 1396 با تکیه بر تعهد و تخصص و با بهره‌گیری از وکلای
                                متخصص، کارشناسان مجرب و قضات بازنشسته در زمینه های مختلف حقوقی، مفتخر است که خدماتی جامع
                                را به سبکی نوین و با بهترین بازدهی به شما ارائه دهد.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-section__img" dir="ltr">
{{--                        <div class="image-one">--}}
{{--                            <figure class="image-effect right-reveal">--}}
{{--                                <img src="assets/images/about/1.jpg" alt="about images" class="img-fluid w-100">--}}
{{--                            </figure>--}}
{{--                        </div>--}}
{{--                        <div class="image-two d-grid">--}}
{{--                            <figure class="image-effect bottom-reveal">--}}
{{--                                <img src="assets/images/about/2.jpg" alt="about images" class="img-fluid w-100">--}}
{{--                            </figure>--}}
{{--                            <figure class="image-effect top-reveal">--}}
{{--                                <img src="assets/images/about/3.jpg" alt="about images" class="img-fluid w-100">--}}
{{--                            </figure>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End About <<=====
    =========================== -->
    <!-- ===========================
    =====>> We-are <<======= -->
{{--    <section class="section-one-bg py-120">--}}
{{--        <div class="container">--}}
{{--            <div class="row row-gap-4">--}}
{{--                <div class="col-lg-6 align-self-end">--}}
{{--                    <div class="section-title pe-xl-4">--}}
{{--                        <span class="sub-title right-reveal">ما کی هستیم؟</span>--}}
{{--                        <h2 class="right-reveal">توانمندسازی خلاقیت با مهارت‌های هوش مصنوعی</h2>--}}

{{--                        <p class="right-reveal pb-0">ما نوآورانی در زمینه تولید تصویر با هوش مصنوعی هستیم و در حال تغییر--}}
{{--                            نحوه خلق و تعامل مردم با هنر دیجیتال می‌باشیم. فناوری پیشرفته هوش مصنوعی ما به کاربران امکان--}}
{{--                            می‌دهد به‌راحتی تصاویر خیره‌کننده‌ای تولید کنند و طراحی باکیفیت را در دسترس همه قرار می‌دهد.--}}
{{--                            <br><br>--}}
{{--                            فناوری هوش مصنوعی پیشرفته ما، ایده‌های شما را تنها با چند کلیک به تصاویری نفس‌گیر تبدیل--}}
{{--                            می‌کند. فرقی نمی‌کند هنرمند دیجیتال باشید، بازاریاب، صاحب کسب‌وکار یا تولیدکننده محتوا.--}}
{{--                        </p>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-6 align-self-end">--}}
{{--                    <div class="d-grid row-gap-4 pb-lg-3">--}}
{{--                        <div class="skill-progress">--}}
{{--                            <span class="fs-16">تولید تصویر با هوش مصنوعی</span>--}}
{{--                            <div class="progress">--}}
{{--                                <div class="progress-bar" role="progressbar"></div>--}}
{{--                                <div class="percentage" data-target="90"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="skill-progress">--}}
{{--                            <span class="fs-16">پردازش سریع و کارآمد</span>--}}
{{--                            <div class="progress">--}}
{{--                                <div class="progress-bar" role="progressbar">--}}
{{--                                </div>--}}
{{--                                <div class="percentage" data-target="70"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="skill-progress">--}}
{{--                            <span class="fs-16">بهینه شده برای بازاریابی و برندسازی</span>--}}
{{--                            <div class="progress">--}}
{{--                                <div class="progress-bar" role="progressbar">--}}
{{--                                </div>--}}
{{--                                <div class="percentage" data-target="80"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="skill-progress">--}}
{{--                            <span class="fs-16">سبک‌های طراحی قابل تنظیم</span>--}}
{{--                            <div class="progress">--}}
{{--                                <div class="progress-bar" role="progressbar">--}}
{{--                                </div>--}}
{{--                                <div class="percentage" data-target="90"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="skill-progress">--}}
{{--                            <span class="fs-16">رابط کاربرپسند</span>--}}
{{--                            <div class="progress">--}}
{{--                                <div class="progress-bar" role="progressbar">--}}
{{--                                </div>--}}
{{--                                <div class="percentage" data-target="60"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- =====>> End We-are <<=====
    =========================== -->

    <!-- ===========================
    =====>> Team <<======= -->
    {{--    <section class="team-section section-one-bg py-120">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-lg-12">--}}
    {{--                    <div class="section-title text-center">--}}
    {{--                        <span class="sub-title top-reveal">با تیم ما آشنا شوید</span>--}}
    {{--                        <h2 class="top-reveal">ذهن‌های درخشان، عامل موفقیت ما</h2>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="row mt-60 row-gap-4 justify-content-center">--}}
    {{--                @foreach($emploees as $emploee)--}}
    {{--                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">--}}
    {{--                        <div class="team-item top-reveal">--}}
    {{--                            <figure class="image-effect ">--}}
    {{--                                <img src="{{asset('storage/'.$emploee->image)}}" alt="{{$emploee->fullname}}" class="img-fluid w-100">--}}
    {{--                            </figure>--}}
    {{--                            <div class="name-details">--}}
    {{--                                <h4><a href="{{url('تیم-ما/رزومه/'.$emploee->slug)}}">{{$emploee->fullname}}</a> </h4>--}}
    {{--                                <p>{{$emploee->side}}</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                @endforeach--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    <!-- =====>> End Team <<=====
    =========================== -->
    <!-- ===========================
    =====>> Pricing <<======= -->
    <section class="pricing-section section-two-bg py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="sub-title top-reveal">خدمات ما</h2>
                        <br>
                        <br>
                        <span class="top-reveal">
                            موسسه حقوقی دادورزان امین متشکل از سه دپارتمان اصلی دعاوی، قراردادها و آموزش و پژوهش به ارائه خدمات در زمینه های مختلف می‌پردازد:
                        </span>
                    </div>
                </div>
            </div>
            <div class="row row-gap-4 mt-60 justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex top-reveal">
                    <div class="pricing-section__item">
                        <div class="header">
                            <span>دپارتمان دعاوی</span>
                        </div>

                        <ul class="pricing-list">
                            <p>
                                دپارتمان دعاوی شامل بخش‌های حقوقی، کیفری و تجاری است که در هر بخش بصورت تخصصی خدمات
                                ارائه
                                مشاوره، دعاوی، داوری و نظرات شورای حقوقی است.
                            </p>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 d-flex top-reveal">
                    <div class="pricing-section__item">
                        <div class="header">
                            <span>دپارتمان قراردادها</span>
                        </div>
                        <ul class="pricing-list">
                            <p>
                                این دپارتمان نیز شامل اکثریت موضوعات قراردادی داخلی و بین‌المللی است که خدمات تنظیم و
                                مشاوره قراردادها در این دپارتمان انجام می‌پذیرد.
                            </p>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 d-flex top-reveal">
                    <div class="pricing-section__item">
                        <div class="header">
                            <span>دپارتمان آموزش و پژوهش</span>
                        </div>
                        <ul class="pricing-list">
                            <p>
                                در این دپارتمان موسسه حقوقی دادورزان امین خدماتی برای دانشپذیران رشته حقوق در نظر گرفته
                                است و با برگزاری کارگاه‌های آموزشی، نشست‌های حقوقی و ارائه ویدئو و جزوات و مطالب کاربردی
                                خدمات خود را ارائه می‌دهد.
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Pricing <<=====
    =========================== -->
@endsection

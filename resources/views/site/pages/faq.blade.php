@extends('site.layouts.base')

@section('title', 'سوالات متداول')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title"> سوالات متداول</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="index.html"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> سوالات متداول</span>
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
    =====>> Faq <<======= -->
    <section class="faq-section section-one-bg py-120 ">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 col-xl-5">
                    <div class="section-title">
                        <span class="sub-title right-reveal">سوالات متداول</span>
                        <h2 class="right-reveal">تولید محتوای بسیار سریع‌تر با هوش مصنوعی</h2>
                        <p class="right-reveal">تولید محتوای سریع‌تر و بسیار کارآمد با هوش مصنوعی به شما این امکان را می‌دهد که با بهره‌گیری از هوش مصنوعی پیشرفته، فرآیند خلاقیت خود را ساده‌تر کنید و در کسری از زمان، محتوای باکیفیت تولید کنید.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion top-reveal" id="accordionWorking">
                        @foreach($questionlists as $questionlist)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $questionlist->id }}">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $questionlist->id }}"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $questionlist->id }}">
                                        {{ $questionlist->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $questionlist->id }}"
                                     class="accordion-collapse collapse"
                                     aria-labelledby="heading{{ $questionlist->id }}"
                                     data-bs-parent="#accordionWorking">
                                    <div class="accordion-body">
                                        <p>{{ $questionlist->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($questionlists->hasMorePages())
                        <div class="load-more-btn-box pt-5 text-center">
                            <button type="button" id="loadMore" class="btn theme-btn"><i class="la la-refresh mr-1"></i> بارگذاری بیشتر</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Faq <<=====
    =========================== -->
    <!-- ===========================
    =====>> Text-slide <<======= -->
    <div class="section-two-bg py-60 @@services-text-slide">
        <div class="text-slide swiper">
            <div class="swiper-wrapper slide-transition">
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        AI IMAGE GENERATE
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="{{asset('site/assets/images/shape/star.svg')}}" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        AI IMAGE GENERATE
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="{{asset('site/assets/images/shape/star.svg')}}" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        AI IMAGE GENERATE
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="{{asset('site/assets/images/shape/star.svg')}}" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        AI IMAGE GENERATE
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="{{asset('site/assets/images/shape/star.svg')}}" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="{{asset('site/assets/images/shape/star.svg')}}" alt="icon">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =====>> End Text-slide <<=====
    =========================== -->
    <!-- ===========================
    =====>> Testimonials <<======= -->
    <section class="testimonials-section section-one-bg py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">دیدگاه مشتریان</span>
                        <h2 class="top-reveal">مشتریان ما درباره Pixgix می‌گویند</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-60">
                <div class="col-lg-12">
                    <div class="testimonials-slider swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="question">
                                        <i class="flaticon-quote"></i>
                                    </div>
                                    <div class="body-text">
                                        <p>"من از کیفیت تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویری خیره‌کننده و کاملاً مطابق با دیدگاه من داشت. به عنوان کسی که مهارت‌های طراحی محدودی دارد، از حرفه‌ای به نظر رسیدن تصاویر شگفت‌زده شدم. این ابزار ساعت‌ها در کار من صرفه‌جویی کرده است و نمی‌توانم اداره کسب و کارم را بدون آن تصور کنم."</p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('assets/images/testimonial/1.jpg')}}" alt="user">
                                            </div>
                                            <div class="text">
                                                <h4>امیرارسلان رهنما</h4>
                                                <p>بازاریاب دیجیتال</p>
                                                <ul>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="question">
                                        <i class="flaticon-quote"></i>
                                    </div>
                                    <div class="body-text">
                                        <p>"من از کیفیت تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویری خیره‌کننده و کاملاً مطابق با دیدگاه من داشت. به عنوان کسی که مهارت‌های طراحی محدودی دارد، از حرفه‌ای به نظر رسیدن تصاویر شگفت‌زده شدم. این ابزار ساعت‌ها در کار من صرفه‌جویی کرده است و نمی‌توانم اداره کسب و کارم را بدون آن تصور کنم."</p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('assets/images/testimonial/2.jpg')}}" alt="user">
                                            </div>
                                            <div class="text">
                                                <h4>ایلیا میرزایی</h4>
                                                <p>گرافیست</p>
                                                <ul>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="question">
                                        <i class="flaticon-quote"></i>
                                    </div>
                                    <div class="body-text">
                                        <p>"من از کیفیت تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویری خیره‌کننده و کاملاً مطابق با دیدگاه من داشت. به عنوان کسی که مهارت‌های طراحی محدودی دارد، از حرفه‌ای به نظر رسیدن تصاویر شگفت‌زده شدم. این ابزار ساعت‌ها در کار من صرفه‌جویی کرده است و نمی‌توانم اداره کسب و کارم را بدون آن تصور کنم."</p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('assets/images/testimonial/1.jpg')}}" alt="user">
                                            </div>
                                            <div class="text">
                                                <h4>امیرارسلان رهنما</h4>
                                                <p>بازاریاب دیجیتال</p>
                                                <ul>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="question">
                                        <i class="flaticon-quote"></i>
                                    </div>
                                    <div class="body-text">
                                        <p>"من از کیفیت تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویری خیره‌کننده و کاملاً مطابق با دیدگاه من داشت. به عنوان کسی که مهارت‌های طراحی محدودی دارد، از حرفه‌ای به نظر رسیدن تصاویر شگفت‌زده شدم. این ابزار ساعت‌ها در کار من صرفه‌جویی کرده است و نمی‌توانم اداره کسب و کارم را بدون آن تصور کنم."</p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('assets/images/testimonial/2.jpg')}}" alt="user">
                                            </div>
                                            <div class="text">
                                                <h4>ایلیا میرزایی</h4>
                                                <p>گرافیست</p>
                                                <ul>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Testimonials <<=====
    =========================== -->
@endsection

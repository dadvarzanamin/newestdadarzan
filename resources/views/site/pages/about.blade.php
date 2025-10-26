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
                    <div class="about-section__img" dir="ltr">
                        <div class="image-one">
                            <figure class="image-effect right-reveal">
                                <img src="assets/images/about/1.jpg" alt="about images" class="img-fluid w-100">
                            </figure>
                        </div>
                        <div class="image-two d-grid">
                            <figure class="image-effect bottom-reveal">
                                <img src="assets/images/about/2.jpg" alt="about images" class="img-fluid w-100">
                            </figure>
                            <figure class="image-effect top-reveal">
                                <img src="assets/images/about/3.jpg" alt="about images" class="img-fluid w-100">
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-section__content">
                        <div class="section-title">
                            <span class="sub-title right-reveal">درباره ما</span>
                            <h2 class="right-reveal">به Pixgix خوش آمدید، جایی که خلاقیت با هوش مصنوعی تلاقی می‌کند.</h2>
                            <p class="right-reveal">ماموریت ما این است که با استفاده از قدرت هوش مصنوعی برای تولید تصاویر خیره‌کننده و با کیفیت بالا، انقلابی در نحوه خلق تصاویر بصری ایجاد کنیم. چه یک هنرمند، طراح یا یک متخصص کسب و کار باشید، پلتفرم ما به شما این امکان را می‌دهد که...
                                <br>
                                <br>
                                روشی که شما با استفاده از قدرت هوش مصنوعی، تصاویر خیره‌کننده و با کیفیتی خلق می‌کنید. چه یک هنرمند، طراح یا متخصص کسب و کار باشید، پلتفرم ما به شما این امکان را می‌دهد که...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End About <<=====
    =========================== -->
    <!-- ===========================
    =====>> We-are <<======= -->
    <section class="section-one-bg py-120">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-lg-6 align-self-end">
                    <div class="section-title pe-xl-4">
                        <span class="sub-title right-reveal">ما کی هستیم؟</span>
                        <h2 class="right-reveal">توانمندسازی خلاقیت با مهارت‌های هوش مصنوعی</h2>

                        <p class="right-reveal pb-0">ما نوآورانی در زمینه تولید تصویر با هوش مصنوعی هستیم و در حال تغییر نحوه خلق و تعامل مردم با هنر دیجیتال می‌باشیم. فناوری پیشرفته هوش مصنوعی ما به کاربران امکان می‌دهد به‌راحتی تصاویر خیره‌کننده‌ای تولید کنند و طراحی باکیفیت را در دسترس همه قرار می‌دهد.
                            <br><br>
                            فناوری هوش مصنوعی پیشرفته ما، ایده‌های شما را تنها با چند کلیک به تصاویری نفس‌گیر تبدیل می‌کند. فرقی نمی‌کند هنرمند دیجیتال باشید، بازاریاب، صاحب کسب‌وکار یا تولیدکننده محتوا.
                        </p>

                    </div>
                </div>
                <div class="col-lg-6 align-self-end">
                    <div class="d-grid row-gap-4 pb-lg-3">
                        <div class="skill-progress">
                            <span class="fs-16">تولید تصویر با هوش مصنوعی</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"></div>
                                <div class="percentage" data-target="90"></div>
                            </div>
                        </div>
                        <div class="skill-progress">
                            <span class="fs-16">پردازش سریع و کارآمد</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar">
                                </div>
                                <div class="percentage" data-target="70"></div>
                            </div>
                        </div>
                        <div class="skill-progress">
                            <span class="fs-16">بهینه شده برای بازاریابی و برندسازی</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar">
                                </div>
                                <div class="percentage" data-target="80"></div>
                            </div>
                        </div>
                        <div class="skill-progress">
                            <span class="fs-16">سبک‌های طراحی قابل تنظیم</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar">
                                </div>
                                <div class="percentage" data-target="90"></div>
                            </div>
                        </div>
                        <div class="skill-progress">
                            <span class="fs-16">رابط کاربرپسند</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar">
                                </div>
                                <div class="percentage" data-target="60"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End We-are <<=====
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
                        <img src="assets/images/shape/star.svg" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        AI IMAGE GENERATE
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="assets/images/shape/star.svg" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        AI IMAGE GENERATE
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="assets/images/shape/star.svg" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        AI IMAGE GENERATE
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="assets/images/shape/star.svg" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="assets/images/shape/star.svg" alt="icon">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =====>> End Text-slide <<=====
    =========================== -->
    <!-- ===========================
    =====>> Team <<======= -->
    <section class="team-section section-one-bg py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">با تیم ما آشنا شوید</span>
                        <h2 class="top-reveal">ذهن‌های درخشان، عامل موفقیت ما</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-60 row-gap-4 justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item top-reveal">
                        <figure class="image-effect ">
                            <img src="assets/images/team/1.jpg" alt="team images" class="img-fluid w-100">
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
                            <h4><a href="javascript: void(0);">نسترن سلطانی</a></h4>
                            <p>طراح رابط کاربری</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item top-reveal">
                        <figure class="image-effect ">
                            <img src="assets/images/team/2.jpg" alt="team images" class="img-fluid w-100">
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
                            <h4><a href="javascript: void(0);">مهسا رهنما</a></h4>
                            <p>طراح محصول</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item top-reveal">
                        <figure class="image-effect ">
                            <img src="assets/images/team/3.jpg" alt="team images" class="img-fluid w-100">
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
                            <h4><a href="javascript: void(0);">زهرا عطایی</a> </h4>
                            <p>مدیر محتوا</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item top-reveal">
                        <figure class="image-effect ">
                            <img src="assets/images/team/4.jpg" alt="team images" class="img-fluid w-100">
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
                            <h4><a href="javascript: void(0);">شیرین رضایی</a> </h4>
                            <p>گرافیست</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Team <<=====
    =========================== -->
    <!-- ===========================
    =====>> Pricing <<======= -->
    <section class="pricing-section section-two-bg py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">قیمت گذاری ها</span>
                        <h2 class="top-reveal">طرح قیمت گذاری ایده آل را انتخاب کنید</h2>
                    </div>
                </div>
            </div>
            <div class="row row-gap-4 mt-60 justify-content-center">
                <div class="col-lg-4 col-md-6 top-reveal">
                    <div class="pricing-section__item">
                        <div class="header">
                            <span>پلن معمولی</span>
                            <h2>رایگان</h2>
                        </div>
                        <ul class="pricing-list">
                            <li>تولید ۵۰ تصویر توسط هوش مصنوعی در ماه</li>
                            <li>وضوح استاندارد (1080p)</li>
                            <li>گزینه های سفارشی سازی اولیه</li>
                            <li>حقوق استفاده تجاری</li>
                            <li>پشتیبانی ایمیل</li>
                        </ul>
                        <a href="login.html" class="btn btn--border">خریداری کنید</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 top-reveal">
                    <div class="pricing-section__item">
                        <div class="header">
                            <span>پلن حرفه ای</span>
                            <h2>۵۹۰تومان<sub>/ماهیانه</sub></h2>
                        </div>
                        <ul class="pricing-list">
                            <li>تولید ۲۰۰ تصویر توسط هوش مصنوعی در ماه</li>
                            <li>وضوح بالا (4K)</li>
                            <li>گزینه های سفارشی سازی پیشرفته</li>
                            <li>حقوق استفاده تجاری</li>
                            <li>پشتیبانی اولویت دار</li>
                        </ul>
                        <a href="login.html" class="btn btn--border">خریداری کنید</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 top-reveal">
                    <div class="pricing-section__item">
                        <div class="header">
                            <span>پلن سازمانی</span>
                            <h2>۹۹۰تومان<sub>/ماهیانه</sub></h2>
                        </div>
                        <ul class="pricing-list">
                            <li>تولید تصویر نامحدود توسط هوش مصنوعی</li>
                            <li>وضوح تصویر اولترا اچ‌دی (8K)</li>
                            <li>آموزش مدل AI سفارشی</li>
                            <li>مدیر حساب اختصاصی</li>
                            <li>دسترسی و ادغام API</li>
                        </ul>
                        <a href="login.html" class="btn btn--border">خریداری کنید</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Pricing <<=====
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
                <div class="col-lg-12 position-relative">
                    <div class="testimonials-slider-two swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="body-text">
                                        <div class="user mt-0">
                                            <div class="img">
                                                <img src="assets/images/testimonial/1.jpg" alt="user">
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
                                        <p>«من از کیفیت کار تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویر خیره‌کننده‌ای داشتم که کاملاً با دیدگاه من مطابقت داشت.»</p>
                                        <i class="flaticon-quote"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="body-text">
                                        <div class="user mt-0">
                                            <div class="img">
                                                <img src="assets/images/testimonial/2.jpg" alt="user">
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
                                        <p>«من از کیفیت کار تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویر خیره‌کننده‌ای داشتم که کاملاً با دیدگاه من مطابقت داشت.»</p>
                                        <i class="flaticon-quote"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="body-text">
                                        <div class="user mt-0">
                                            <div class="img">
                                                <img src="assets/images/testimonial/3.jpg" alt="user">
                                            </div>
                                            <div class="text">
                                                <h4>باربد باباخانی</h4>
                                                <p>طراح وب</p>
                                                <ul>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p>«من از کیفیت کار تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویر خیره‌کننده‌ای داشتم که کاملاً با دیدگاه من مطابقت داشت.»</p>
                                        <i class="flaticon-quote"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="body-text">
                                        <div class="user mt-0">
                                            <div class="img">
                                                <img src="assets/images/testimonial/1.jpg" alt="user">
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
                                        <p>«من از کیفیت کار تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویر خیره‌کننده‌ای داشتم که کاملاً با دیدگاه من مطابقت داشت.»</p>
                                        <i class="flaticon-quote"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-slider__item">
                                    <div class="body-text">
                                        <div class="user mt-0">
                                            <div class="img">
                                                <img src="assets/images/testimonial/2.jpg" alt="user">
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
                                        <p>«من از کیفیت کار تصاویر تولید شده توسط هوش مصنوعی شگفت‌زده شدم! این پلتفرم فوق‌العاده شهودی است و در عرض چند دقیقه، تصاویر خیره‌کننده‌ای داشتم که کاملاً با دیدگاه من مطابقت داشت.»</p>
                                        <i class="flaticon-quote"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-btn">
                        <div class="swiper--prev btn btn--border">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="swiper--next btn btn--border">
                            <i class="fa-solid fa-angle-left"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Testimonials <<=====
    =========================== -->
    <!-- ===========================
    =====>> Follow <<======= -->
    <div class="follow-slide swiper pb-120">
        <div class="swiper-wrapper slide-transition">
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/1.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/2.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/3.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/4.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/5.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/6.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/1.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/2.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/3.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide inner-slide-element">
                <div class="follow-item">
                    <img src="assets/images/follow/4.jpg" alt="follow img">
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- =====>> End Follow <<=====
    =========================== -->
@endsection

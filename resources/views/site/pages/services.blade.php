@extends('site.layouts.base')

@section('title', 'صفحه خدمت ما')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title"> خدمات</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="index.html"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> خدمات</span>
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
    =====>> Feature <<======= -->
    <section class="feature-section py-120">
        <div class="container">
            <div class="row justify-content-center row-gap-4">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-photo-editing"></i>
                        </div>
                        <div class="text">
                            <h5>ایجاد هنر AI سفارشی</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-image-edit"></i>
                        </div>
                        <div class="text">
                            <h5>استوک تصویر نسل</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-camera"></i>
                        </div>
                        <div class="text">
                            <h5>بهبودهای عکس</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-replace"></i>
                        </div>
                        <div class="text">
                            <h5>تولید عکس دسته ای</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را متحول کنیم.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Feature <<=====
    =========================== -->
    <!-- ===========================
    =====>> We-do <<======= -->
    <section class="we-do-section section-two-bg py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">کاری که ما انجام می دهیم</span>
                        <h2 class="top-reveal">تبدیل ایده‌های شما به تصاویر خیره‌کننده با فناوری پیشرفته هوش مصنوعی</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-60">
                <div class="col-lg-12">
                    <div class="we-do-slide swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="we-do-item">
                                    <a href="about.html" class="icon">
                                        <i class="flaticon-right-arrow"></i>
                                    </a>
                                    <figure class="image-effect">
                                        <img src="assets/images/working/wd1.jpg" alt="about images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="we-do-text">
                                        <p>شخصی سازی</p>
                                        <h4><a href="about.html">سبک های سفارشی</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="we-do-item">
                                    <a href="about.html" class="icon">
                                        <i class="flaticon-right-arrow"></i>
                                    </a>
                                    <figure class="image-effect">
                                        <img src="assets/images/working/wd2.jpg" alt="about images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="we-do-text">
                                        <p> نتایج فوری</p>
                                        <h4><a href="about.html"> ایجاد سریع</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="we-do-item">
                                    <a href="about.html" class="icon">
                                        <i class="flaticon-right-arrow"></i>
                                    </a>
                                    <figure class="image-effect">
                                        <img src="assets/images/working/wd3.jpg" alt="about images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="we-do-text">
                                        <p>تصاویری کامل</p>
                                        <h4><a href="about.html">پالایش تصویر</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="we-do-item">
                                    <a href="about.html" class="icon">
                                        <i class="flaticon-right-arrow"></i>
                                    </a>
                                    <figure class="image-effect">
                                        <img src="assets/images/working/wd1.jpg" alt="about images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="we-do-text">
                                        <p>شخصی سازی</p>
                                        <h4><a href="about.html">سبک های سفارشی</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="we-do-item">
                                    <a href="about.html" class="icon">
                                        <i class="flaticon-right-arrow"></i>
                                    </a>
                                    <figure class="image-effect">
                                        <img src="assets/images/working/wd2.jpg" alt="about images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="we-do-text">
                                        <p> نتایج فوری</p>
                                        <h4><a href="about.html"> ایجاد سریع</a></h4>
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
    <!-- =====>> End We-do <<=====
    =========================== -->
    <!-- ===========================
    =====>> Full-video <<======= -->
    <div class="full-video-section bg-img" data-background-image="assets/images/video/magical-eyes-close-up.jpg">
        <div class="text-center">
            <a href="https://www.youtube.com/watch?v=TfU0qjuZkJ4" class="video-play-btn popup-youtube" tabindex="0">
                <i class="fa-solid fa-play"></i>
            </a>
        </div>
    </div>
    <!-- =====>> End Full-video <<=====
    =========================== -->
    <!-- ===========================
    =====>> Text-slide <<======= -->
    <div class="section-two-bg py-60 services-text-slide">
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
    =====>> Pricing <<======= -->
    <section class="pricing-two-section section-two-bg py-120">
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
                            <i class="flaticon-rating-stars"></i>
                            <span>پلن معمولی</span>
                            <h2>۲۹۰تومان<sub>/ماهیانه</sub></h2>
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
                            <i class="flaticon-rating-stars"></i>
                            <span>پلن کاری</span>
                            <h2>۴۹۰تومان<sub>/ماهیانه</sub></h2>
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
                            <i class="flaticon-rating-stars"></i>
                            <span>پلن سازمانی</span>
                            <h2>۶۹۰تومان<sub>/ماهیانه</sub></h2>
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
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    تولید محتوای هوش مصنوعی چقدر طول می‌کشد؟
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>ماموریت ما این است که با بهره‌گیری از قدرت هوش مصنوعی برای تولید تصاویر خیره‌کننده و با کیفیت بالا، انقلابی در نحوه خلق تصاویر بصری ایجاد کنیم. چه یک هنرمند، طراح یا متخصص کسب و کار باشید.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    آیا می‌توانم برای تصاویر تولید شده توسط هوش مصنوعی، استایل‌های خاصی درخواست کنم؟
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>ماموریت ما این است که با بهره‌گیری از قدرت هوش مصنوعی برای تولید تصاویر خیره‌کننده و با کیفیت بالا، انقلابی در نحوه خلق تصاویر بصری ایجاد کنیم. چه یک هنرمند، طراح یا متخصص کسب و کار باشید.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    چه فرمت‌هایی برای دانلود فایل‌ها ارائه می‌دهید؟
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>ماموریت ما این است که با بهره‌گیری از قدرت هوش مصنوعی برای تولید تصاویر خیره‌کننده و با کیفیت بالا، انقلابی در نحوه خلق تصاویر بصری ایجاد کنیم. چه یک هنرمند، طراح یا متخصص کسب و کار باشید.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                    آیا محتوای تولید شده توسط هوش مصنوعی قابل تنظیم است؟
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>ماموریت ما این است که با بهره‌گیری از قدرت هوش مصنوعی برای تولید تصاویر خیره‌کننده و با کیفیت بالا، انقلابی در نحوه خلق تصاویر بصری ایجاد کنیم. چه یک هنرمند، طراح یا متخصص کسب و کار باشید.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Faq <<=====
    =========================== -->
@endsection

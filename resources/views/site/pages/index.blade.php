@extends('site.layouts.base')

@section('title', 'موسسه حقوقی دادورزان امین')

@push('page_styles')
    <style>
        .team-slider {
            direction: rtl;
        }

        .team-item {
            height: 100%;
        }

        .team-section .swiper-pagination-bullet {
            opacity: .6
        }

        .team-section .swiper-pagination-bullet-active {
            opacity: 1
        }

        .team-section .swiper-button-prev,
        .team-section .swiper-button-next {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: rgba(0, 0, 0, .08);
            backdrop-filter: blur(4px);
            color: hsl(var(--base));
        }

        .team-section .swiper-button-prev:after,
        .team-section .swiper-button-next:after {
            font-size: 16px
        }

        .workshop-slider {
            direction: rtl;
        }

        /*.workshop-slider .swiper-slide {*/
        /*    height: auto;*/
        /*}*/

        /*.workshop-slider .swiper-slide {*/
        /*    width: unset !important;*/
        /*    box-sizing: border-box;*/
        /*}*/


        .workshop-slider .swiper-slide > * {
            margin-left: 0;
            margin-right: 0;
        }

        .workshop-slider .swiper-button-prev,
        .workshop-slider .swiper-button-next {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: rgba(0, 0, 0, .08);
            backdrop-filter: blur(4px);
            color: hsl(var(--base));
        }

        .workshop-slider .swiper-button-prev:after,
        .workshop-slider .swiper-button-next:after {
            font-size: 16px
        }
    </style>
@endpush

@section('content')
    {{--banner section--}}
    <section class="banner-section ">
        <div class="container">
            <div class="row row-gap-5">
                <div class="col-lg-6 align-self-center">
                    <div class="banner-section__content">
                        <h1 class="right-reveal"> موسسه حقوقی <span>دادورزان امین</span></h1>
                        <p class="right-reveal">
                            شرکت حقوقی با وکلای حرفه‌ای و مجرب، حقوق مهاجرتی و مشاوره مالیاتی و مشاوره حقوقی دادگستری و
                            کلیه امور وکالتی
                        </p>
                        <div
                            class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-4 right-reveal">
                            <a href="login.html" class="btn btn--base">
                                شروع کنید
                                <i class="flaticon-right-arrow"></i>
                            </a>
                            <div class="community-content">
                                <div class="img">
                                    <figure class="image-effect">
                                        <img src="{{asset('site/assets/images/community/1.png')}}"
                                             alt="community images">
                                    </figure>
                                    <figure class="image-effect">
                                        <img src="{{asset('site/assets/images/community/2.png')}}"
                                             alt="community images">
                                    </figure>
                                    <div class="numbers">
                                        +۹M
                                    </div>
                                </div>
                                <div class="text">
                                    به <span>جمع مشریان ما</span> بپیوندید
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="position-relative ms-xl-5">
                        <div class="shape-2"></div>
                        <div class="banner-section__img">
                            <figure class="image-effect right-reveal">
                                <img src="{{asset('site/assets/images/banner/b1-new.jpg')}}" alt="banner images"
                                     class="img-fluid w-100">
                            </figure>
                            <figure class="image-effect left-reveal">
                                <img src="{{asset('site/assets/images/banner/b2-new.jpg')}}" alt="banner images"
                                     class="img-fluid w-100">
                            </figure>
                            <figure class="image-effect top-reveal">
                                <img src="{{asset('site/assets/images/banner/b3-new.png')}}" alt="banner images"
                                     class="img-fluid w-100">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--workshop section--}}
    <section>
        <div class="container section-two-bg py-60">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">کارگاه</span>
                        <h2 class="top-reveal">کارگاه های آموزشی ما</h2>
                    </div>
                </div>
            </div>

            <div class="row row-gap-4 mt-60">
                <div class="col-lg-12">
                    <div class="workshop-slider swiper">
                        <div class="swiper-wrapper">
                            @foreach($products as $product)
                                @if($product->product_type == 'workshop')
                                <div class="swiper-slide">
                                    <div class="explore-item">

                                        <div class="explore-img">
                                            <div class="featured-price">{{ number_format((int)$product->price) }} تومان</div>
                                            <figure class="image-effect">
                                                <img src="{{ asset('storage/'.$product->cover) }}" alt="explore images" class="img-fluid w-100" loading="lazy">
                                            </figure>
                                            <h5 class="featured-title">
                                                <a href="{{ url('دپارتمان-اموزش-و-پژوهش/دوره-های-آموزشی/' . $product->slug) }}" style="font-size: 1rem;">
{{--                                                    {{$product->title}}--}}
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="explore-item-footer d-flex align-items-center justify-content-between">
                                            <div class="explore-title">
                                                <div class="img">
                                                    <img src="{{ asset('storage/'.$product->item2) }}" alt="{{$product->item1}}">
                                                </div>
                                                {{$product->item1}}
                                            </div>
                                            <div class="view-list"><i class="fa-solid fa-cart-plus"></i> 341</div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev" aria-label="قبلی"></div>
                        <div class="swiper-button-next" aria-label="بعدی"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--about section--}}
    <section class="about-section section-two-bg py-60">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-lg-6 align-self-center">
                    <div class="about-section__img" dir="ltr">
                        <div class="image-one">
                            <figure class="image-effect right-reveal">
                                <img src="{{asset('site/assets/images/about/about-new1-1.png')}}" alt="about images"
                                     class="img-fluid w-100">
                            </figure>
                        </div>
                        <div class="image-two d-grid">
                            <figure class="image-effect bottom-reveal">
                                <img src="{{asset('site/assets/images/about/2-new2.png')}}" alt="about images"
                                     class="img-fluid w-100">
                            </figure>
                            <figure class="image-effect top-reveal">
                                <img src="{{asset('site/assets/images/about/3-new.png')}}" alt="about images"
                                     class="img-fluid w-100">
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-section__content">
                        <div class="section-title">
                            <span class="sub-title right-reveal">درباره ما</span>
                            <h2 class="right-reveal">
                                ارائه دهنده خدمات جامع حقوقی به سبکی نوین
                            </h2>
                            <p class="right-reveal">
                                تفاوتی ندارد یک کسب و کار کوچک داشته باشید یا یک هلدینگ بین المللی، در برابر چالش‌های
                                حقوقی همواره نیاز به یک مشاور حقوقی با تجربه و قراردادهای منسجم خواهید داشت. موسسه حقوقی
                                دادورزان امین، این امکان را برای شما به ارمغان آورده است تا تمام امور حقوقی و ثبتی خود
                                را بدون دغدغه و به صورت یکپارچه به تیم متخصص و باتجربه‌ای بسپارید که سال‌ها در این حوزه
                                فعالیت داشته و به انواع مسائل و قوانین کسب و کار تسلط بالایی دارند
                            </p>
                            <a href="about.html" class="btn btn--base right-reveal">
                                بیشتر بخوانید
                                <i class="flaticon-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{--service section--}}
    <section class="feature-section py-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">خدمات برای موکلین</span>
                        <h2 class="top-reveal">برخی از خدمات مجموعه ما برای موکلین
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center row-gap-4 mt-60">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-photo-editing"></i>
                        </div>
                        <div class="text">
                            <h5>نظریه شورای حقوقی</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-image-edit"></i>
                        </div>
                        <div class="text">
                            <h5>ایرانیان خارج از کشور</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-camera"></i>
                        </div>
                        <div class="text">
                            <h5>تنظیم قرارداد</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-replace"></i>
                        </div>
                        <div class="text">
                            <h5>تنظیم اوراق قضایی</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center row-gap-4 mt-60">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-photo-editing"></i>
                        </div>
                        <div class="text">
                            <h5>مشاوره</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-image-edit"></i>
                        </div>
                        <div class="text">
                            <h5>داوری</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-camera"></i>
                        </div>
                        <div class="text">
                            <h5>ثبت شرکت</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-replace"></i>
                        </div>
                        <div class="text">
                            <h5>قبول دعاوی</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-120">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">خدمات برای وکلا</span>
                        <h2 class="top-reveal">برخی از خدمات مجموعه ما برای وکلای عزیز
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center row-gap-4 mt-60">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-photo-editing"></i>
                        </div>
                        <div class="text">
                            <h5>نظریه شورای حقوقی</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-image-edit"></i>
                        </div>
                        <div class="text">
                            <h5>توکیل</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-camera"></i>
                        </div>
                        <div class="text">
                            <h5>استعلامات</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="feature-section__item top-reveal">
                        <div class="icon">
                            <i class="flaticon-replace"></i>
                        </div>
                        <div class="text">
                            <h5>مشاوره تخصصی</h5>
                            <p>بر اساس ایده‌های خود، تصاویر منحصر به فرد ایجاد کنید. ماموریت ما این است که این روش را
                                متحول کنیم.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-two-bg py-60 @@services-text-slide">
        <div class="text-slide swiper">
            <div class="swiper-wrapper slide-transition">
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        وکلای حرفه ای
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="{{asset('site/assets/images/shape/star.svg')}}" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        بیش از یک دهه تجربه موفق
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        <img src="{{asset('site/assets/images/shape/star.svg')}}" alt="icon">
                    </div>
                </div>
                <div class="swiper-slide inner-slide-element">
                    <div class="slide-text">
                        خدمات نوین
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


    <section class="working-process-section section-one-bg py-60">
        <div class="container">
            <div class="row row-gap-5">
                <div class="col-xl-6">
                    <div class="section-title">
                        <span class="sub-title right-reveal">فرآیند کار</span>
                        <h2 class="right-reveal">تولید محتوای بسیار سریع‌تر با هوش مصنوعی</h2>
                    </div>
                    <div class="accordion mt-60 ms-xl-5 top-reveal" id="accordionWorking">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    در دعاوی حقوقی تنظیم دادخواست ضروری است؟
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>
                                        بله،با اینکه در دعاوی کیفری می توان بر روی هر برگه ای شکایت را تنظیم نمود ، در
                                        مورد دعاوی حقوقی درخواست رسیدگی الزاما با تقدیم دادخواست صورت می پذیرد .
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    منظور از استشهادیه چیست؟
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>
                                        استشهادیه سندی کتبی می‌باشد که شخصی که شاهد ماجرا می‌باشد گزارش‌های خود را ثبت
                                        می‌کند و برای درست بودن صحبت‌های خود و تضمین اعتبار آن را امضا می‌کند. شهادت
                                        شاهدان با استشهاد برابر نیست و زمانی که شاهد از حضور در دادگاه امتناع ورزیده و
                                        یا تعداد شاهدان برای حضور در دادگاه زیاد باشد از استشهادیه استفاده می‌شود. قبول
                                        استشهادیه از طرف دادگاه شرایط خاص خود را دارد که برای تنظیم استشهادیه بهتر است
                                        با وکیل مشورت کنید.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    وجه التزام در قرارداد چیست؟
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>
                                        می‌توان گفت توافق مالی است در قرارداد که در صورت عدم انجام تعهدات یا تاخیر در
                                        انجام تعهدات شخص خاطی باید پرداخت نماید و یا به عبارت دیگر مبلغی است که در صورت
                                        تخلف از مفاد قرارداد شخص متخلف (فروشنده یا خریدار) ملزم به پرداخت آن است. وجه
                                        التزام در قرارداد در دو نوع 1- وجه التزام بابت عدم اجرای تعهد 2- وجه التزام بابت
                                        تاخیر در اجرای تعهد عنوان می‌شود.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                    در صورت مجهول المکان بودن خوانده چه باید کرد؟
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionWorking">
                                <div class="accordion-body">
                                    <p>
                                        اگر محل سکونت خوانده مشخص نباشد یعنی مجهول المکان باشد، باید مراحل مختلفی همچون
                                        آگهی در روزنامه کثیر الانتشار را طی کنید. در این آگهی باید وقت رسیدگی به خوانده
                                        اعلام شود که بعد از آن رای غیابی صادر شود.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="working-process-section__content" dir="ltr">
                        <div class="process-item bottom-reveal">
                            <div>
                                <div class="icon">
                                    <i class="flaticon-rating-stars"></i>
                                </div>
                                <div class="number">
                                    <span class="odometer" data-odometer-final="75">40</span>+
                                </div>
                                <p>مشاوره حقوقی دادگستری</p>
                            </div>
                        </div>
                        <div class="process-item bottom-reveal">
                            <div>
                                <div class="icon">
                                    <i class="flaticon-image-gallery"></i>
                                </div>
                                <div class="number">
                                    <span class="odometer" data-odometer-final="29">10</span>+
                                </div>
                                <p>حقوق مهاجرتی</p>
                            </div>
                        </div>
                        <div class="process-item top-reveal">
                            <div>
                                <div class="icon">
                                    <i class="flaticon-camera"></i>
                                </div>
                                <div class="number">
                                    <span class="odometer" data-odometer-final="9">2</span>/10
                                </div>
                                <p>کلیه امور وکالتی</p>
                            </div>
                        </div>
                        <div class="process-item top-reveal">
                            <div>
                                <div class="icon">
                                    <i class="flaticon-workflow"></i>
                                </div>
                                <div class="number">
                                    <span class="odometer" data-odometer-final="12">9</span>+
                                </div>
                                <p>کارگاه های برگزار شده</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--testimonials section--}}
    <section class="testimonials-section section-one-bg py-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">دیدگاه مشتریان</span>
                        <h2 class="top-reveal">مشتریان ما درباره دادورزان امین می‌گویند</h2>
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
                                        <p>
                                            همکاری با مؤسسه حقوقی دادورزان امین تجربه‌ای آرامش‌بخش و مطمئن برای من بود.
                                            تیم حرفه‌ای وکلا با دقت و تخصص تمام مراحل پرونده‌ام را پیگیری کردند و همیشه
                                            با صبر و شفافیت پاسخگوی سؤالاتم بودند. نتیجه‌ای که به دست آمد بسیار فراتر از
                                            انتظاراتم بود و باعث شد ارزش واقعی داشتن یک همراه حقوقی متخصص را درک کنم.
                                        </p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('site/assets/images/testimonial/1.jpg')}}" alt="user">
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
                                        <p>
                                            دادورزان امین نه‌تنها در حوزه حقوقی و وکالت تخصص بالایی دارند، بلکه برخورد
                                            انسانی و تعهد کاری آنان تحسین‌برانگیز است. از همان ابتدای کار، احساس امنیت و
                                            اعتماد کامل داشتم و مطمئن بودم پرونده من در بهترین دستان قرار دارد. بدون
                                            تردید این مجموعه را به هر کسی که به خدمات حقوقی دقیق و مطمئن نیاز دارد توصیه
                                            می‌کنم.
                                        </p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('site/assets/images/testimonial/2.jpg')}}" alt="user">
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
                                        <p>در برخورد با مسائل حقوقی همیشه نگرانی و استرس وجود دارد، اما با انتخاب
                                            دادورزان امین تمام این دغدغه‌ها از بین رفت. وکلای این مؤسسه با تسلط کامل بر
                                            قوانین و ارائه راهکارهای عملی، مسیر پرونده را برایم روشن کردند. تجربه‌ای که
                                            به من اعتماد و آرامش خاطر داد.</p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('site/assets/images/testimonial/1.jpg')}}" alt="user">
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
                                        <p>آنچه دادورزان امین را از سایر مؤسسات متمایز می‌کند، ترکیب دانش حقوقی عمیق با
                                            مسئولیت‌پذیری واقعی است. در تمام مراحل پرونده‌ام، شفافیت و پیگیری منظم را به
                                            وضوح دیدم. نتیجه موفقیت‌آمیز پرونده باعث شد مطمئن شوم انتخاب درستی
                                            داشته‌ام.</p>

                                        <div class="user">
                                            <div class="img">
                                                <img src="{{asset('site/assets/images/testimonial/2.jpg')}}" alt="user">
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

    <section class="call-to-action-section section-base-bg py-60">
        <div class="container">
            <div class="row row-gap-5 justify-content-between">
                <div class="col-lg-6 col-xl-5 align-self-center">
                    <div class="section-title">
                        <span class="sub-title right-reveal">اکنون به ما بپیوندید</span>
                        <h2 class="right-reveal">دیگر نگران مسائل حقوقی خود نباشید</h2>
                        <p class="right-reveal">ماموریت ما این است که با بهره‌گیری از تجربه و دانش خود بهترین نتیجه ممکن
                            را برای شما رقم بزنیم.

                        </p>
                        <a href="login.html" class="btn btn--black right-reveal">
                            رایگان ثبت نام کنید
                            <i class="flaticon-right-arrow"></i>
                        </a>
                    </div>
                </div>
{{--                <div class="col-lg-6 align-self-center">--}}
{{--                    <div class="call-to-action-section__img" dir="ltr">--}}
{{--                        <figure class="image-effect right-reveal">--}}
{{--                            <img src="{{asset('site/assets/images/call-to-action/1.jpg')}}" alt="action images"--}}
{{--                                 class="img-fluid w-100">--}}
{{--                        </figure>--}}
{{--                        <figure class="image-effect left-reveal">--}}
{{--                            <img src="{{asset('site/assets/images/call-to-action/2.jpg')}}" alt="action images"--}}
{{--                                 class="img-fluid w-100">--}}
{{--                        </figure>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>

    <section class="blog-section section-one-bg py-60">
        <div class="container">
            <div class="row row-gap-4 justify-content-center">
                <div class="col-md-8 align-self-end">
                    <div class="section-title">
                        <span class="sub-title right-reveal">مقالات اخیر</span>
                        <h2 class="right-reveal">آخرین اخبار و مقالات حقوقی</h2>
                    </div>
                </div>
                <div class="col-md-4 align-self-end">
                    <div class="text-start pb-2">
                        <a href="{{url('دپارتمان-اموزش-و-پژوهش/محتوای-آموزشی')}}" class="btn btn--base left-reveal">
                            مشاهده مقالات
                            <i class="flaticon-right-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mt-60">
                <div class="col-lg-12">
                    <div class="blog-slider swiper">
                        <div class="swiper-wrapper">
{{--                            @foreach($posts as $post)--}}
{{--                                <div class="swiper-slide">--}}
{{--                                    <div class="blog-grid-item">--}}
{{--                                        <div class="blog-date">--}}
{{--                                            <div class="bar-icon"></div>--}}
{{--                                            {{jdate($post->updated_at)->ago()}}--}}
{{--                                        </div>--}}
{{--                                        <a href="{{url('محتوای-آموزشی/'.$post->slug)}}">--}}
{{--                                            <figure class="image-effect">--}}
{{--                                                <img src="{{asset($post->image)}}" alt="{{$post->title}}"--}}
{{--                                                     class="img-fluid w-100">--}}
{{--                                            </figure>--}}
{{--                                        </a>--}}
{{--                                        <div class="post-type">--}}
{{--                                            آموزش--}}
{{--                                            <div class="bar-icon2"></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="blog-content">--}}
{{--                                            <h4>--}}
{{--                                                <a href="{{url('محتوای-آموزشی/'.$post->slug)}}">{{ Str::words(preg_replace('/&[^;]+;/', ' ', strip_tags($post->description)), 10, ' ...') }}</a>--}}
{{--                                            </h4>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            @endforeach--}}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="company-section section-two-bg py-60">
        <div class="container">
            <div class="row mb-60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="sub-title top-reveal">موکلین</span>
                        <h2 class="top-reveal">برخی از موکلین ما</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="company-slide swiper">
                        <div class="swiper-wrapper slide-transition">
{{--                            @foreach($customers as $customer)--}}
{{--                                <div class="customer-slide swiper-slide inner-slide-element">--}}
{{--                                    <img src="{{$customer->image}}" alt="{{$customer->name}}">--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-section section-one-bg py-60">
        <div class="container">
            <div class="row row-gap-4 justify-content-between align-items-end">
                <div class="col-md-8 align-self-end">
                    <div class="section-title">
                        <span class="sub-title right-reveal">تیم ما</span>
                        <h2 class="right-reveal">اعضای کلیدی</h2>
                    </div>
                </div>
                <div class="col-md-4 align-self-end">
                    <div class="text-start pb-2">
                        <a href="/team" class="btn btn--base left-reveal">
                            مشاهده همه
                            <i class="flaticon-right-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-60">
                <div class="col-lg-12">
                    <div class="team-slider swiper">
                        <div class="swiper-wrapper">
                            @foreach($emploees as $emploee)
                                <div class="swiper-slide">
                                    <div class="team-item">
                                        <figure class="image-effect">
                                            <img src="{{ asset('storage/'.$emploee->image) }}" alt="{{ $emploee->fullname }}"
                                                 class="img-fluid w-100" loading="lazy">
                                        </figure>
                                        <ul class="social">
                                            <li>
                                                <a href="mailto:info@dadvarzanamin.ir" target="_blank">
                                                    <i class="fas fa-envelope"></i>
                                                </a>
                                            </li>
{{--                                            <li><a href="https://www.instagram.com/" target="_blank"><i--}}
{{--                                                        class="fab fa-instagram"></i></a></li>--}}
{{--                                            <li><a href="https://www.pinterest.com/" target="_blank"><i--}}
{{--                                                        class="fa-brands fa-pinterest-p"></i></a></li>--}}
                                        </ul>
                                        <div class="name-details">
                                            <h4>
                                                <a href="{{ url('تیم-ما/رزومه/'.$emploee->slug) }}">{{ $emploee->fullname }}</a>
                                            </h4>
                                            <p>{{ $emploee->side }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev" aria-label="قبلی"></div>
                        <div class="swiper-button-next" aria-label="بعدی"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('page_scripts')
    {{--    <script>--}}
    {{--        document.addEventListener('DOMContentLoaded', function () {--}}
    {{--            const el = document.querySelector('.team-slider');--}}
    {{--            if (!el) return;--}}

    {{--            const teamSwiper = new Swiper(el, {--}}
    {{--                speed: 500,--}}
    {{--                spaceBetween: 20,--}}
    {{--                loop: true,--}}
    {{--                grabCursor: true,--}}
    {{--                rtlTranslate: true,--}}

    {{--                // 🔧 مهم برای وقتی اسلایدر داخل تب/اکاردئون/بخش مخفی است--}}
    {{--                observer: true,--}}
    {{--                observeParents: true,--}}
    {{--                observeSlideChildren: true,--}}
    {{--                // وقتی تعداد اسلایدها کم است، از خراب شدن چیدمان جلوگیری می‌کند--}}
    {{--                watchOverflow: true,--}}

    {{--                pagination: {--}}
    {{--                    el: '.team-section .swiper-pagination',--}}
    {{--                    clickable: true--}}
    {{--                },--}}
    {{--                navigation: {--}}
    {{--                    nextEl: '.team-section .swiper-button-next',--}}
    {{--                    prevEl: '.team-section .swiper-button-prev',--}}
    {{--                },--}}
    {{--                keyboard: {enabled: true},--}}

    {{--                // اتوپلی رو فعلاً خاموش می‌گذاریم تا برای دیباگ "وایسته"--}}
    {{--                autoplay: {delay: 3500, disableOnInteraction: false},--}}

    {{--                slidesPerView: 1,--}}
    {{--                breakpoints: {--}}
    {{--                    576: {slidesPerView: 2, spaceBetween: 20},--}}
    {{--                    992: {slidesPerView: 3, spaceBetween: 24},--}}
    {{--                    1200: {slidesPerView: 4, spaceBetween: 28}--}}
    {{--                }--}}
    {{--            });--}}

    {{--            // اگر این سکشن داخل تب/آف‌کانواس/مدال باز می‌شود، حتماً آپدیت بزن:--}}
    {{--            // مثال با بوت‌استرپ تب:--}}
    {{--            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(t =>--}}
    {{--                t.addEventListener('shown.bs.tab', () => teamSwiper.update())--}}
    {{--            );--}}

    {{--            // دیباگ کنسول--}}
    {{--            window.teamSwiper = teamSwiper;--}}
    {{--            // console tips:--}}
    {{--            // teamSwiper.update(); teamSwiper.slideNext();--}}
    {{--        });--}}
    {{--    </script>--}}

    {{--    <script>--}}
    {{--        document.addEventListener('DOMContentLoaded', function () {--}}
    {{--            const slider = document.querySelector('.workshop-slider');--}}
    {{--            if (!slider) return;--}}

    {{--            const swiper = new Swiper(slider, {--}}
    {{--                speed: 500,--}}
    {{--                spaceBetween: 20,--}}
    {{--                grabCursor: true,--}}

    {{--                // ❌ بدون لوپ، بدون ری‌وایند--}}
    {{--                loop: false,--}}
    {{--                rewind: false,--}}
    {{--                watchOverflow: true,--}}

    {{--                // اگر داخل تب/آکاردئون است--}}
    {{--                observer: true,--}}
    {{--                observeParents: true,--}}
    {{--                observeSlideChildren: true,--}}
    {{--                updateOnWindowResize: true,--}}

    {{--                // اگر قبلاً autoplay داشتی، پاک کن:--}}
    {{--                // autoplay: undefined,--}}

    {{--                pagination: {--}}
    {{--                    el: slider.querySelector('.swiper-pagination'),--}}
    {{--                    clickable: true--}}
    {{--                },--}}
    {{--                navigation: {--}}
    {{--                    nextEl: slider.querySelector('.swiper-button-next'),--}}
    {{--                    prevEl: slider.querySelector('.swiper-button-prev')--}}
    {{--                },--}}
    {{--                keyboard: {enabled: true},--}}

    {{--                slidesPerView: 3,--}}
    {{--                slidesPerGroup: 1,--}}
    {{--                breakpoints: {--}}
    {{--                    576: {slidesPerView: 2, spaceBetween: 20, slidesPerGroup: 1},--}}
    {{--                    992: {slidesPerView: 3, spaceBetween: 24, slidesPerGroup: 1},--}}
    {{--                    1200: {slidesPerView: 3, spaceBetween: 28, slidesPerGroup: 1}--}}
    {{--                }--}}
    {{--            });--}}

    {{--            window.workshopSwiper = swiper;--}}
    {{--        });--}}
    {{--    </script>--}}
@endpush

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
                            ما با تکیه بر وکلای متخصص و باتجربه، خدمات جامع حقوقی از جمله امور دعاوی، قراردادها،
                            شرکت‌ها، مهاجرت، مالیات، خانواده، کیفری و مشاوره‌های تخصصی را به اشخاص و کسب‌وکارها ارائه
                            می‌دهیم
                            {{--                            ما با بهره‌گیری از تیمی متشکل از وکلای پایه‌یک، متخصصان حقوقی و مشاوران ارشد، ارائه‌دهنده‌ی طیف کاملی از خدمات حقوقی در حوزه‌های دعاوی دادگستری، تنظیم و بررسی قراردادها، حقوق تجارت و شرکت‌ها، داوری و میانجی‌گری، امور ثبتی و مالکیت فکری، مهاجرت و اقامت، مشاوره مالیاتی، امور خانواده، کیفری و کلیه خدمات وکالتی تخصصی است. رویکرد ما ارائه راهکارهای دقیق، حرفه‌ای و قابل اتکا برای اشخاص حقیقی و حقوقی در تمامی حوزه‌های حقوقی است.--}}
                        </p>
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
        <div class="container section-two-bg py-40">
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
                                                <div class="featured-price">{{ number_format((int)$product->price) }}
                                                    تومان
                                                </div>
                                                <figure class="image-effect">
                                                    <img src="{{ asset('storage/'.$product->cover) }}"
                                                         alt="explore images" class="img-fluid w-100" loading="lazy">
                                                </figure>
                                            </div>
                                            <div
                                                class="explore-item-footer d-flex align-items-center justify-content-between">
                                                <div class="explore-title">
                                                    {{--                                                <div class="img">--}}
                                                    {{--                                                    <img src="{{ asset('storage/'.$product->item2) }}" alt="{{$product->item1}}">--}}
                                                    {{--                                                </div>--}}
                                                    <h5>
                                                        <a class="name-details"
                                                           href="{{ url('دپارتمان-اموزش-و-پژوهش/دوره-های-آموزشی/' . $product->slug) }}"
                                                           style="font-size: 1rem;">
                                                            {{$product->title}}
                                                        </a>
                                                    </h5>
                                                </div>

                                                {{--                                            <div class="view-list"><i class="fa-solid fa-cart-plus"></i> 341</div>--}}
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
                            <h2 class="right-reveal" style="font-size: 2rem">
                                ارائه دهنده خدمات جامع حقوقی به سبکی نوین
                            </h2>
                            <p class="right-reveal" style="text-align: justify">
                                چه صاحب یک کسب‌وکار نوپا باشید و چه مدیر یک هلدینگ بین‌المللی، مواجهه با چالش‌های حقوقی
                                همواره نیازمند مشاوری باتجربه و قراردادهایی منسجم است. موسسه حقوقی دادورزان امین این
                                امکان را فراهم کرده است تا تمامی امور حقوقی و ثبتی خود را با آسودگی خاطر به تیمی متخصص،
                                باتجربه و آشنا به قوانین و الزامات کسب‌وکار بسپارید؛ تیمی که سال‌ها در این حوزه فعالیت
                                کرده و پاسخگوی طیف گسترده‌ای از نیازهای حقوقی شما خواهد بود.
                            </p>

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
                            <p style="text-align: justify">
                                ارائه تحلیل تخصصی و مستند برای پرونده‌ها جهت اتخاذ تصمیمات حقوقی دقیق و مطمئن.
                            </p>
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
                            <p style="text-align: justify">
                                ارائه خدمات حقوقی کامل برای ایرانیان خارج کشور با تمرکز بر مسائل و قوانین مهاجرتی.
                            </p>
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
                            <p style="text-align: justify">
                                تنظیم و بررسی انواع قراردادهای تخصصی برای تضمین حقوق طرفین و جلوگیری از اختلافات.
                            </p>
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
                            <p style="text-align: justify">تهیه و تنظیم اوراق قضایی رسمی مطابق استانداردهای دادگستری
                                برای پیگیری صحیح پرونده‌ها.
                            </p>
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
                            <p style="text-align: justify">
                                ارائه مشاوره حقوقی دقیق و قابل اتکا جهت یافتن بهترین راهکار برای مشکلات مختلف.
                            </p>
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
                            <p style="text-align: justify">
                                رسیدگی به اختلافات قراردادی از طریق داوری تخصصی با هدف حل‌وفصل سریع و قانونی.
                            </p>
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
                            <p style="text-align: justify">
                                انجام مراحل ثبت شرکت و تغییرات ثبتی با رعایت کامل مقررات و قوانین تجارت به روز کشور.
                            </p>
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
                            <p style="text-align: justify">
                                پذیرش و پیگیری دعاوی حقوقی توسط وکلای متخصص برای دستیابی به نتیجه‌ای مطلوب.
                            </p>
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
                        <h2 class="top-reveal">برخی از خدمات مجموعه ما برای وکلای عزیز</h2>
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
                            <p style="text-align: justify">
                                ارائه تحلیل تخصصی و مستند برای پرونده‌ها جهت اتخاذ تصمیمات حقوقی دقیق و مطمئن.

                            </p>
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
                            <p style="text-align: justify">
                                اعطای وکالت رسمی برای انجام امور حقوقی و اداری با رعایت قوانین لازم بر مبنای اصولی.
                            </p>
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
                            <p style="text-align: justify">
                                انجام استعلامات رسمی در حوزه املاک، شرکت‌ها و دعاوی جهت بررسی وضعیت قانونی.
                            </p>
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
                            <p style="text-align: justify">
                                ارائه مشاوره تخصصی در موضوعات پیچیده حقوقی برای اتخاذ تصمیم‌های دقیق و مؤثر.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="working-process-section section-one-bg py-60">
        <div class="container">
            <div class="row row-gap-5">
                <div class="col-xl-6">
                    <div class="section-title">
                        <span class="sub-title right-reveal">فرآیند کار</span>
                        <h2 class="right-reveal">برخی از فعالیت های ما</h2>
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

    <section class="blog-section section-one-bg py-60">
        <div class="container">
            <div class="row row-gap-4 justify-content-center">
                <div class="col-md-8 align-self-end">
                    <div class="section-title">
                        <span class="sub-title right-reveal">محتوا</span>
                        <h2 class="right-reveal">محتوای آموزشی ما</h2>
                    </div>
                </div>
                <div class="col-md-4 align-self-end">
                    <div class="text-start pb-2">
                        <a href="{{url('دپارتمان-اموزش-و-پژوهش/محتوای-آموزشی')}}" class="btn btn--base left-reveal">
                            مشاهده بیشتر
                            <i class="flaticon-right-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mt-60">
                <div class="col-lg-12">
                    <div class="blog-slider swiper">
                        <div class="swiper-wrapper">
                            @foreach($posts as $post)
                                <div class="swiper-slide">
                                    <div class="blog-grid-item">
                                        <div class="blog-date">
                                            <div class="bar-icon"></div>
                                            {{jdate($post->updated_at)->ago()}}
                                        </div>
                                        <a href="{{url('محتوای-آموزشی/'.$post->slug)}}">
                                            <figure class="image-effect">
                                                <img src="{{asset('storage/'.$post->cover)}}" alt="{{$post->title}}"
                                                     class="img-fluid w-100">
                                            </figure>
                                        </a>
                                        <div class="post-type">
                                            آموزش
                                            <div class="bar-icon2"></div>
                                        </div>
                                        <div class="blog-content">
                                            <h4>
                                                <a href="{{url('محتوای-آموزشی/'.$post->slug)}}">{{ Str::words(preg_replace('/&[^;]+;/', ' ', strip_tags($post->description)), 10, ' ...') }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
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
                    <div class="company-slide swiper py-2">
                        <div class="swiper-wrapper slide-transition">
                            @foreach($customers as $customer)
                                <div class="customer-slide swiper-slide inner-slide-element">
                                    <img src="{{asset('storage/'.$customer->image)}}" alt="{{$customer->name}}">
                                </div>
                            @endforeach
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
                            مشاهده بیشتر
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
                                            <img src="{{ asset('storage/'.$emploee->image) }}"
                                                 alt="{{ $emploee->fullname }}"
                                                 class="img-fluid w-100" loading="lazy">
                                        </figure>
                                        <ul class="social">
                                            <li>
                                                <a href="mailto:info@dadvarzanamin.ir" target="_blank">
                                                    <i class="fas fa-envelope"></i>
                                                </a>
                                            </li>
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

@endpush

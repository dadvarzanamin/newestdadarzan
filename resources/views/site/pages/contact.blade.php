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
                        <h2 class="breadcrumb__title"> تماس با ما</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="{{url('/')}}"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> تماس با ما</span>
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
    =====>> Contact <<======= -->
    <section class="contact-section py-120">
        <div class="container">
            <div class="row row-gap-4 justify-content-center">
                <div class="col-md-4 col-sm-6">
                    <div class="contact-info-item top-reveal">
                        <i class="fa-solid fa-phone-volume"></i>
                        <h4>تماس :</h4>
                        <p>
                            <a href="tel:02188438191">02188438191</a>
                            <br>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="contact-info-item top-reveal">
                        <i class="fa-solid fa-location-dot"></i>
                        <h4>آدرس :</h4>
                        <p>
                            تهران، خیابان شریعتی، نبش کوچه شهید جعفرزاده، پلاک ۴۹۲
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="contact-info-item top-reveal">
                        <i class="fa-solid fa-envelope"></i>
                        <h4>ایمیل :</h4>
                        <p>
                            <a href="https://www.iarsalan.ir/template/pixgix/pixgix/index.htmlcdn-cgi/l/email-protection#f1828481819e8385b1949c90989ddf929e9c"><span
                                    class="__cf_email__" data-cfemail="a3d0d6d3d3ccd1d7e3c6cec2cacf8dc0ccce">info@dadvarzanamin.ir</span></a>
                            <br>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row pt-120">
                <div class="col-md-12">
                    <div class="touch-contact">
                        <div class="touch-left">
                            <h2>با ما در ارتباط باشید</h2>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d296.24083468274006!2d51.442316609586406!3d35.72147302633778!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2s!4v1763214137337!5m2!1sen!2s"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="touch-right">
                            <form
                                action="https://www.iarsalan.ir/template/pixgix/pixgix/index.htmlhtml/pixgix/pixgix/index.html">
                                <input type="text" class="form-control" placeholder="نام و نام خانوادگی*">
                                <input type="email" class="form-control" placeholder="ایمیل خود را وارد کنید*">
                                <input type="text" class="form-control" placeholder="شماره تماس*">
                                <textarea name="messages" class="form-control"
                                          placeholder="پیام خود را بنویسید"></textarea>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        نام و ایمیل من را در مرورگر ذخیره کن
                                    </label>
                                </div>
                                <div class="button">
                                    <button type="submit" class="btn btn--base">
                                        ارسال پیام
                                        <i class="flaticon-right-arrow"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Contact <<=====
    =========================== -->

@endsection

@extends('site.layouts.base')

@section('title', 'بلاگ های ما')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title"> سایدبار مقالات</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="index.html"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> سایدبار مقالات</span>
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
    =====>> Blog <<======= -->
    <section class="blog-section section-one-bg py-120">
        <div class="container">
            <div class="row row-gap-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="row row-gap-5">
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۲۱ تیر ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/1.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    مدرن
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">۵ روند برتر تولید تصویر هوش مصنوعی که باید در سال ۲۰۲۵ به آنها توجه کرد</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۹ خرداد ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/2.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    کسب و کار
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">راهنمای گام به گام برای ایجاد آثار هنری تولید شده توسط هوش مصنوعی</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۲۱ تیر ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/3.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    خلاقانه
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">چگونه کسب‌وکارها می‌توانند از تصاویر تولید شده توسط هوش مصنوعی بهره ببرند</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۱ مرداد ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/4.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    کسب و کار
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">چگونه هوش مصنوعی در حال تغییر تولید محتوای رسانه‌های اجتماعی است</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۲۳ تیر ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/5.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    خلاقانه
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">طراحی مبتنی بر هوش مصنوعی، آینده خلق گرافیک از راه رسیده است</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۱۶ خرداد ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/6.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    مدرن
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">بهبود تجارت الکترونیک با تصاویر محصول تولید شده توسط هوش مصنوعی</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۲۱ تیر ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/7.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    مدرن
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">آینده هنر هوش مصنوعی: چگونه فناوری در حال تغییر شکل خلاقیت است</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-grid-item">
                                <div class="blog-date">
                                    <div class="bar-icon"></div>
                                    ۱۵ تیر ۱۴۰۴
                                </div>
                                <a href="blog-details.html">
                                    <figure class="image-effect">
                                        <img src="assets/images/blog/8.jpg" alt="blog images"
                                             class="img-fluid w-100">
                                    </figure>
                                </a>
                                <div class="post-type">
                                    کسب و کار
                                    <div class="bar-icon2"></div>
                                </div>
                                <div class="blog-content">
                                    <h4>
                                        <a href="blog-details.html">هوش مصنوعی و آینده تولید محتوای شخصی‌سازی‌شده</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <nav class="mt-4">
                                <ul class="pagination justify-content-start">
                                    <!-- <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            </li> -->
                                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                 viewBox="0 0 12 12" fill="none">
                                                <path
                                                    d="M0.919894 9.8906L0.389563 10.4209L1.45022 11.4816L1.98055 10.9513L0.919894 9.8906ZM10.9511 1.98068C11.244 1.68778 11.244 1.21291 10.9511 0.920016C10.6582 0.627123 10.1834 0.627123 9.89048 0.920016L10.9511 1.98068ZM4.05069 0.920016L3.52036 0.389686L2.4597 1.45035L2.99003 1.98068L4.05069 0.920016ZM10.5631 2.16987C10.9605 2.05298 11.1879 1.63609 11.071 1.23871C10.9541 0.841329 10.5372 0.613942 10.1398 0.730826L10.5631 2.16987ZM9.85577 8.84647L10.3861 9.3768L11.4468 8.31614L10.9164 7.78581L9.85577 8.84647ZM1.98055 10.9513L10.9164 2.01538L9.85577 0.95472L0.919894 9.8906L1.98055 10.9513ZM10.9164 2.01538L10.9511 1.98068L9.89048 0.920016L9.85577 0.95472L10.9164 2.01538ZM2.99003 1.98068C3.56242 2.55307 4.39645 2.77289 5.16658 2.85147C5.96028 2.93247 6.82919 2.87704 7.61351 2.77648C8.40337 2.67521 9.13805 2.52402 9.67308 2.39901C9.9414 2.33631 10.1614 2.27974 10.3154 2.23855C10.3925 2.21794 10.4531 2.20116 10.4951 2.18933C10.5161 2.18342 10.5324 2.17875 10.5438 2.17545C10.5496 2.17381 10.554 2.17251 10.5573 2.17157C10.5589 2.1711 10.5602 2.17072 10.5611 2.17044C10.5616 2.1703 10.562 2.17018 10.5624 2.17008C10.5625 2.17003 10.5627 2.16998 10.5628 2.16996C10.5629 2.16991 10.5631 2.16987 10.3515 1.45035C10.1398 0.730826 10.1399 0.730796 10.14 0.730771C10.14 0.730771 10.1401 0.730752 10.1401 0.730752C10.1401 0.73075 10.14 0.730772 10.1398 0.730817C10.1395 0.730907 10.1389 0.731089 10.138 0.73136C10.1361 0.731905 10.133 0.732807 10.1287 0.734052C10.12 0.736541 10.1066 0.740396 10.0885 0.745476C10.0524 0.755638 9.99813 0.770689 9.92779 0.789503C9.78705 0.827154 9.58258 0.879752 9.33178 0.938353C8.82857 1.05593 8.14659 1.19586 7.42275 1.28866C6.69338 1.38218 5.95155 1.42379 5.31886 1.35922C4.6626 1.29226 4.25459 1.12392 4.05069 0.920016L2.99003 1.98068ZM10.3861 1.48505C9.69571 1.19202 9.69563 1.19221 9.69554 1.19242C9.6955 1.19252 9.69541 1.19275 9.69533 1.19294C9.69517 1.19331 9.69498 1.19376 9.69476 1.19429C9.69431 1.19534 9.69375 1.19668 9.69306 1.19831C9.69169 1.20157 9.68985 1.20599 9.68755 1.21154C9.68295 1.22263 9.67653 1.23824 9.66848 1.25813C9.65239 1.2979 9.62977 1.35485 9.60212 1.42713C9.54686 1.57157 9.47132 1.77783 9.38771 2.03093C9.22117 2.53511 9.01938 3.23492 8.88404 4.00797C8.74952 4.77635 8.67495 5.64847 8.78362 6.48652C8.89246 7.32593 9.19288 8.18359 9.85577 8.84647L10.9164 7.78581C10.5616 7.43097 10.3531 6.92588 10.2712 6.29363C10.189 5.66004 10.2417 4.95159 10.3616 4.26663C10.4807 3.58634 10.6605 2.96003 10.812 2.50142C10.8874 2.27312 10.955 2.08882 11.0031 1.96305C11.0271 1.90022 11.0463 1.85215 11.059 1.82068C11.0654 1.80495 11.0701 1.79338 11.0731 1.7862C11.0746 1.78261 11.0756 1.78012 11.0762 1.77876C11.0765 1.77808 11.0767 1.77768 11.0767 1.77756C11.0767 1.7775 11.0767 1.77752 11.0767 1.7776C11.0767 1.77765 11.0766 1.77777 11.0766 1.77779C11.0766 1.77792 11.0765 1.77808 10.3861 1.48505Z" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row row-gap-4">
                        <div class="col-12">
                            <div class="sidebar-item">
                                <h5>جستجو کنید</h5>
                                <form action="#">
                                    <input type="text" name="search" placeholder="جستجو کنید..">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-item">
                                <h5>دسته بندی</h5>
                                <ul class="category-file">
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    انتزاعی
                                                </span>
                                            <span class="number">(18) </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    فانتزی
                                                </span>
                                            <span class="number">(12) </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    پرتره
                                                </span>
                                            <span class="number">(16) </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    طبیعت
                                                </span>
                                            <span class="number">(08) </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    حیوانات
                                                </span>
                                            <span class="number">(20) </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    کسب و کار
                                                </span>
                                            <span class="number">(14) </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    محصولات
                                                </span>
                                            <span class="number">(17) </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html">
                                                <span class="category-title">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                    تکنولوژی
                                                </span>
                                            <span class="number">(15) </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-item">
                                <h5>مقالات اخیر</h5>
                                <div class="recent-post">
                                    <div class="recent-post__item">
                                        <figure class="img image-effect">
                                            <img src="assets/images/blog/r1.jpg" alt="blog img">
                                        </figure>
                                        <div class="text">
                                            <div class="date">۲۳ اردیبهشت ۱۴۰۴</div>
                                            <h6><a href="blog-details.html">ظهور هنر هوش مصنوعی: چگونه ماشین‌ها خلاقیت را از نو تعریف می‌کنند</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="recent-post__item">
                                        <figure class="img image-effect">
                                            <img src="assets/images/blog/r2.jpg" alt="blog img">
                                        </figure>
                                        <div class="text">
                                            <div class="date">۱۷ خرداد ۱۴۰۴</div>
                                            <h6><a href="blog-details.html">چگونه کسب‌وکارها از تصاویر تولید شده توسط هوش مصنوعی استفاده می‌کنند</a></h6>
                                        </div>
                                    </div>
                                    <div class="recent-post__item">
                                        <figure class="img image-effect">
                                            <img src="assets/images/blog/r3.jpg" alt="blog img">
                                        </figure>
                                        <div class="text">
                                            <div class="date">۲۲ فروردین ۱۴۰۴</div>
                                            <h6><a href="blog-details.html">بهترین سبک‌های تصویر هوش مصنوعی برای امتحان کردن در پروژه بعدی شما</a></h6>
                                        </div>
                                    </div>
                                    <div class="recent-post__item">
                                        <figure class="img image-effect">
                                            <img src="assets/images/blog/r4.jpg" alt="blog img">
                                        </figure>
                                        <div class="text">
                                            <div class="date">۲۵ تیر ۱۴۰۴</div>
                                            <h6><a href="blog-details.html">مناظر تولید شده توسط هوش مصنوعی، عصر جدیدی از مناظر دیجیتال</a></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-item">
                                <h5>برچسب ها</h5>
                                <div class="tags-list">
                                    <a href="blog-grid.html">هوش‌مصنوعی خلاق</a>
                                    <a href="blog-grid.html">استایل هوش‌مصنوعی</a>
                                    <a href="blog-grid.html">نوآوری هوش‌مصنوعی</a>
                                    <a href="blog-grid.html">عکس هوش‌مصنوعی</a>
                                    <a href="blog-grid.html">آثار هنری هوش‌مصنوعی</a>
                                    <a href="blog-grid.html">قدرت‌گرفته از هوش‌مصنوعی</a>
                                    <a href="blog-grid.html">تولیدشده با هوش‌مصنوعی</a>
                                    <a href="blog-grid.html">تصویر هوش‌مصنوعی</a>
                                    <a href="blog-grid.html">هنر هوش‌مصنوعی</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Blog <<=====
    =========================== -->
@endsection

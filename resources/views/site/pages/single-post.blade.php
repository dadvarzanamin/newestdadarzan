@extends('site.layouts.base')

@section('title', 'بلاگ ما')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb blog-details-breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
{{--                        <div class="breadcrumb__postType">--}}
{{--                            <div class="btn btn--base">کسب و کار</div>--}}
{{--                        </div>--}}
                        <h2 class="breadcrumb__title mt-2">
                            {{$posts->title}}
                        </h2>
                        <ul class="breadcrumb__date">
{{--                            <li>ادمین</li>--}}
{{--                            <li>۴ کامنت</li>--}}
                            <li>۱۵ تیر ۱۴۰۴</li>
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
                    <div class="d-grid row-gap-5">
                        <div class="blog-details-content">
                            @if($posts->file)
                                <video controls preload="metadata" poster="{{asset($posts->image)}}" id="player"
                                       style="width: 100%">
                                    <source src="{{asset($posts->file)}}" type="video/mp4"/>
                                </video>
                            @elseif($posts->aparat)
                                {!! $posts->aparat !!}
                            @endif
                            {!! $posts->description !!}
                        </div>
                        <div class="blogs-tags">
                            <p>
                                <strong>برچسب ها :</strong>
{{--                                @if($posts['keyword'])--}}
{{--                                    @foreach (json_decode($posts['keyword']) as $item)--}}
{{--                                        <li class="mr-2">--}}
{{--                                            <a href="#">{{$item}}</a>--}}
{{--                                            <a href="#">{{$item}}،</a>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
                            </p>
                            <ul class="social">
                                <li>
                                    <a href="https://www.facebook.com/" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.x.com/?lang=en" target="_blank">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            </ul>
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
{{--                        <div class="col-12">--}}
{{--                            <div class="sidebar-item">--}}
{{--                                <h5>دسته بندی</h5>--}}
{{--                                <ul class="category-file">--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    انتزاعی--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(18) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    فانتزی--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(12) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    پرتره--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(16) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    طبیعت--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(08) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    حیوانات--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(20) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    کسب و کار--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(14) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    محصولات--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(17) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="blog-details.html">--}}
{{--                                                <span class="category-title">--}}
{{--                                                    <i class="fa-regular fa-folder-closed"></i>--}}
{{--                                                    تکنولوژی--}}
{{--                                                </span>--}}
{{--                                            <span class="number">(15) </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="sidebar-item">--}}
{{--                                <h5>مقالات اخیر</h5>--}}
{{--                                <div class="recent-post">--}}
{{--                                    <div class="recent-post__item">--}}
{{--                                        <figure class="img image-effect">--}}
{{--                                            <img src="{{asset('site/assets/images/blog/r1.jpg')}}" alt="blog img">--}}
{{--                                        </figure>--}}
{{--                                        <div class="text">--}}
{{--                                            <div class="date">۲۳ اردیبهشت ۱۴۰۴</div>--}}
{{--                                            <h6><a href="blog-details.html">ظهور هنر هوش مصنوعی: چگونه ماشین‌ها خلاقیت را از نو تعریف می‌کنند</a>--}}
{{--                                            </h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="recent-post__item">--}}
{{--                                        <figure class="img image-effect">--}}
{{--                                            <img src="{{asset('site/assets/images/blog/r2.jpg')}}" alt="blog img">--}}
{{--                                        </figure>--}}
{{--                                        <div class="text">--}}
{{--                                            <div class="date">۱۷ خرداد ۱۴۰۴</div>--}}
{{--                                            <h6><a href="blog-details.html">چگونه کسب‌وکارها از تصاویر تولید شده توسط هوش مصنوعی استفاده می‌کنند</a></h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="recent-post__item">--}}
{{--                                        <figure class="img image-effect">--}}
{{--                                            <img src="{{asset('site/assets/images/blog/r3.jpg')}}" alt="blog img">--}}
{{--                                        </figure>--}}
{{--                                        <div class="text">--}}
{{--                                            <div class="date">۲۲ فروردین ۱۴۰۴</div>--}}
{{--                                            <h6><a href="blog-details.html">بهترین سبک‌های تصویر هوش مصنوعی برای امتحان کردن در پروژه بعدی شما</a></h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="recent-post__item">--}}
{{--                                        <figure class="img image-effect">--}}
{{--                                            <img src="{{asset('site/assets/images/blog/r4.jpg')}}" alt="blog img">--}}
{{--                                        </figure>--}}
{{--                                        <div class="text">--}}
{{--                                            <div class="date">۲۵ تیر ۱۴۰۴</div>--}}
{{--                                            <h6><a href="blog-details.html">مناظر تولید شده توسط هوش مصنوعی، عصر جدیدی از مناظر دیجیتال</a></h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-12">
                            <div class="sidebar-item">
                                <h5>برچسب ها</h5>
                                <div class="tags-list">
{{--                                    @if($posts['keyword'])--}}
{{--                                        @foreach (json_decode($posts['keyword']) as $item)--}}
{{--                                            <a href="#">{{$item}}</a>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Blog <<================================ -->
@endsection

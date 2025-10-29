@extends('site.layouts.base')

@section('title', 'عضو تیم')

@section('content')

    <section class="breadcrumb blog-details-breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title mt-2">
                            {{$emploees->fullname}}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-section section-one-bg py-120">
        <div class="container">
            <div class="row row-gap-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="d-grid row-gap-5">
                        <div class="blog-details-content">
                            <h2>{{$emploees->fullname}}</h2>
                            @if($emploees['positions'])
                                @foreach (json_decode($emploees['positions']) as $item)
                                    <h4 class="">{{$item}}</h4>
                                @endforeach
                            @endif
                            <img src="{{asset($emploees->image)}}" alt="blog images">

{{--                            <figure class="image-effect blog-dt-img1">--}}
{{--                                <img src="{{asset($emploees->image)}}" alt="blog images" class="img-fluid w-100">--}}
{{--                            </figure>--}}
                            <div class="tab-pane fade show active" id="about-me" role="tabpanel"
                                 aria-labelledby="about-me-tab">
                                <h6>{{$emploees->position}}</h6>
                                {!! $emploees->description !!}
                            </div>

{{--                            <ul>--}}
{{--                                <li>موضوع اصلی را به‌وضوح مشخص کنید</li>--}}
{{--                                <li>پس‌زمینه و محیط را توصیف کنید</li>--}}
{{--                                <li>سبک هنری و رسانه (مدیوم) را مشخص کنید</li>--}}
{{--                                <li>ترکیب‌بندی، زاویه دید و عمق میدان را در نظر بگیرید</li>--}}
{{--                            </ul>--}}
                        </div>
{{--                        <div class="blogs-tags">--}}
{{--                            <p>--}}
{{--                                <strong>برچسب ها :</strong>--}}
{{--                                <a href="#">خلاقانه،</a>--}}
{{--                                <a href="#">مدرن،</a>--}}
{{--                                <a href="#">عکس‌هوش‌مصنوعی</a>--}}
{{--                            </p>--}}
{{--                            <ul class="social">--}}
{{--                                <li>--}}
{{--                                    <a href="https://www.facebook.com/" target="_blank">--}}
{{--                                        <i class="fab fa-facebook-f"></i>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a href="https://www.x.com/?lang=en" target="_blank">--}}
{{--                                        <i class="fa-brands fa-x-twitter"></i>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a href="https://www.instagram.com/" target="_blank">--}}
{{--                                        <i class="fab fa-instagram"></i>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a href="https://www.linkedin.com/" target="_blank">--}}
{{--                                        <i class="fab fa-linkedin-in"></i>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

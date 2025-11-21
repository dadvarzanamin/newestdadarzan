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
{{--                        <ul class="breadcrumb__date">--}}

{{--                            <li>--}}
{{--                                {{$posts->created_at}}--}}
{{--                                --}}
{{--                            </li>--}}
{{--                        </ul>--}}
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
                                @if($posts['keyword'])
                                    @foreach (json_decode($posts['keyword']) as $item)
                                        <li class="mr-2">
                                            <a href="#">{{$item}}</a>
                                            <a href="#">{{$item}}،</a>
                                        </li>
                                    @endforeach
                                @endif
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
                        <div class="col-12">
                            <div class="sidebar-item">
                                <h5>برچسب ها</h5>
                                <div class="tags-list">
                                    @if($posts['keyword'])
                                        @foreach (json_decode($posts['keyword']) as $item)
                                            <a href="#">{{$item}}</a>
                                        @endforeach
                                    @endif
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

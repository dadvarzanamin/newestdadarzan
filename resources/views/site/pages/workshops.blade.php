@extends('site.layouts.base')

@section('title', 'کارگاه های آموزشی')

@section('content')
    <style>
        .image-effect a {
            display: block;
            position: relative;
            z-index: 2;
        }

    </style>
    {{--    Breadcrumb      --}}
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title">کارگاه ها</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="{{url('/')}}"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> کارگاه ها</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--    End Breadcrumb  --}}

    {{--    Prompt          --}}
    <section class="prompts-section py-120">
        <div class="container">
            <div class="mt-4 d-flex justify-content-center">
                <div class="col-xl-12 col-lg-12 main-content">
                    <div class="row row-gap-4">
                        @foreach($workshops as $workshop)
                            <div class="content-box top-reveal col-xl-4 col-lg-4 col-md-4 ">
                                <div class="explore-item">
                                    <div class="explore-item-header d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            {{--                                            <img src="{{asset('storage/'.$workshop->teacher_image)}}" alt="user">--}}
                                            {{$workshop->teacher}}
                                        </div>
                                    </div>
                                    <div class="explore-img">
                                        <figure class="image-effect">
                                            <a href="{{url('دپارتمان-اموزش-و-پژوهش/دوره-های-آموزشی/'.$workshop->slug)}}">
                                                <img src="{{asset('storage/'.$workshop->cover)}}" alt="explore images"
                                                     class="img-fluid w-100">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="explore-item-footer d-flex align-items-center justify-content-between">

                                        <h5 class="featured-title">
                                            <a href="{{url('دپارتمان-اموزش-و-پژوهش/دوره-های-آموزشی/'.$workshop->slug)}}">{{$workshop->title}}</a>
                                        </h5>
                                        <div class="featured-price">{{ number_format($workshop->price) }} تومان</div>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--    End Prompt      --}}

@endsection

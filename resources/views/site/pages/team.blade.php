@extends('site.layouts.base')

@section('title', 'اعضای تیم')

@section('content')


    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title"> با تیم ما آشنا شوید</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="{{url('/')}}"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> اعضای تیم</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-section section-one-bg py-120">
        <div class="container">
            <div class="row row-gap-4 justify-content-center">
                @foreach($emploees as $emploee)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="team-item top-reveal">
                        <figure class="image-effect ">
                            <img src="{{asset('storage/'.$emploee->image)}}" alt="{{$emploee->fullname}}" class="img-fluid w-100">
                        </figure>
                        <div class="name-details">
                            <h4><a href="{{url('تیم-ما/رزومه/'.$emploee->slug)}}">{{$emploee->fullname}}</a> </h4>
                            <p>{{$emploee->side}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

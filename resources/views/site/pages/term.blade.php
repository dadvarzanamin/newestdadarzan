@extends('site.layouts.base')

@section('title', 'شرایط و ضوابط')

@section('content')

    <section class="breadcrumb blog-details-breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title mt-2">
                            {{$thispage->title}}
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
                            <h2>{{$thispage->title}}</h2>

                            {!! $thispage->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

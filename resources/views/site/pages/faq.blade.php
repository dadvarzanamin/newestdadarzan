@extends('site.layouts.base')

@section('title', 'سوالات متداول')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title"> سوالات متداول</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="index.html"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> سوالات متداول</span>
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
    =====>> Faq <<======= -->
    <section class="faq-section section-one-bg py-120 ">
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-lg-8">
                    <div class="section-title mb-5">
                        <span class="sub-title right-reveal">سوالات متداول</span>
                    </div>
                    <div class="accordion top-reveal" id="accordionWorking">
                        @foreach($questionlists as $questionlist)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $questionlist->id }}">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $questionlist->id }}"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $questionlist->id }}">
                                        {{ $questionlist->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $questionlist->id }}"
                                     class="accordion-collapse collapse"
                                     aria-labelledby="heading{{ $questionlist->id }}"
                                     data-bs-parent="#accordionWorking">
                                    <div class="accordion-body">
                                        <p>{{ $questionlist->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
{{--                    @if($questionlists->hasMorePages())--}}
{{--                        <div class="load-more-btn-box pt-5 text-center">--}}
{{--                            <button type="button" id="loadMore" class="btn theme-btn"><i class="la la-refresh mr-1"></i> بارگذاری بیشتر</button>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
            </div>
        </div>
    </section>
    <!-- =====>> End Faq <<=====
    =========================== -->
@endsection

@extends('site.layouts.base')

@section('title', 'قرارداد ها')

@section('content')
    {{--    Breadcrumb      --}}
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title">نمونه قراردادها</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="index.html"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> قراردادها</span>
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
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-4 align-items-center justify-content-between">
                        <button class=" fs-20 d-flex gap-3 align-items-center filter-btn">
                            <i class="fa-solid fa-sliders"></i>
                            فیلتر
                        </button>
                        <div class="sort-by d-flex gap-3 align-items-center">
                            مرتب سازی بر اساس:
                            <div class="dropdown country__select">
                                <button class="dropdown-toggle country__select_button" type="button"
                                        data-bs-toggle="dropdown">
                                    جدیدترین
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" data-text="Latest">جدیدترین</a></li>
                                    <li><a class="dropdown-item" href="#" data-text="Oldest">قدیمی ترین</a></li>
                                    <li><a class="dropdown-item" href="#" data-text="Low to High">قدیمی به جدید</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-text="High to Low">جدید به قدیمی</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-gap-4 mt-4">
                <div class="col-xl-3 col-lg-4 filter-content">
                    <div class="d-grid row-gap-4">
                        <!-- Search Filter -->
                        <div class="filter-box">
                            <form action="#">
                                <input type="text" placeholder="جستجو کنید.." aria-label="Search">
                                <button type="submit" aria-label="Search Button">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </form>
                        </div>

{{--                        <!-- AI Models Filter -->--}}
{{--                        <div class="filter-box">--}}
{{--                            <h6>مدل های هوش مصنوعی</h6>--}}
{{--                            <div class="filter-check d-grid row-gap-1 mt-3">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="میدجرنی">--}}
{{--                                    <label class="form-check-label" for="میدجرنی">میدجرنی</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="nightCafe">--}}
{{--                                    <label class="form-check-label" for="nightCafe">نایت کافی</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="dalle">--}}
{{--                                    <label class="form-check-label" for="dalle">دال ای</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="leonardoAi">--}}
{{--                                    <label class="form-check-label" for="leonardoAi">لئوناردو</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="stableDiffusion">--}}
{{--                                    <label class="form-check-label" for="stableDiffusion">انتشار پایدار</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="gptgptPrompts">--}}
{{--                                    <label class="form-check-label" for="gptgptPrompts">جی پی تی</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <!-- Category Filter -->--}}
{{--                        <div class="filter-box">--}}
{{--                            <h6>دسته بندی</h6>--}}
{{--                            <div class="filter-check d-grid row-gap-1 mt-3">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="cartoons">--}}
{{--                                    <label class="form-check-label" for="cartoons">کارتون ها</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="nft">--}}
{{--                                    <label class="form-check-label" for="nft">NFT</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="buildings">--}}
{{--                                    <label class="form-check-label" for="buildings">ساختمان ها</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="animals">--}}
{{--                                    <label class="form-check-label" for="animals">حیوانات</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="illustrations">--}}
{{--                                    <label class="form-check-label" for="illustrations">تصاویر</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="art">--}}
{{--                                    <label class="form-check-label" for="art">هنر</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="3d">--}}
{{--                                    <label class="form-check-label" for="3d">سه بعدی</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="wildlife">--}}
{{--                                    <label class="form-check-label" for="wildlife">حیات وحش</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <!-- Price Filter -->--}}
{{--                        <div class="filter-box">--}}
{{--                            <h6>قیمت</h6>--}}
{{--                            <div class="range_container pt-3">--}}
{{--                                <p>بازه قیمتی</p>--}}
{{--                                <div class="sliders_control pt-3">--}}
{{--                                    <input class="fromSlider" type="range" min="0" max="800" value="35">--}}
{{--                                    <input class="toSlider" type="range" min="0" max="800" value="600">--}}
{{--                                </div>--}}
{{--                                <div class="form_control">--}}
{{--                                        <span>--}}
{{--                                            تومان<span class="fromInput">۳۵۰</span> - تومان<span class="toInput">۶۰۰۰</span>--}}
{{--                                        </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                </div>
                <div class="col-xl-9 col-lg-8 main-content">
                    <div class="row row-gap-4">
                        @foreach($contracts as $contract)
                        <div class="content-box top-reveal col-xl-4 col-lg-6 col-md-6 ">
                            <div class="explore-item">
                                <div class="explore-item-header d-flex align-items-center justify-content-between">
                                    <div class="explore-title">
                                        <img src="{{asset('site/assets/images/logo/darklogodadvarzan.png')}}" alt="user">
                                    </div>
                                    <div class="star-list">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                                <div class="explore-img">
                                    <div class="featured-price">{{$contract->price == 0 ? 'رایگان' : number_format($contract->price)}}</div>
                                    <figure class="image-effect">
                                        <img src="{{asset('storage/'.$contract->image)}}" alt="explore images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="heart-content">
                                        <i class="fa-solid fa-heart"></i>
                                        12
                                    </div>
                                    <h5 class="featured-title">
                                        <a href="{{url('نمونه-قراردادها/'.$contract->slug)}}">{{$contract->title}}</a>
                                    </h5>
                                </div>
                                <div class="explore-item-footer d-flex align-items-center justify-content-between">
                                    <div class="explore-title">
                                        <div class="img">
                                            <img src="{{asset('storage/'.$contract->image)}}" alt="explore">
                                        </div>
                                        تیم حقوقی
                                    </div>
                                    <div class="view-list">
                                        <i class="fa-regular fa-eye"></i>
                                        341
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

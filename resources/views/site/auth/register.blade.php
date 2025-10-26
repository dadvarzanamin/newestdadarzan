@extends('site.layouts.base')

@section('title', 'ثبت نام')

@section('content')
    <div class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-content-box">
                        <div class="row row-gap-4">
                            <div class="col-lg-6 order-lg-1 align-self-center">
                                <div class="login-img-box ms-lg-5">
                                    <div class="login-img">
                                        <figure class="image-effect right-reveal">
                                            <img src="{{ asset('site/assets/images/auth/Login-rafiki.svg') }}" alt="action images" class="img-fluid w-100">
                                        </figure>
{{--                                        <figure class="image-effect left-reveal">--}}
{{--                                            <img src="{{ asset('site/assets/images/call-to-action/2.jpg') }}" alt="action images" class="img-fluid w-100">--}}
{{--                                        </figure>--}}
                                    </div>
                                    <div class="text-center mt-4">
                                        <span>اکانت خود را بسازید</span>
                                        <h3>به دادورزان امین خوش آمدید</h3>
                                        <a href="{{ route('home') }}" class="btn btn--black btn--border">
                                            برگشت به خانه
                                            <i class="flaticon-right-arrow"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 align-self-center">
                                {{-- action را به روت واقعی ثبت‌نام تغییر بده --}}
                                <form action="{{ route('register.submit') }}" method="post" novalidate>
                                    @csrf
                                    <div class="row row-gap-4">
                                        <div class="col-12">
                                            <input name="mobile" type="tel" class="form-control" placeholder="شماره موبایل خود را وارد کنید*" required>
                                        </div>
                                        <div class="col-12">
                                            <input name="national_id" type="text" class="form-control" placeholder="کد ملی خود را وارد کنید*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input name="birthdate" type="date" class="form-control" placeholder="تاریخ تولد خود را وارد کنید*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input name="user_type" type="text" class="form-control" placeholder="نوع کاربری*" required>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap row-gap-4 justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">مرا به یاد داشته باش</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="submit-button">
                                                <button type="submit" class="btn btn--base">
                                                    ثبت نام
                                                    <i class="flaticon-right-arrow"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-center">قبلا ثبت نام کردید؟ <a href="{{ route('login') }}">ورود</a></p>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

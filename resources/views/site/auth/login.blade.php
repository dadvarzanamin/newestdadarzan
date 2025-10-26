@extends('site.layouts.base')

@section('title', 'ورود')

@section('content')
    <div class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-content-box">
                        <div class="row row-gap-4">
                            {{-- Image side --}}
                            <div class="col-lg-6 align-self-center">
                                <div class="login-img-box me-lg-5">
                                    <div class="login-img">
                                        <figure class="image-effect right-reveal">
                                            <img src="{{ asset('site/assets/images/auth/Login-rafiki.svg') }}" alt="action images"
                                                 class="img-fluid w-100">
                                        </figure>
{{--                                        <figure class="image-effect left-reveal">--}}
{{--                                            <img src="{{ asset('site/assets/images/call-to-action/2.jpg') }}" alt="action images"--}}
{{--                                                 class="img-fluid w-100">--}}
{{--                                        </figure>--}}
                                    </div>
                                    <div class="text-center mt-4">
                                        <span>وارد حساب کاربری خود شوید</span>
                                        <h3>به دادورزان امین خوش آمدید</h3>
                                        <a href="{{ route('home') }}" class="btn btn--black btn--border">
                                            برگشت به خانه
                                            <i class="flaticon-right-arrow"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Form side --}}
                            <div class="col-lg-6 align-self-center">
                                <form action="{{ route('login.submit') }}" method="post">
                                    @csrf

                                    <input name="mobile" type="tel" class="form-control" placeholder="شماره موبایل*" required>
                                    <input name="password" type="password" class="form-control" placeholder="رمز عبور خود را وارد کنید*" required>

                                    <div class="d-flex flex-wrap row-gap-4 justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">
                                                مرا به یاد داشته باش
                                            </label>
                                        </div>
                                        <a href="{{ route('password.request') }}" class="forgot-text">رمز عبور را فراموش کردید؟</a>
                                    </div>

                                    <div class="submit-button">
                                        <button type="submit" class="btn btn--base">
                                            ورود
                                            <i class="flaticon-right-arrow"></i>
                                        </button>
                                    </div>

                                    <div class="or-form">
                                        <span>یا ادامه با :</span>
                                    </div>

                                    <div class="other-sing">
                                        {{-- Google --}}
                                        <button type="button">
                                            {{-- SVG گوگل --}}
                                            <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"> ... </svg>
                                            <span>گوگل</span>
                                        </button>

                                        {{-- Apple --}}
                                        <button type="button">
                                            {{-- SVG اپل --}}
                                            <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"> ... </svg>
                                            <span>اپل</span>
                                        </button>
                                    </div>

                                    <p class="text-center">
                                        ثبت نام نکرده‌اید؟ <a href="{{ route('register') }}">ثبت نام</a>
                                    </p>
                                </form>
                            </div>
                            {{-- End form side --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

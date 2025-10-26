@extends('site.layouts.base')

@section('title', 'فراموشی رمز عبور')

@section('content')
    <div class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-content-box">
                        <div class="row row-gap-4">
                            <div class="col-lg-12 align-self-center">
                                <form action="#">
                                    <div class="text-left">
                                        <a href="index.html" class="back-home-btn">
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                            برگشت به خانه
                                        </a>
                                    </div>
                                    <input type="email" class="form-control" placeholder="ایمیل خود را وارد کنید*">
                                    <p>برای بازیابی حساب کاربری خود، لطفاً ایمیل یا نام کاربری خود را وارد کنید تا حسابتان پیدا شود.</p>
                                    <div class="submit-button">
                                        <button type="submit" class="btn btn--base">
                                            فراموش کردن رمز عبور
                                            <i class="flaticon-right-arrow"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

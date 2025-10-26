@extends('site.layouts.base')

@section('title', 'صفحه 404')

@section('content')
    <div class="error-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="error-content text-center">
                        <div class="error-icons">
                            <img src="assets/images/error/four.svg" alt="text 4">
                            <img src="assets/images/error/zero.svg" alt="text 4">
                            <img src="assets/images/error/four.svg" alt="text 4">
                        </div>
                        <h2 class="pt-60">اوه! صفحه موردنظر شما پیدا نشد.</h2>
                        <p class="py-4">لینکی که سعی در دسترسی به آن دارید احتمالاً خراب است یا <br> صفحه حذف شده است.</p>
                        <div class="d-flex justify-content-center">
                            <a href="index.html" class="btn btn--base">
                                برگشت به خانه
                                <i class="flaticon-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('site.layouts.base')

@section('title', 'سبد خرید')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title">سبد خرید</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="index.html"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> سبد خرید</span>
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
    =====>> Cart <<======= -->
    <div class="cart-section py-120">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <div class="cart-table">
                            <div class="cart-table__header">
                                <div class="row">
                                    <div class="col-4">عنوان محصول</div>
                                    <div class="col">قیمت</div>
                                    <div class="col">تعداد</div>
                                    <div class="col">مجموع</div>
                                    <div class="col">حذف</div>
                                </div>
                            </div>
                            <div class="cart-table__content">
                                <div class="cart-table-item">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="cart-single-product">
                                                <div class="thumb">
                                                    <img src="assets/images/explore/ex1.jpg" alt="cart thumb">
                                                </div>
                                                <div class="cart-content">
                                                    <p>طراحی خلاقانه</p>
                                                    <div class="star-list">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p><span class="item-price">17</span>تومان</p>
                                        </div>
                                        <div class="col">
                                            <div class="quantity-controls">
                                                <button class="quantity-decrement">-</button>
                                                <span class="quantity-number">1</span>
                                                <button class="quantity-increment">+</button>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p><span class="total-price">17.00</span>تومان</p>
                                        </div>
                                        <div class="col">
                                            <button class="remove-item">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-table-item">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="cart-single-product">
                                                <div class="thumb">
                                                    <img src="assets/images/explore/ex2.jpg" alt="cart thumb">
                                                </div>
                                                <div class="cart-content">
                                                    <p>پرامپت های ترسناک</p>
                                                    <div class="star-list">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p><span class="item-price">17</span>تومان</p>
                                        </div>
                                        <div class="col">
                                            <div class="quantity-controls">
                                                <button class="quantity-decrement">-</button>
                                                <span class="quantity-number">2</span>
                                                <button class="quantity-increment">+</button>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p><span class="total-price">17.00</span>تومان</p>
                                        </div>
                                        <div class="col">
                                            <button class="remove-item">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-table-item">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="cart-single-product">
                                                <div class="thumb">
                                                    <img src="assets/images/explore/ex3.jpg" alt="cart thumb">
                                                </div>
                                                <div class="cart-content">
                                                    <p>پرامپت لوگو</p>
                                                    <div class="star-list">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p><span class="item-price">17</span>تومان</p>
                                        </div>
                                        <div class="col">
                                            <div class="quantity-controls">
                                                <button class="quantity-decrement">-</button>
                                                <span class="quantity-number">1</span>
                                                <button class="quantity-increment">+</button>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p><span class="total-price">17.00</span>تومان</p>
                                        </div>
                                        <div class="col">
                                            <button class="remove-item">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="prompts.html" class="btn btn--border">
                            ادامه خرید
                            <i class="flaticon-right-arrow"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-grid row-gap-4">
                        <div class="coupon-section">
                            <input type="text" id="coupon" placeholder="کد تخفیف را وارد کنید..">
                            <button id="apply-coupon" class="btn btn--base">
                                اجرا
                            </button>
                        </div>
                        <div class="cart-summary">
                            <p>جمع جزئی: <span>تومان220.00</span></p>
                            <p>ارسال: <span>۰.۰۰تومان</span></p>
                            <p>مالیات : <span>تومان22.50</span></p>
                            <hr>
                            <p>مجموع : <span>تومان272.50</span></p>
                            <a href="checkout.html" class="btn btn--base">
                                تسویه حساب
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =====>> End Cart <<=====
    =========================== -->
    <!-- ===========================
    =====>> Company <<======= -->
    <div class="company-section section-two-bg py-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="company-slide swiper">
                        <div class="swiper-wrapper slide-transition">
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/1.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/2.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/3.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/4.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/5.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/1.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/2.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/3.png" alt="Company Image">
                            </div>
                            <div class="swiper-slide inner-slide-element">
                                <img src="assets/images/company/4.png" alt="Company Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =====>> End Company <<=====
    =========================== -->
@endsection

@extends('layouts.base')
@section('title', 'مدیریت منوی داشبورد')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/select2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/rateyo/rateyo.css') }}"/>
    <link rel="stylesheet" href="{{asset("assets/vendor/css/pages/wizard-ex-checkout.css")}}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style> table {
            margin: 0 auto;
            width: 100% !important;
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
        }

        .dt-layout-start {
            margin-right: 0 !important;
        }

        .dt-layout-end {
            margin-left: 0 !important;
        }</style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">سبد خرید/</span> پرداخت
            </h4>
            <!-- Checkout Wizard -->
            <div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example mt-2">
                <div class="bs-stepper-header m-lg-auto mx-2 border-0">
                    <div class="step" data-target="#checkout-cart">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-icon">
                              <svg viewBox="0 0 58 54">
                                <use xlink:href='../../assets/svg/icons/wizard-checkout-cart.svg#wizardCart'></use>
                              </svg>
                            </span>
                            <span class="bs-stepper-label">سبد خرید</span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="mdi mdi-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#checkout-address">
                        <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                          <svg viewBox="0 0 54 54">
                            <use xlink:href='../../assets/svg/icons/wizard-checkout-address.svg#wizardCheckoutAddress'></use>
                          </svg>
                        </span>
                            <span class="bs-stepper-label">آدرس</span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="mdi mdi-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#checkout-payment">
                        <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                          <svg viewBox="0 0 58 54">
                            <use xlink:href='../../assets/svg/icons/wizard-checkout-payment.svg#wizardPayment'></use>
                          </svg>
                        </span>
                            <span class="bs-stepper-label">پرداخت</span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="mdi mdi-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#checkout-confirmation">
                        <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                          <svg viewBox="0 0 58 54">
                            <use xlink:href='../../assets/svg/icons/wizard-checkout-confirmation.svg#wizardConfirm'></use>
                          </svg>
                        </span>
                            <span class="bs-stepper-label">تایید</span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content border-top">
                    <form id="wizard-checkout-form" onSubmit="return false">
                        <!-- Cart -->
                        <div id="checkout-cart" class="content">
                            <div class="row">
                                <!-- Cart left -->
                                <div class="col-xl-8 mb-3 mb-xl-0">

                                    <!-- Offer alert -->
{{--                                    <div class="alert alert-success mb-4" role="alert">--}}
{{--                                        <div class="d-flex gap-3">--}}
{{--                                            <div class="flex-shrink-0">--}}
{{--                                                <i class="mdi mdi-tag-outline mdi-24px"></i>--}}
{{--                                            </div>--}}
{{--                                            <div class="flex-grow-1">--}}
{{--                                                <div class="fw-medium">پیشنهادات موجود</div>--}}
{{--                                                <ul class="list-unstyled mb-0">--}}
{{--                                                    <li> - 10% تخفیف فوری در پرداخت از طریق کارت بانکی</li>--}}
{{--                                                    <li> - 25%  بازگشت مبلغ برای خریدهای بالای دو میلیون تومان</li>--}}
{{--                                                </ul>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--                                    </div>--}}

                                    <!-- Shopping bag -->
                                    <h5> سبد خرید من {{count($invoices)}} مورد </h5>
                                    <ul class="list-group mb-3">
                                        @foreach($invoices as $invoice)
                                            <li class="list-group-item p-4 cart-item"
                                                data-product-id="{{ $invoice->product_id }}"
                                                data-product-type="{{ $invoice->product_type }}"
                                                data-price="{{ $invoice->product_price }}">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-shrink-0">
                                                        <img src="../../assets/img/products/1.png" class="w-px-100">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <h6 class="me-3">{{ $invoice->product_name }}</h6>
                                                                <div class="text-muted mb-1">{{ $invoice->product_type }}</div>
                                                            </div>
                                                            <div class="col-md-4 mt-3 mt-md-0">
                                                                <div class="d-md-flex flex-column h-100 justify-content-between align-items-md-end">
                                                                    <button type="button" class="btn-close btn-pinned remove-from-cart"
                                                                            data-invoice-id="{{ $invoice->id }}"></button>
                                                                    <div class="my-2 my-md-4">
                                                                        <span class="text-primary final-price">
                                                                            {{ number_format($invoice->final_price ?? $invoice->price) }}
                                                                        </span>
                                                                        تومان
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="col-xl-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6>پیشنهاد</h6>
                                        <div class="row g-3 mb-3">
                                            <div class="col-8 col-xxl-8 col-xl-12">
                                                <input type="text" class="form-control" id="wizard-promo-code" placeholder="کد تخفیف را وارد کنید" aria-label="Enter Promo Code">
                                            </div>
                                            <div class="col-4 col-xxl-4 col-xl-12">
                                                <div class="d-grid">
                                                    <button type="button" class="btn btn-outline-primary">اعمال</button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <h6>جزئیات قیمت</h6>
                                        <dl class="row mb-0">
                                            <dt class="col-6 fw-normal">جمع سبد</dt>
                                            <dd class="col-6 text-end" id="cart-subtotal">0 تومان</dd>

                                            <dt class="col-6 fw-normal">کد تخفیف</dt>
                                            <dd class="col-6 text-success text-end" id="discount-price"
                                                data-applied="false"
                                                data-value="0">0 تومان</dd>

                                            <dt class="col-6 fw-normal">مجموع سفارش</dt>
                                            <dd class="col-6 text-end" id="cart-total">0 تومان</dd>

                                            <hr>

                                            <dt class="col-6">جمع</dt>
                                            <dd class="col-6 fw-semibold text-end mb-0" id="cart-final-sum">0 تومان</dd>
                                        </dl>

                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-next">ثبت سفارش</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div id="checkout-address" class="content">
                            <div class="row">
                                <!-- Address left -->
                                <div class="col-xl-9 mb-3 mb-xl-0">

                                    <!-- Select address -->
                                    <p>آدرس دلخواه خود را انتخاب کنید</p>
                                    <div class="row mb-3">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-basic checked">
                                                <label class="form-check-label custom-option-content" for="customRadioAddress1">
                                                    <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioAddress1" checked="">
                                                    <span class="custom-option-header">
                      <span class="fw-semibold">جان اسنو (پیش‌فرض)</span>
                      <span class="badge bg-label-primary rounded-pill">خانه</span>
                    </span>
                                                    <span class="custom-option-body">
                      <small>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم<br /> لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت</small>
                      <hr>
                      <span class="d-flex">
                        <a class="me-2" href="javascript:void(0)">ویرایش</a> <a href="javascript:void(0)">حذف</a>
                      </span>
                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customRadioAddress2">
                                                    <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioAddress2">
                                                    <span class="custom-option-header">
                      <span class="fw-semibold">دفتر کار</span>
                      <span class="badge bg-label-success rounded-pill">دفتر</a>
                    </span>
                    <span class="custom-option-body">
                      <small>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم<br />لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت</small>
                      <hr>
                      <span class="d-flex">
                        <a class="me-2" href="javascript:void(0)">ویرایش</a> <a href="javascript:void(0)">حذف</a>
                      </span>
                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary mb-4" data-bs-toggle="modal" data-bs-target="#addNewAddress">افزودن آدرس جدید</button>

                                    <!-- Choose Delivery -->
                                    <p class="mt-2">انتخاب سرعت تحویل</p>
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon position-relative checked">
                                                <label class="form-check-label custom-option-content" for="customRadioDelivery1">
                    <span class="custom-option-body">
                      <i class="mdi mdi-account-outline"></i>
                      <span class="custom-option-title">استاندارد</span>
                      <span class="badge bg-label-success rounded-pill btn-pinned">رایگان</span>
                      <small>دریافت محصول در 1 هفته.</small>
                    </span>
                                                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioDelivery1" checked="">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon position-relative">
                                                <label class="form-check-label custom-option-content" for="customRadioDelivery2">
                    <span class="custom-option-body">
                      <i class="mdi mdi-crown-outline"></i>
                      <span class="custom-option-title">سریع</span>
                      <span class="badge bg-label-secondary rounded-pill btn-pinned">10,000 تومان</span>
                      <small>دریافت محصول در 3-4 روز.</small>
                    </span>
                                                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioDelivery2">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-icon position-relative">
                                                <label class="form-check-label custom-option-content" for="customRadioDelivery3">
                    <span class="custom-option-body">
                      <i class="mdi mdi-rocket-launch-outline"></i>
                      <span class="custom-option-title">شبانه</span>
                      <span class="badge bg-label-secondary rounded-pill btn-pinned">$15,000 تومان</span>
                      <small>دریافت محصول در 1 روز.</small>
                    </span>
                                                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioDelivery3">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address right -->
                                <div class="col-xl-3">
                                    <div class="border rounded p-3 mb-3">

                                        <!-- Estimated Delivery -->
                                        <h6>تاریخ تحویل تخمینی</h6>
                                        <ul class="list-unstyled">
                                            <li class="d-flex align-items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <img src="../../assets/img/products/1.png" alt="google home" class="w-px-50">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0"><a class="text-body" href="javascript:void(0)">گوگل - گوگل Home - White</a></p>
                                                    <p class="fw-semibold">18 فروردین 1401</p>
                                                </div>
                                            </li>
                                            <li class="d-flex align-items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <img src="../../assets/img/products/2.png" alt="google home" class="w-px-50">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0"><a class="text-body" href="javascript:void(0)">Apple iPhone 11 (64GB, Black)</a></p>
                                                    20 فروردین 1401</p>
                                                </div>
                                            </li>
                                        </ul>

                                        <hr class="mx-n3">

                                        <!-- جزئیات قیمت -->
                                        <h6>جزئیات قیمت</h6>
                                        <dl class="row mb-0">

                                            <dt class="col-6 fw-normal">مجموع سفارش</dt>
                                            <dd class="col-6 text-end">1,100,000 تومان</dd>

                                            <dt class="col-6 fw-normal">هزینه ارسال</dt>
                                            <dd class="col-6 text-end"><s>50,000 تومان</s> <span class="badge bg-label-success rounded-pill">رایگان</span></dd>

                                            <hr>

                                            <dt class="col-6">جمع</dt>
                                            <dd class="col-6 fw-semibold text-end mb-0">1,100,000 تومان</dd>
                                        </dl>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-next">ثبت سفارش</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment -->
                        <div id="checkout-payment" class="content">
                            <div class="row">
                                <!-- Payment left -->
                                <div class="col-xl-9 mb-3 mb-xl-0">
                                    <!-- Offer alert -->
                                    <div class="alert alert-success" role="alert">
                                        <div class="d-flex gap-3">
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-tag-outline mdi-24px"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">پیشنهادهای بانک</div>
                                                <ul class="list-unstyled mb-0">
                                                    <li> - 10% تخفیف فوری در پرداخت از طریق کارت بانکی</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>

                                    <!-- Payment Tabs -->
                                    <div class="col-xxl-6 col-lg-8">
                                        <ul class="nav nav-pills mb-3" id="paymentTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-cc-tab" data-bs-toggle="pill" data-bs-target="#pills-cc" type="button" role="tab" aria-controls="pills-cc" aria-selected="true">انلاین</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-cod-tab" data-bs-toggle="pill" data-bs-target="#pills-cod" type="button" role="tab" aria-controls="pills-cod" aria-selected="false">
                                                    پرداخت در محل
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-gift-card-tab" data-bs-toggle="pill" data-bs-target="#pills-gift-card" type="button" role="tab" aria-controls="pills-gift-card" aria-selected="false">
                                                    کارت هدیه
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-0" id="paymentTabsContent">
                                            <!-- کارت اعتباری -->
                                            <div class="tab-pane fade show active" id="pills-cc" role="tabpanel" aria-labelledby="pills-cc-tab">
                                                <div class="row g-4">
                                                    <div class="col-12">
                                                        <div class="input-group input-group-merge">
                                                            <div class="form-floating form-floating-outline">
                                                                <input id="paymentCard" name="paymentCard" class="form-control credit-card-mask" type="text" placeholder="1356 3215 6548 7898" aria-describedby="paymentCard2" />
                                                                <label for="paymentCard">شماره کارت</label>
                                                            </div>
                                                            <span class="input-group-text cursor-pointer p-1" id="paymentCard2"><span class="card-type"></span></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" id="paymentCardName" class="form-control" placeholder="جان اسنو" />
                                                            <label for="paymentCardName">نام </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" id="paymentCardExpiryDate" class="form-control expiry-date-mask" placeholder="MM/YY" />
                                                            <label for="paymentCardExpiryDate">تاریخ انقضا </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <div class="input-group input-group-merge">
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="text" id="paymentCardCvv" class="form-control cvv-code-mask" maxlength="3" placeholder="654" />
                                                                <label for="paymentCardCvv">کد CVV</label>
                                                            </div>
                                                            <span class="input-group-text cursor-pointer" id="paymentCardCvv2"><i class="mdi mdi-help-circle-outline text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Card Verification Value"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="switch">
                                                            <input type="checkbox" class="switch-input">
                                                            <span class="switch-toggle-slider">
                          <span class="switch-on"></span>
                          <span class="switch-off"></span>
                        </span>
                                                            <span class="switch-label">ذخیره کارت برای پرداخت های بعدی؟</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-primary btn-next me-sm-3 me-1">ثبت</button>
                                                        <button type="reset" class="btn btn-label-secondary">انصراف</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- COD -->
                                            <div class="tab-pane fade" id="pills-cod" role="tabpanel" aria-labelledby="pills-cod-tab">
                                                <p>پرداخت در هنگام تحویل نوعی روش پرداخت است که در آن گیرنده مبلغ سفارش را در زمان تحویل سفارش پرداخت می‌کند.</p>
                                                <button type="button" class="btn btn-primary btn-next">پرداخت هنگام تحویل</button>
                                            </div>

                                            <!-- Gift card -->
                                            <div class="tab-pane fade" id="pills-gift-card" role="tabpanel" aria-labelledby="pills-gift-card-tab">
                                                <h6>جزئیات کارت هدیه را وارد کنید</h6>
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="giftCardNumber" class="form-label">شماره کارت هدیه</label>
                                                        <input type="number" class="form-control" id="giftCardNumber" placeholder="شماره کارت هدیه">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="giftCardPin" class="form-label">پین کارت هدیه</label>
                                                        <input type="number" class="form-control" id="giftCardPin" placeholder="پین کارت هدیه">
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-primary btn-next">استفاده از کارت هدیه</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- Address right -->
                                <div class="col-xl-3">
                                    <div class="border rounded p-3">

                                        <!-- جزئیات قیمت -->
                                        <h6 class="fw-semibold">جزئیات قیمت</h6>
                                        <dl class="row">

                                            <dt class="col-6 fw-normal">مجموع سفارش</dt>
                                            <dd class="col-6 text-end">1,100,000 تومان</dd>

                                            <dt class="col-6 fw-normal">هزینه ارسال</dt>
                                            <dd class="col-6 text-end"><s>50,000 تومان</s> <span class="badge bg-label-success rounded-pill">رایگان</span></dd>

                                            <hr>

                                            <dt class="col-6 mb-1">جمع</dt>
                                            <dd class="col-6 mb-1 fw-semibold text-end mb-0">1,100,000 تومان</dd>

                                            <dt class="col-6">ارسال به:</dt>
                                            <dd class="col-6 fw-semibold text-end mb-0"><span class="badge bg-label-primary rounded-pill">خانه</span></dd>
                                        </dl>
                                        <!-- Address Details -->
                                        <address>
                                            <span class="fw-semibold"> جان اسنو (پیشفرض),</span><br />
                                            ورم ایپسوم متن ساختگی
                                            <br />
                                            لورم ایپسوم متن ساختگی با
                                        </address>
                                        <a href="javascript:void(0)">تغییر آدرس</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmation -->
                        <div id="checkout-confirmation" class="content">
                            <div class="row mb-3">
                                <div class="col-12 col-lg-8 offset-lg-2 text-center mb-3">
                                    <h4 class="mt-2">سپاس ! 😇</h4>
                                    <p>سفارش شما <a href="javascript:void(0)">#1536548131</a> ثبت شد!</p>
                                    <p>ما یک ایمیل به <a href="mailto:Mahdi@example.com">Mahdi@example.com</a> به همراه فاکتور و تایید سفارش شما ارسال کردیم. اگر ایمیل در عرض دو دقیقه دریافت نشود، لطفا پوشه اسپم خود را نیز چک کنید.</p>
                                    <p><span class="fw-semibold"><i class="mdi mdi-av-timer"></i>  زمان ثبت:</span>  زمان ثبت: 1401/01/25 13:35 ق.ظ</p>
                                </div>
                                <!-- Confirmation details -->
                                <div class="col-12">
                                    <ul class="list-group list-group-horizontal-md">
                                        <li class="list-group-item flex-fill">
                                            <h6 class="fw-semibold"><i class="mdi mdi-24px mdi-map-marker-outline"></i> حمل و نقل</h6>
                                            <address>
                                                جان اسنو <br />
                                                لورم ایپسوم متن ساختگی<br />
                                                لورم ایپسوم متن ساختگی<br />
                                                ایران <br />
                                                +987654321
                                            </address>
                                        </li>
                                        <li class="list-group-item flex-fill">
                                            <h6 class="fw-semibold"><i class="mdi mdi-24px mdi-credit-card-outline"></i>آدرس صورتحساب</h6>
                                            <address>
                                                جان اسنو <br />
                                                لورم ایپسوم متن ساختگی<br />
                                                لورم ایپسوم متن ساختگی<br />
                                                ایران <br />
                                                +987654321
                                            </address>
                                        </li>
                                        <li class="list-group-item flex-fill">
                                            <h6 class="fw-semibold"><i class="mdi mdi-24px mdi-truck-outline"></i>  روش ارسال</h6>
                                            <span class="fw-semibold">روش مد نظر:</span><br />
                                            استاندارد ارسال <br />
                                            (معمولا 3-4 روز کاری)
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Confirmation items -->
                                <div class="col-xl-9 mb-3 mb-xl-0">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="d-flex gap-3">
                                                <div class="flex-shrink-0">
                                                    <img src="../../assets/img/products/1.png" alt="google home" class="w-px-75">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <a href="javascript:void(0)" class="text-body">
                                                                <h6>گوگل - گوگل Home - White</h6>
                                                            </a>
                                                            <div class="text-muted mb-1 d-flex flex-wrap"><span class="me-1">فروخته شده توسط:</span> <a href="javascript:void(0)" class="me-1">اپل</a> <span class="badge bg-label-success rounded-pill">موجود در انبار</span></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="text-md-end">
                                                                <div class="my-2 my-lg-4"><span class="text-primary">299,000 تومان/</span><s class="text-muted">359,000 تومان/</s></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex gap-3">
                                                <div class="flex-shrink-0">
                                                    <img src="../../assets/img/products/2.png" alt="google home" class="w-px-75">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <a href="javascript:void(0)" class="text-body">
                                                                <h6>Apple iPhone 11 (64GB, Black)</h6>
                                                            </a>
                                                            <div class="text-muted mb-1 d-flex flex-wrap"><span class="me-1">فروخته شده توسط:</span> <a href="javascript:void(0)" class="me-1">اپل</a> <span class="badge bg-label-success rounded-pill">موجود در انبار</span></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="text-md-end">
                                                                <div class="my-2 my-lg-4"><span class="text-primary">299,000 تومان/</span><s class="text-muted">359,000 تومان/</s></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Confirmation total -->
                                <div class="col-xl-3">
                                    <div class="border rounded p-3">
                                        <!-- جزئیات قیمت -->
                                        <h6>جزئیات قیمت</h6>
                                        <dl class="row mb-0">

                                            <dt class="col-6 fw-normal">مجموع سفارش</dt>
                                            <dd class="col-6 text-end">1,100,000 تومان</dd>

                                            <dt class="col-6 fw-normal">هزینه ارسال</dt>
                                            <dd class="col-6 text-end"><s>50,000 تومان</s> <span class="badge bg-label-success rounded-pill">رایگان</span></dd>

                                            <hr>

                                            <dt class="col-6">جمع</dt>
                                            <dd class="col-6 fw-semibold text-end mb-0">1,100,000 تومان</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Checkout Wizard -->

            <div class="modal fade" id="addNewAddress" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body p-md-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4">
                                <h3 class="address-title mb-2 pb-1">افزودن آدرس جدید</h3>
                                <p class="address-subtitle">افزودن آدرس جدید for express delivery</p>
                            </div>
                            <form id="addNewAddressForm" class="row g-4" onsubmit="return false">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-3">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioHome">
                    <span class="custom-option-body">
                      <i class="mdi mdi-home-outline"></i>
                      <span class="custom-option-title">خانه</span>
                      <small> زمان تحویل (9 صبح - 9 شب) </small>
                    </span>
                                                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioHome" checked />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-3">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioOffice">
                    <span class="custom-option-body">
                      <i class='mdi mdi-briefcase-outline'></i>
                      <span class="custom-option-title"> دفتر</span>
                      <small> زمان تحویل (9 صبح - 5 عصر) </small>
                    </span>
                                                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioOffice" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressFirstName" name="modalAddressFirstName" class="form-control" placeholder="دو" />
                                        <label for="modalAddressFirstName">نام</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressLastName" name="modalAddressLastName" class="form-control" placeholder="جان" />
                                        <label for="modalAddressLastName">نام خانوادگی</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating form-floating-outline">
                                        <select id="modalAddressCountry" name="modalAddressCountry" class="select2 form-select" data-allow-clear="true">
                                            <option value="">انتخاب</option>
                                            <option value="استرالیا">استرالیا</option>
                                            <option value="بنگلادش">بنگلادش</option>
                                            <option value="بلاروس">بلاروس</option>
                                            <option value="برزیل">برزیل</option>
                                            <option value="کانادا">کانادا</option>
                                            <option value="چین">چین</option>
                                            <option value="فرانسه">فرانسه</option>
                                            <option value="آلمان">آلمان</option>
                                            <option value="هند">هند</option>
                                            <option value="اندونزی">اندونزی</option>
                                            <option value="ایران">ایران</option>
                                            <option value="ایتالیا">ایتالیا</option>
                                            <option value="ژاپن">ژاپن</option>
                                            <option value="Korea">کره جنوبی</option>
                                            <option value="مکزیک">مکزیک</option>
                                            <option value="فیلیپین">فیلیپین</option>
                                            <option value="Russia">روسیه</option>
                                            <option value="آفریقای جنوبی">آفریقای جنوبی</option>
                                            <option value="تایلند">تایلند</option>
                                            <option value="ترکیه">ترکیه</option>
                                            <option value="اوکراین">اوکراین</option>
                                            <option value="امارات">امارات</option>
                                            <option value="انگلستان">انگلستان</option>
                                            <option value="ایالات متحده">ایالات متحده</option>
                                        </select>
                                        <label for="modalAddressCountry">کشور</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressAddress1" name="modalAddressAddress1" class="form-control" placeholder="خیابان آزادی" />
                                        <label for="modalAddressAddress1">خط آدرس 1</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressAddress2" name="modalAddressAddress2" class="form-control" placeholder="کوی زهرا" />
                                        <label for="modalAddressAddress2">خط آدرس 2</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressLandmark" name="modalAddressLandmark" class="form-control" placeholder="Nr. Hard Rock Cafe" />
                                        <label for="modalAddressLandmark">نشان اختصاصی</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressCity" name="modalAddressCity" class="form-control" placeholder="Los Angeles" />
                                        <label for="modalAddressCity">شهر</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressState" name="modalAddressState" class="form-control" placeholder="یزد" />
                                        <label for="modalAddressLandmark">استان</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="modalAddressZipCode" name="modalAddressZipCode" class="form-control" placeholder="99950" />
                                        <label for="modalAddressZipCode">کد پستی</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input">
                                        <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
                                        <span class="switch-label">استفاده به عنوان آدرس صورتحساب؟</span>
                                    </label>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">ثبت</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">انصراف</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/rateyo/rateyo.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-checkout.js') }}"></script>

    <script>
        // تابع محاسبه نهایی
        function recalcPrices() {
            let subtotal = 0;
            let total = 0;

            document.querySelectorAll('.cart-item').forEach(item => {
                subtotal += parseInt(item.dataset.price) || 0;

                let finalEl = item.querySelector('.final-price');
                let finalPrice = finalEl ? parseInt(finalEl.innerText.replace(/,/g, '')) || 0 : 0;
                total += finalPrice;
            });

            let discountEl = document.getElementById('discount-price');
            let discount = 0;
            if (discountEl.dataset.applied === "true") {
                discount = parseInt(discountEl.dataset.value) || 0;
                discountEl.innerText = discount.toLocaleString() + ' تومان';
            } else {
                discountEl.innerText = '0 تومان';
            }

            document.getElementById('cart-subtotal').innerText = subtotal.toLocaleString() + ' تومان';
            document.getElementById('cart-total').innerText = total.toLocaleString() + ' تومان';
            document.getElementById('cart-final-sum').innerText = total.toLocaleString() + ' تومان';
        }

        // حذف آیتم
        document.querySelectorAll('.remove-from-cart').forEach(btn => {
            btn.addEventListener('click', function () {
                fetch("{{ route('invoicedestroy') }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: this.dataset.invoiceId })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.isSuccess) {
                            this.closest('.cart-item').remove();
                            recalcPrices();
                        }
                    });
            });
        });

        // اعمال کد تخفیف
        document.querySelector('.btn-outline-primary').addEventListener('click', function () {
            let code = document.getElementById('wizard-promo-code').value;

            document.querySelectorAll('.cart-item').forEach(item => {
                fetch("{{ route('discountcheck') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        discountcode: code,
                        product_id: item.dataset.productId,
                        product_type: item.dataset.productType
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.isSuccess) {
                            item.querySelector('.final-price').innerText = data.result.toLocaleString() + ' تومان';

                            // ذخیره مقدار تخفیف در discount-price
                            let discountEl = document.getElementById('discount-price');
                            discountEl.dataset.applied = "true";
                            discountEl.dataset.value = data.discount_amount || 0;

                            recalcPrices();
                        } else {
                            alert(data.message);
                        }
                    });
            });
        });

        // بارگذاری اولیه جمع سبد
        window.addEventListener('DOMContentLoaded', recalcPrices);
    </script>

@endsection

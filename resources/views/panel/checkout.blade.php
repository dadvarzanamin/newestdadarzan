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
                                                data-invoice-id="{{ $invoice->id }}"
                                                data-product-id="{{ $invoice->product_id }}"
                                                data-product-type="{{ $invoice->product_type }}"
                                                data-price="{{ $invoice->price }}"
                                                data-final-price="{{ $invoice->final_price ?? $invoice->price }}">

                                                <div class="d-flex gap-3">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ $invoice->product_image ?? asset('assets/img/products/1.png') }}"
                                                             class="w-px-100">
                                                    </div>

                                                    <div class="flex-grow-1">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <h6 class="me-3">{{ $invoice->product_name }}</h6>
                                                                <div class="text-muted mb-1">{{ $invoice->product_type }}</div>
                                                            </div>

                                                            <div class="col-md-4 mt-3 mt-md-0">
                                                                <div class="d-md-flex flex-column h-100 justify-content-between align-items-md-end">
                                                                    <button type="button"
                                                                            class="btn-close btn-pinned remove-from-cart"
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

                                            <dt class="col-6 fw-normal"> تخفیف</dt>
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
                                        <button type="button" class="btn btn-primary" id="pay-btn">
                                            پرداخت آنلاین
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Checkout Wizard -->

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
        function recalcPrices() {
            let subtotal = 0;
            let total = 0;

            document.querySelectorAll('.cart-item').forEach(item => {
                subtotal += parseInt(item.dataset.price) || 0;
                total += parseInt(item.dataset.finalPrice) || 0;
            });

            let discount = subtotal - total;

            document.getElementById('cart-subtotal').innerText =
                subtotal.toLocaleString() + ' تومان';

            document.getElementById('discount-price').innerText =
                discount > 0 ? discount.toLocaleString() + ' تومان' : '0 تومان';

            document.getElementById('cart-total').innerText =
                total.toLocaleString() + ' تومان';

            document.getElementById('cart-final-sum').innerText =
                total.toLocaleString() + ' تومان';
        }

        // حذف آیتم
        document.addEventListener('click', function (e) {
            if (!e.target.classList.contains('remove-from-cart')) return;

            let btn = e.target;
            fetch("{{ route('invoicedestroy') }}", {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: btn.dataset.invoiceId })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.isSuccess) {
                        btn.closest('.cart-item').remove();
                        recalcPrices();
                    }
                });
        });

        // اعمال کد تخفیف (یک بار)
        document.querySelector('.btn-outline-primary').addEventListener('click', function () {
            let code = document.getElementById('wizard-promo-code').value;

            fetch("{{ route('discountcheck') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ discountcode: code })
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.isSuccess) {
                        alert(data.message);
                        return;
                    }

                    data.items.forEach(item => {
                        let cartItem = document.querySelector(
                            `.cart-item[data-invoice-id="${item.invoice_id}"]`
                        );

                        if (cartItem) {
                            cartItem.dataset.finalPrice = item.final_price;
                            cartItem.querySelector('.final-price').innerText =
                                item.final_price.toLocaleString();
                        }
                    });

                    recalcPrices();
                });
        });

        window.addEventListener('DOMContentLoaded', recalcPrices);
    </script>
    <script>
        document.getElementById('pay-btn').addEventListener('click', function () {

            const form = document.getElementById('wizard-checkout-form');

            form.method = 'POST';
            form.action = "{{ route('payment') }}";

            if (!form.querySelector('input[name="_token"]')) {
                let csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";
                form.appendChild(csrf);
            }

            form.submit();
        });
    </script>


@endsection

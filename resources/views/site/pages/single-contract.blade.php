@extends('site.layouts.base')

@section('title', 'کارگاه آموزشی')

@section('content')
    <!-- ===========================
        =====>> breadcrumb <<======= -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title">{{$contract->title}}</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="{{route('/')}}"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text">{{$contract->title}}</span>
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
    =====>> Product Details <<======= -->
    <section class="product-details-section py-120">
        <div class="container">
            <div class="row row-gap-5 justify-content-between">
                {{--                <div class="col-lg-4">--}}
                {{--                    <div class="product-image">--}}
                {{--                        <div class="swiper details-list">--}}
                {{--                            <div class="swiper-wrapper">--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                        <div class="swiper details-main">--}}
                {{--                            <div class="swiper-wrapper">--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                                <div class="swiper-slide">--}}
                {{--                                    <img src="{{asset('storage/'.$contract->cover)}}" alt="product">--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="swiper-button-next"></div>--}}
                {{--                            <div class="swiper-button-prev"></div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="product-details-content">--}}
                {{--                        <h3>ویژگی های دوره</h3>--}}
                {{--                        <div class="divider"><span></span></div>--}}
                {{--                        <ul class="generic-list-item generic-list-item-flash">--}}
                {{--                            <li class="d-flex align-items-center justify-content-between">--}}
                {{--                                <span>--}}
                {{--                                    <i class="mr-2 text-color"></i>مدت زمان</span>--}}
                {{--                                {{$singleworkshops->duration}}--}}
                {{--                                ساعت--}}
                {{--                            </li>--}}
                {{--                            <li class="d-flex align-items-center justify-content-between">--}}
                {{--                                <span>--}}
                {{--                                    <i class="mr-2 text-color"></i>نوع برگزاری : </span>--}}
                {{--                                {{implode("," , json_decode($singleworkshops->type))}}--}}
                {{--                            </li>--}}
                {{--                            <li class="d-flex align-items-center justify-content-between">--}}
                {{--                                <span><i class="mr-2 text-color"></i>آزمون ورودی : </span> ندارد--}}
                {{--                            </li>--}}
                {{--                            <li class="d-flex align-items-center justify-content-between">--}}
                {{--                                <span><i class="mr-2 text-color"></i>سطح مهارت</span>{{$singleworkshops->level}}--}}
                {{--                            </li>--}}
                {{--                        </ul>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="col-lg-7">
                    <div class="product-details-content">
                        <div class="d-flex flex-wrap gap-4 justify-content-between align-items-center">
                            <h2>{{$contract->title}}</h2>
                            <button class="fs-25 text-white"><i class="fa-regular fa-heart"></i></button>
                        </div>
                        <p class="fs-14 pt-1 pb-4"><span>تیم حقوقی دادورزان امین</span></p>
                        <hr>
                        <div class="product-content">
                            {!! $contract->description !!}
                            <div class="product-details-footer d-flex flex-column flex-wrap gap-4 mt-4 ">
                                <span>
                                    @if($contract->price == 0)
                                        رایگان
                                    @else
                                        {{$contract->price}}
                                    @endif
                                </span>
                                <div class="product-details-footer d-flex flex-wrap gap-4 mt-4">
                                    <button class="btn btn--border add-to-cart" data-product-id="{{ $contract->id }}" data-product-type="{{ $contract->product_type }}" data-product-price="{{ $contract->price }}">
                                        اضافه کردن به سبد خرید
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 mt-3" id="toastContainer" style="z-index: 1080;"></div>
    <script>
        const toastContainer = document.getElementById('toastContainer');

        function showToast(message, type = 'success') {
            if (!toastContainer) {
                alert(message);
                return;
            }

            const tone = {
                success: 'text-bg-success',
                error: 'text-bg-danger',
                warning: 'text-bg-warning',
            }[type] || 'text-bg-success';

            const toastEl = document.createElement('div');
            toastEl.className = `toast align-items-center ${tone} border-0 shadow`;
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');
            toastEl.setAttribute('data-bs-delay', '3000');

            toastEl.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            toastContainer.appendChild(toastEl);
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                button.disabled = true;

                fetch("{{ route('setinvoice') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: this.dataset.productId,
                        product_type: this.dataset.productType,
                        product_price: this.dataset.productPrice
                    })
                })
                    .then(res => {
                        if (!res.ok) throw new Error('خطا در ارتباط با سرور');
                        return res.json();
                    })
                    .then(data => {
                        if (data.isSuccess) {
                            showToast('به سبد خرید اضافه شد');
                        } else {
                            showToast(data.message || 'خطایی رخ داد', 'error');
                        }
                    })
                    .catch(() => showToast('خطا در ارتباط با سرور', 'error'))
                    .finally(() => {
                        button.disabled = false;
                    });
            });
        });
    </script>

@endsection

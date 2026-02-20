@extends('site.layouts.base')

@section('title', 'کارگاه آموزشی')

@section('content')

    {{--  breadcrumb  --}}
    <section class="breadcrumb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h2 class="breadcrumb__title">{{$singleworkshops->title}}</h2>
                        <ul class="breadcrumb__list">
                            <li class="breadcrumb__item">
                                <a href="{{url('/')}}"> خانه</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="fa-solid fa-arrow-left"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="breadcrumb__item-text"> اطلاعات کارگاه</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{--  Product Details  --}}
    <section class="product-details-section py-120">
        <div class="container">
            <div class="row row-gap-5 justify-content-between">
                <div class="col-lg-4">
                    <div class="product-image">
                        <div class="swiper details-list">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                            </div>
                        </div>
                        <div class="swiper details-main">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$singleworkshops->cover)}}" alt="product">
                                </div>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3>ویژگی های دوره</h3>
                        <div class="divider"><span></span></div>
                        <ul class="generic-list-item generic-list-item-flash">
                            <li class="d-flex align-items-center justify-content-between">
                                <span>
                                    <i class="mr-2 text-color"></i>مدت زمان</span>
                                {{$singleworkshops->product_time}}
                                ساعت
                            </li>
                            <div class="divider"></div>
                            <li class="d-flex align-items-center justify-content-between">
                                <span>
                                    <i class="mr-2 text-color"></i>نوع برگزاری : </span>
                                @php
                                    $productUse = json_decode($singleworkshops->product_use, true);
                                @endphp
                                {{ is_array($productUse) ? implode('، ', $productUse) : ($singleworkshops->product_use ?? '-') }}
                            </li>
                            <div class="divider"><span></span></div>

                            <li class="d-flex align-items-center justify-content-between">
                                <span><i class="mr-2 text-color"></i>آزمون ورودی : </span> ندارد
                            </li>
                            <div class="divider"><span></span></div>
                            <li class="d-flex align-items-center justify-content-between">
                                <span><i class="mr-2 text-color"></i>سطح مهارت</span>{{$singleworkshops->level}}
                            </li>
                        </ul>


                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-details-content">
                        <div class="d-flex flex-wrap gap-4 justify-content-between align-items-center">
                            <h2>{{$singleworkshops->title}}</h2>
                            <button class="fs-25 text-white"><i class="fa-regular fa-heart"></i></button>
                        </div>
                        <p class="fs-14 pt-1 pb-4"><span>دپارتمان آموزشی دادورزان امین</span></p>
                        <hr>
                        <div class="d-flex flex-wrap gap-4 justify-content-between align-items-center">
                            <div class="creator-profile">
                                <h6 class="pb-3">مدرس </h6>
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="{{asset('storage/' . $singleworkshops->item2)}}" alt="creator user"
                                         class="creator-img">
                                    <span class="text-black fs-16 fw-semibold">
                                        {{$singleworkshops->item1}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="pricing-det pt-5">
                            <h6 class="pb-2">قیمت</h6>
                            <h4>
                                <span style="font-size: 24px">{{number_format($singleworkshops->price)}} تومان </span>
                            </h4>
                        </div>
                        <div class="product-content">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-details-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-details" type="button" role="tab"
                                            aria-controls="pills-details" aria-selected="true">
                                        اهداف دوره
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-description-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-description" type="button" role="tab"
                                            aria-controls="pills-description" aria-selected="false">
                                        توضیحات
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-reviews" type="button" role="tab"
                                            aria-controls="pills-reviews" aria-selected="false">
                                        رزومه مدرس
                                    </button>
                                </li>
                            </ul>
                            @php
                                $lines = explode("\n", $singleworkshops->description);
                            @endphp
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-details" role="tabpanel"
                                     aria-labelledby="pills-details-tab" tabindex="0">
                                    <h6 class="fs-24 font-weight-semi-bold mb-3">اهداف دوره</h6>
                                    <ul>
                                        @foreach ($lines as $line)
                                            <li class="generic-list-item overview-list-item">{!! $line !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="pills-description" role="tabpanel"
                                     aria-labelledby="pills-description-tab" tabindex="0">
                                    {!! $singleworkshops->full_description !!}
                                </div>
                                <div class="tab-pane fade" id="pills-reviews" role="tabpanel"
                                     aria-labelledby="pills-reviews-tab" tabindex="0">
                                    <div class="rating gap-4 ms-2">
                                        <h6 class="pb-2">سوابق و مدارک
                                        </h6>
                                        {!! $singleworkshops->item3 !!}

                                    </div>
                                </div>
                            </div>
                            <div class="product-details-footer d-flex flex-wrap gap-4 mt-4">
                                <button class="btn btn--border add-to-cart" data-product-id="{{ $singleworkshops->id }}" data-product-type="{{ $singleworkshops->product_type }}" data-product-price="{{ $singleworkshops->price }}">
                                    اضافه کردن به سبد خرید
                                </button>
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

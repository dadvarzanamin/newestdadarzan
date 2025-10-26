@extends('site.layouts.base')
@section('title', 'پروفایل')

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/profile.css') }}">
    <style>
        /* نگهدارنده‌های ظاهری ساده و مینیمال */
        .wallet-balance {
            border-radius: 16px; padding: 16px; background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,.05);
        }
        .txn-card {
            border-radius: 14px; padding: 12px; background: #fff;
            box-shadow: 0 1px 8px rgba(0,0,0,.04);
        }
        .txn-card + .txn-card { margin-top: 12px; }
        .txn-amount.in { color: #16a34a; font-weight: 600; }
        .txn-amount.out { color: #dc2626; font-weight: 600; }
        .avatar-24 { width: 24px; height: 24px; border-radius: 50%; object-fit: cover; }
        .modal-header .btn-close { margin: 0; }
    </style>
@endpush

@section('content')
    <!-- ===========================
        =====>> Profile <<======= -->
    <div class="cover-photo">
        <img src="assets/images/profile/cover-img.jpg" alt="cover photo">
    </div>
    <div class="pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="user-profile gap-4">
                        <div class="profile-img">
                            <img src="assets/images/user/user1.png" alt="profile">
                        </div>
                        <div class="d-flex w-100 flex-wrap gap-4 align-items-center justify-content-between">
                            <div class="profile-text">
                                <h3>امیرارسلان رهنما</h3>
                                <ul>
                                    <li> <span>3</span> دنبال کنندگان </li>
                                    <li> <span>7</span> دنبال شوندگان </li>
                                </ul>
                            </div>
                            <div class="d-flex gap-4">
                                <button class="follow-btn" data-bs-toggle="modal" data-bs-target="#walletModal">
                                    <i class="fa-solid fa-wallet"></i> کیف پول
                                </button>

                                <button class="follow-btn" data-bs-toggle="modal" data-bs-target="#profileModal">
                                    <i class="fa-solid fa-user"></i> مشخصات کاربری
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="creator__tab pt-60">
            <div class="creator__filter">
                <div class="container">
                    <div class="d-flex flex-wrap gap-4 align-items-end justify-content-between">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-prompt-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-prompt" type="button" role="tab"
                                        aria-controls="pills-prompt" aria-selected="true">کارگاه ها</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-collection-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-collection" type="button" role="tab"
                                        aria-controls="pills-collection" aria-selected="false">قرارداد ها</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-followers-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-followers" type="button" role="tab"
                                        aria-controls="pills-followers" aria-selected="false">استعلامات</button>
                            </li>
                        </ul>
                        <form action="#" class="search-form">
                            <input type="search" name="search" placeholder="جستجو کنید..">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-prompt" role="tabpanel"
                         aria-labelledby="pills-prompt-tab" tabindex="0">
                        <div class="row mt-60 row-gap-4 justify-content-center">
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="explore-item">
                                    <div class="explore-item-header d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <img src="assets/images/user/u1.png" alt="user">
                                            مهسا
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
                                        <div class="featured-price">۲۰۰تومان</div>
                                        <figure class="image-effect">
                                            <img src="assets/images/explore/ex1.jpg" alt="explore images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <div class="heart-content">
                                            <i class="fa-solid fa-heart"></i>
                                            12
                                        </div>
                                        <h5 class="featured-title">
                                            <a href="product-details.html">جنگجوی فانتزی</a>
                                        </h5>
                                    </div>
                                    <div class="explore-item-footer d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <div class="img">
                                                <img src="assets/images/com-logo/midjouruey.png" alt="explore">
                                            </div>
                                            میدجرنی
                                        </div>
                                        <div class="view-list">
                                            <i class="fa-regular fa-eye"></i>
                                            341
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="explore-item">
                                    <div class="explore-item-header d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <img src="assets/images/user/u2.png" alt="user">
                                            ارسلان
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
                                        <div class="featured-price">۳۰۰تومان</div>
                                        <figure class="image-effect">
                                            <img src="assets/images/explore/ex2.jpg" alt="explore images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <div class="heart-content">
                                            <i class="fa-solid fa-heart"></i>
                                            53
                                        </div>
                                        <h5 class="featured-title">
                                            <a href="product-details.html">پرامپت های ترسناک</a>
                                        </h5>
                                    </div>
                                    <div class="explore-item-footer d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <div class="img">
                                                <img src="assets/images/com-logo/chatgpt.png" alt="explore">
                                            </div>
                                            جی پی تی
                                        </div>
                                        <div class="view-list">
                                            <i class="fa-regular fa-eye"></i>
                                            345
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="explore-item">
                                    <div class="explore-item-header d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <img src="assets/images/user/u3.png" alt="user">
                                            نسترن
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
                                        <div class="featured-price">۴۰۰تومان</div>
                                        <figure class="image-effect">
                                            <img src="assets/images/explore/ex3.jpg" alt="explore images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <div class="heart-content">
                                            <i class="fa-solid fa-heart"></i>
                                            12
                                        </div>
                                        <h5 class="featured-title">
                                            <a href="product-details.html">پرامپت لوگو</a>
                                        </h5>
                                    </div>
                                    <div class="explore-item-footer d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <div class="img">
                                                <img src="assets/images/com-logo/leonardo.png" alt="explore">
                                            </div>
                                            لئوناردو
                                        </div>
                                        <div class="view-list">
                                            <i class="fa-regular fa-eye"></i>
                                            126
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="explore-item">
                                    <div class="explore-item-header d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <img src="assets/images/user/u4.png" alt="user">
                                            شیرین
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
                                        <div class="featured-price">۵۰۰تومان</div>
                                        <figure class="image-effect">
                                            <img src="assets/images/explore/ex4.jpg" alt="explore images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <div class="heart-content">
                                            <i class="fa-solid fa-heart"></i>
                                            18
                                        </div>
                                        <h5 class="featured-title">
                                            <a href="product-details.html">پرامپت طرح سه بعدی</a>
                                        </h5>
                                    </div>
                                    <div class="explore-item-footer d-flex align-items-center justify-content-between">
                                        <div class="explore-title">
                                            <div class="img">
                                                <img src="assets/images/com-logo/nightCafe.png" alt="explore">
                                            </div>
                                            نایت کافی
                                        </div>
                                        <div class="view-list">
                                            <i class="fa-regular fa-eye"></i>
                                            274
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-collection" role="tabpanel"
                         aria-labelledby="pills-collection-tab" tabindex="0">
                        <div class="row mt-60 row-gap-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="collection-item">
                                    <figure class="image-effect cover-img">
                                        <img src="assets/images/collection/cover5.jpg" alt="collection images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <figure class="image-effect prifle-img">
                                        <img src="assets/images/collection/profile5.jpg" alt="collection images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="collection-title">
                                        <h4><a href="prompts.html">پژواک‌های بی‌نهایت</a></h4>
                                        <p>۴ پرامپت</p>
                                    </div>
                                    <div class="collection-preview">
                                        <figure class="image-effect">
                                            <img src="assets/images/collection/p51.jpg" alt="collection images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <figure class="image-effect">
                                            <img src="assets/images/collection/p52.jpg" alt="collection images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <figure class="image-effect">
                                            <img src="assets/images/collection/p53.jpg" alt="collection images"
                                                 class="img-fluid w-100">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="collection-item">
                                    <figure class="image-effect cover-img">
                                        <img src="assets/images/collection/cover2.jpg" alt="collection images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <figure class="image-effect prifle-img">
                                        <img src="assets/images/collection/profile2.jpg" alt="collection images"
                                             class="img-fluid w-100">
                                    </figure>
                                    <div class="collection-title">
                                        <h4><a href="prompts.html">مجموعه هنر مدرن</a></h4>
                                        <p>۴ پرامپت</p>
                                    </div>
                                    <div class="collection-preview">
                                        <figure class="image-effect">
                                            <img src="assets/images/collection/p21.jpg" alt="collection images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <figure class="image-effect">
                                            <img src="assets/images/collection/p22.jpg" alt="collection images"
                                                 class="img-fluid w-100">
                                        </figure>
                                        <figure class="image-effect">
                                            <img src="assets/images/collection/p23.jpg" alt="collection images"
                                                 class="img-fluid w-100">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-followers" role="tabpanel"
                         aria-labelledby="pills-followers-tab" tabindex="0">
                        <div class="row row-gap-4 mt-60">
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="feature-item">
                                    <div class="feature-header">
                                        <div class="feature-img">
                                            <img src="assets/images/user/f1.png" alt="user">
                                            <svg class="profile-check" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                 fill="none">
                                                <ellipse cx="12.0001" cy="11.5386" rx="6.46154" ry="6" fill="#F9F9F9" />
                                                <path
                                                    d="M22.5876 14.3063C22.1159 13.5725 21.6441 12.8649 21.1724 12.1311C21.0676 11.9739 21.0676 11.8691 21.1724 11.7118C21.6441 11.0042 22.0897 10.2967 22.5614 9.58907C23.1117 8.75045 22.8235 7.93803 21.88 7.59734C21.0938 7.30906 20.3076 6.99458 19.5214 6.70631C19.3641 6.65389 19.2855 6.54907 19.2855 6.36562C19.2593 5.50079 19.2069 4.63596 19.1545 3.79734C19.1021 2.8801 18.3945 2.35596 17.5035 2.59182C16.6648 2.80148 15.8262 3.03734 15.0138 3.2732C14.8304 3.32562 14.7255 3.2732 14.5945 3.14217C14.0704 2.46079 13.52 1.80562 12.9959 1.15044C12.4193 0.416649 11.5283 0.416649 10.9255 1.15044C10.4014 1.80562 9.85104 2.46079 9.35311 3.11596C9.22208 3.29941 9.09105 3.32562 8.88139 3.2732C8.06897 3.03734 7.25656 2.82769 6.68001 2.67044C5.55311 2.40837 4.87174 2.85389 4.81932 3.79734C4.76691 4.66217 4.7145 5.527 4.68829 6.41803C4.68829 6.60148 4.60967 6.6801 4.45243 6.75872C3.64001 7.0732 2.8276 7.38768 2.01518 7.70217C1.17656 8.04286 0.914496 8.85527 1.41243 9.61527C1.88415 10.3491 2.35588 11.0567 2.8276 11.7904C2.93242 11.9477 2.93242 12.0525 2.8276 12.236C2.32967 12.9698 1.85794 13.7036 1.38622 14.4635C0.9407 15.1711 1.22897 16.0098 2.01518 16.3242C2.8276 16.6387 3.66622 16.9532 4.47863 17.2677C4.66207 17.3201 4.71449 17.4249 4.71449 17.6084C4.7407 18.447 4.84552 19.2594 4.84552 20.098C4.84552 20.9367 5.57932 21.6967 6.60138 21.3822C7.4138 21.1201 8.22621 20.9366 9.03863 20.7008C9.19587 20.6484 9.30069 20.6746 9.40552 20.8318C9.95587 21.5132 10.48 22.1684 11.0303 22.8498C11.6331 23.5835 12.4979 23.5835 13.0745 22.8498C13.6248 22.1684 14.149 21.5132 14.6993 20.8318C14.8041 20.7008 14.8828 20.6484 15.0662 20.7008C15.9048 20.9366 16.7434 21.1463 17.5821 21.3822C18.4469 21.618 19.1807 21.0939 19.2069 20.2029C19.2593 19.338 19.3117 18.4732 19.3379 17.5822C19.3379 17.3725 19.4428 17.2939 19.6 17.2415C20.3862 16.9532 21.1986 16.6387 21.9848 16.3242C22.8235 15.9049 23.0855 15.0663 22.5876 14.3063ZM16.3241 10.0084L11.0828 15.2498C10.9517 15.3808 10.7683 15.4856 10.5848 15.5118C10.5324 15.5118 10.4538 15.538 10.4014 15.538C10.1655 15.538 9.90347 15.4332 9.72001 15.2498L7.57105 13.1008C7.20415 12.7339 7.20415 12.1311 7.57105 11.7642C7.93794 11.3973 8.5407 11.3973 8.9076 11.7642L10.3752 13.2318L14.9352 8.67182C15.3021 8.30493 15.9048 8.30493 16.2717 8.67182C16.691 9.03872 16.691 9.64148 16.3241 10.0084Z"
                                                    fill="#34C759" />
                                            </svg>
                                        </div>
                                        <div class="feature-title">
                                            <h5><a href="profile.html">شیرین رضایی</a></h5>
                                            <p><span>4.7</span> / 05</p>
                                        </div>
                                    </div>
                                    <figure class="image-effect">
                                        <img src="assets/images/featured/fe1.jpg" alt="explore images" class="img-fluid w-100">
                                    </figure>
                                    <div class="feature-footer d-flex gap-4 align-items-center justify-content-between">
                                        <a href="profile.html">
                                            <i class="flaticon-image"></i>
                                            45
                                        </a>
                                        <div class="d-flex gap-2">
                                            <a href="profile.html">
                                                <i class="flaticon-plus"></i>
                                            </a>
                                            <a href="profile.html">
                                                <i class="flaticon-right-arrow"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="feature-item">
                                    <div class="feature-header">
                                        <div class="feature-img">
                                            <img src="assets/images/user/f2.png" alt="user">
                                            <svg class="profile-check" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                 fill="none">
                                                <ellipse cx="12.0001" cy="11.5386" rx="6.46154" ry="6" fill="#F9F9F9" />
                                                <path
                                                    d="M22.5876 14.3063C22.1159 13.5725 21.6441 12.8649 21.1724 12.1311C21.0676 11.9739 21.0676 11.8691 21.1724 11.7118C21.6441 11.0042 22.0897 10.2967 22.5614 9.58907C23.1117 8.75045 22.8235 7.93803 21.88 7.59734C21.0938 7.30906 20.3076 6.99458 19.5214 6.70631C19.3641 6.65389 19.2855 6.54907 19.2855 6.36562C19.2593 5.50079 19.2069 4.63596 19.1545 3.79734C19.1021 2.8801 18.3945 2.35596 17.5035 2.59182C16.6648 2.80148 15.8262 3.03734 15.0138 3.2732C14.8304 3.32562 14.7255 3.2732 14.5945 3.14217C14.0704 2.46079 13.52 1.80562 12.9959 1.15044C12.4193 0.416649 11.5283 0.416649 10.9255 1.15044C10.4014 1.80562 9.85104 2.46079 9.35311 3.11596C9.22208 3.29941 9.09105 3.32562 8.88139 3.2732C8.06897 3.03734 7.25656 2.82769 6.68001 2.67044C5.55311 2.40837 4.87174 2.85389 4.81932 3.79734C4.76691 4.66217 4.7145 5.527 4.68829 6.41803C4.68829 6.60148 4.60967 6.6801 4.45243 6.75872C3.64001 7.0732 2.8276 7.38768 2.01518 7.70217C1.17656 8.04286 0.914496 8.85527 1.41243 9.61527C1.88415 10.3491 2.35588 11.0567 2.8276 11.7904C2.93242 11.9477 2.93242 12.0525 2.8276 12.236C2.32967 12.9698 1.85794 13.7036 1.38622 14.4635C0.9407 15.1711 1.22897 16.0098 2.01518 16.3242C2.8276 16.6387 3.66622 16.9532 4.47863 17.2677C4.66207 17.3201 4.71449 17.4249 4.71449 17.6084C4.7407 18.447 4.84552 19.2594 4.84552 20.098C4.84552 20.9367 5.57932 21.6967 6.60138 21.3822C7.4138 21.1201 8.22621 20.9366 9.03863 20.7008C9.19587 20.6484 9.30069 20.6746 9.40552 20.8318C9.95587 21.5132 10.48 22.1684 11.0303 22.8498C11.6331 23.5835 12.4979 23.5835 13.0745 22.8498C13.6248 22.1684 14.149 21.5132 14.6993 20.8318C14.8041 20.7008 14.8828 20.6484 15.0662 20.7008C15.9048 20.9366 16.7434 21.1463 17.5821 21.3822C18.4469 21.618 19.1807 21.0939 19.2069 20.2029C19.2593 19.338 19.3117 18.4732 19.3379 17.5822C19.3379 17.3725 19.4428 17.2939 19.6 17.2415C20.3862 16.9532 21.1986 16.6387 21.9848 16.3242C22.8235 15.9049 23.0855 15.0663 22.5876 14.3063ZM16.3241 10.0084L11.0828 15.2498C10.9517 15.3808 10.7683 15.4856 10.5848 15.5118C10.5324 15.5118 10.4538 15.538 10.4014 15.538C10.1655 15.538 9.90347 15.4332 9.72001 15.2498L7.57105 13.1008C7.20415 12.7339 7.20415 12.1311 7.57105 11.7642C7.93794 11.3973 8.5407 11.3973 8.9076 11.7642L10.3752 13.2318L14.9352 8.67182C15.3021 8.30493 15.9048 8.30493 16.2717 8.67182C16.691 9.03872 16.691 9.64148 16.3241 10.0084Z"
                                                    fill="#34C759" />
                                            </svg>
                                        </div>
                                        <div class="feature-title">
                                            <h5><a href="profile.html">امیرارسلان رهنما</a></h5>
                                            <p><span>4.5</span> / 05</p>
                                        </div>
                                    </div>
                                    <figure class="image-effect">
                                        <img src="assets/images/featured/fe2.jpg" alt="explore images" class="img-fluid w-100">
                                    </figure>
                                    <div class="feature-footer d-flex gap-4 align-items-center justify-content-between">
                                        <a href="profile.html">
                                            <i class="flaticon-image"></i>
                                            75
                                        </a>
                                        <div class="d-flex gap-2">
                                            <a href="profile.html">
                                                <i class="flaticon-plus"></i>
                                            </a>
                                            <a href="profile.html">
                                                <i class="flaticon-right-arrow"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =====>> End Profile <<=====
    =============================== -->
    <!-- ===========================
    =====>> Company <<======= -->

    <!-- =====>> End Company <<=====
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
    <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true" dir="rtl">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="walletModalLabel">کیف پول</h5>
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- بالانس --}}
                    <div class="wallet-balance d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted">موجودی فعلی</div>
                            <div class="h4 m-0">۱,۲۴۰,۰۰۰ تومان</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn--base" data-bs-toggle="collapse" data-bs-target="#addFunds">
                                افزایش موجودی
                            </button>
                            <button class="btn btn--border" data-bs-toggle="collapse" data-bs-target="#withdrawFunds" disabled>
                                برداشت (غیرفعال)
                            </button>
                        </div>
                    </div>

                    <div class="collapse mt-3" id="addFunds">
                        <div class="txn-card">
                            <form action="{{ route('wallet.charge') }}" method="post">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">مبلغ (تومان)</label>
                                        <input type="number" name="amount" class="form-control" min="10000" step="1000" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">روش پرداخت</label>
                                        <select name="method" class="form-select" required>
                                            <option value="gateway">درگاه بانکی</option>
                                            <option value="card">کارت به کارت</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn--base">پرداخت</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="m-0">تراکنش‌های اخیر</h6>
                            <a href="{{ route('wallet.transactions') }}" class="text-decoration-none">مشاهده همه</a>
                        </div>

                        <div class="txn-card d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img class="avatar-24" src="{{ asset('assets/images/user/u1.png') }}" alt="">
                                <div>
                                    <div class="fw-semibold">شارژ کیف پول</div>
                                    <div class="text-muted small">۱۴۰۳/۰۶/۲۸ - ۱۲:۴۵</div>
                                </div>
                            </div>
                            <div class="txn-amount in">+ ۳۰۰,۰۰۰</div>
                        </div>

                        <div class="txn-card d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img class="avatar-24" src="{{ asset('assets/images/user/u2.png') }}" alt="">
                                <div>
                                    <div class="fw-semibold">خرید کارگاه «پرامپت‌های ترسناک»</div>
                                    <div class="text-muted small">۱۴۰۳/۰۶/۲۶ - ۱۸:۰۳ | کد: TRX-9532</div>
                                </div>
                            </div>
                            <div class="txn-amount out">- ۲۵۰,۰۰۰</div>
                        </div>

                        <div class="txn-card d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img class="avatar-24" src="{{ asset('assets/images/user/u3.png') }}" alt="">
                                <div>
                                    <div class="fw-semibold">بازگشت وجه سفارش #A-2215</div>
                                    <div class="text-muted small">۱۴۰۳/۰۶/۲۲ - ۱۰:۲۱</div>
                                </div>
                            </div>
                            <div class="txn-amount in">+ ۲۵۰,۰۰۰</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn--border" data-bs-dismiss="modal">بستن</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" dir="rtl">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">مشخصات کاربری</h5>
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('assets/images/user/user1.png') }}" alt="avatar" class="avatar-24" style="width:48px;height:48px;border-radius:12px;">
                        <div>
                            <div class="fw-semibold">امیرارسلان رهنما</div>
                            <div class="text-muted small">کاربر عادی</div>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label">نام</label>
                                <input type="text" name="first_name" class="form-control" value="امیرارسلان" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">نام خانوادگی</label>
                                <input type="text" name="last_name" class="form-control" value="رهنما" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">شماره موبایل</label>
                                <input type="tel" name="mobile" class="form-control" value="09xxxxxxxxx" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">ایمیل</label>
                                <input type="email" name="email" class="form-control" value="example@mail.com">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">تاریخ تولد</label>
                                <input type="date" name="birthdate" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">آواتار</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label class="form-label">بیو</label>
                                <textarea name="bio" class="form-control" rows="3" placeholder="درباره‌ی خودتان..."></textarea>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn--border" data-bs-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn--base">ذخیره تغییرات</button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <form action="{{ route('profile.password') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label">رمز فعلی</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">رمز جدید</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">تکرار رمز جدید</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn--black">تغییر رمز</button>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button class="btn btn--border" data-bs-dismiss="modal">بستن</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    <script>
        // نمونه ایجکسی (جایگزین API واقعی کن)
        document.addEventListener('DOMContentLoaded', function () {
            // اگر لازم شد، هنگام باز شدن مودال‌ها داده‌ها را لود کن
            const walletModal = document.getElementById('walletModal');
            walletModal.addEventListener('show.bs.modal', () => {
                // نمونه: فراخوانی Ajax برای گرفتن بالانس/تراکنش‌ها
                // fetch('{{ route('wallet.data') }}').then(r => r.json()).then(populateWallet);
            });
        });

        function populateWallet(data) {
            // data: { balance, transactions: [...] }
            // اینجا DOM را پر کن (اگر خواستی داینامیک کنی)
        }
    </script>
@endpush

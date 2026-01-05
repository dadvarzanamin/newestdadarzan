@extends('layouts.base')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
<link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/quill.snow.css')}}" >
<link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/katex.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/dropzone.min.css')}}"/>

<style>
    /* Toolbar should stay LTR (icons/controls are designed LTR) */
    .ql-toolbar,
    .ql-toolbar * {
        /*direction: ltr;*/
    }

    /* Editor content should be RTL for Persian */
    .ql-editor {
        direction: rtl;
        text-align: right;
        line-height: 1.9;
        min-height: 180px;
    }

    /* Optional: make the editor fit Bootstrap card nicely */
    .ql-toolbar.ql-snow {
        border-top-left-radius: .5rem;
        border-top-right-radius: .5rem;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: .5rem;
        border-bottom-right-radius: .5rem;
    }
</style>


@endsection

@section('content')

    <div class="row gy-4 mb-4">
    <div class="alert alert-info"> {{Auth::user()->name}} خوش آمدید به داشبورد مدیریت 👋</div>

    </div>

    <div class="row gy-4 mb-4">


        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">ویرایشگر متن</h5>
                </div>

                <div class="quill-wrapper">
                    {{-- Quill Toolbar --}}
                    <div id="snow-toolbar">
                <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                </span>
                        <span class="ql-formats">
                    <button class="ql-bold" type="button"></button>
                    <button class="ql-italic" type="button"></button>
                    <button class="ql-underline" type="button"></button>
                    <button class="ql-strike" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                </span>
                        <span class="ql-formats">
                    <button class="ql-script" value="sub" type="button"></button>
                    <button class="ql-script" value="super" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-header" value="1" type="button"></button>
                    <button class="ql-header" value="2" type="button"></button>
                    <button class="ql-blockquote" type="button"></button>
                    <button class="ql-code-block" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-list" value="ordered" type="button"></button>
                    <button class="ql-list" value="bullet" type="button"></button>
                    <button class="ql-indent" value="-1" type="button"></button>
                    <button class="ql-indent" value="+1" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-direction" value="rtl" type="button"></button>
                    <select class="ql-align"></select>
                </span>
                        <span class="ql-formats">
                    <button class="ql-link" type="button"></button>
                    <button class="ql-image" type="button"></button>
                    <button class="ql-video" type="button"></button>
                    <button class="ql-formula" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-clean" type="button"></button>
                </span>
                    </div>

                    {{-- Quill Editor --}}
                    <div id="snow-editor">
                        <p>متن نمونه…</p>
                    </div>

                    {{-- Hidden input for submitting HTML (optional) --}}
                    <input type="hidden" name="content_html" id="content_html" value="">
                </div>

            </div>
        </div>



        <div class="row gy-4 mb-4">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="mdi mdi-chart-box mdi-24px"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-info mt-4 pt-1" data-bs-toggle="modal" data-bs-target="#lawyersModal" style="cursor: pointer;">
                            <p class="text-muted">تعداد وکلا</p>
                            <h5 class="mb-2">{{ DB::table('users')->whereRole_id(5)->count() }}</h5>
                        </div>
                        <div class="modal fade" id="lawyersModal" tabindex="-1" aria-labelledby="lawyersModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="lawyersModalLabel">لیست وکلا</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive rounded-3">
                                            <div style="max-height: 400px; overflow-y: auto;">
                                                <table class="table table-sm table-bordered" style="border-collapse: collapse;">
                                                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                                    <tr>
                                                        <th class="py-3">تصویر </th>
                                                        <th class="py-3">نام کاربری </th>
                                                        <th class="py-3">ایمیل</th>
                                                        <th class="py-3">نقش</th>
                                                        <th class="py-3">وضعیت</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(DB::table('users')->whereRole_id(5)->get() as $user)
                                                        <tr>
                                                            <td>
                                                                @if($user->image)
                                                                    <img data-src="{{ $user->image }}" class="w-px-40 h-auto rounded-circle" />
                                                                @else
                                                                    @if($user->gender == 1)
                                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @elseif($user->gender == 2)
                                                                        <img src="{{ asset('assets/img/avatars/8.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @else
                                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                   @endif
                                                                @endif
                                                            </td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->level == 'admin' ? 'مدیر' : ($user->level == 'applicant' ? 'سرمایه‌پذیر' : 'نامشخص') }}</td>
                                                            <td>فعال</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="mdi mdi-chart-box mdi-24px"></i>
                                </div>
                            </div>
                            {{--<div class="d-flex align-items-center">--}}
                            {{--    <p class="mb-0 text-success me-1"></p>--}}
                            {{--    <i class="mdi mdi-chevron-up text-success"></i>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card-info mt-4 pt-1" data-bs-toggle="modal" data-bs-target="#clientsModal" style="cursor: pointer;">
                            <p class="text-muted"> تعداد موکلین </p>
                            <h5 class="mb-2">{{ DB::table('users')->whereRole_id(4)->count() }}</h5>

                            {{--<div class="badge bg-label-secondary rounded-pill">4 ماه پیش</div>--}}
                        </div>
                        <div class="modal fade" id="clientsModal" tabindex="-1" aria-labelledby="clientsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="clientsModalLabel">لیست موکلین</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive rounded-3">
                                            <div style="max-height: 400px; overflow-y: auto;">
                                                <table class="table table-sm table-bordered" style="border-collapse: collapse;">
                                                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                                    <tr>
                                                        <th class="py-3">تصویر </th>
                                                        <th class="py-3">نام کاربری </th>
                                                        <th class="py-3">ایمیل</th>
                                                        <th class="py-3">نقش</th>
                                                        <th class="py-3">وضعیت</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(DB::table('users')->whereRole_id(4)->get() as $user)
                                                        <tr>
                                                            <td>
                                                                @if($user->image)
                                                                    <img data-src="{{ $user->image }}" class="w-px-40 h-auto rounded-circle" />
                                                                @else
                                                                    @if($user->gender == 1)
                                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @elseif($user->gender == 2)
                                                                        <img src="{{ asset('assets/img/avatars/8.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @else
                                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->level == 'admin' ? 'مدیر' : ($user->level == 'applicant' ? 'سرمایه‌پذیر' : 'نامشخص') }}</td>
                                                            <td>فعال</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="mdi mdi-chart-box mdi-24px"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-info mt-4 pt-1" data-bs-toggle="modal" data-bs-target="#studentsModal" style="cursor: pointer;">
                            <p class="text-muted">تعداد دانشپذیران</p>
                            <h5 class="mb-2">{{ DB::table('users')->whereRole_id(6)->count() }}</h5>
                        </div>
                        <div class="modal fade" id="studentsModal" tabindex="-1" aria-labelledby="studentsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="studentsModalLabel">لیست دانشپذیران</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive rounded-3">
                                            <div style="max-height: 400px; overflow-y: auto;">
                                                <table class="table table-sm table-bordered" style="border-collapse: collapse;">
                                                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                                    <tr>
                                                        <th class="py-3">تصویر </th>
                                                        <th class="py-3">نام کاربری </th>
                                                        <th class="py-3">ایمیل</th>
                                                        <th class="py-3">نقش</th>
                                                        <th class="py-3">وضعیت</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(DB::table('users')->whereRole_id(6)->get() as $user)
                                                        <tr>
                                                            <td>
                                                                @if($user->image)
                                                                    <img data-src="{{ $user->image }}" class="w-px-40 h-auto rounded-circle" />
                                                                @else
                                                                    @if($user->gender == 1)
                                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @elseif($user->gender == 2)
                                                                        <img src="{{ asset('assets/img/avatars/8.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @else
                                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="w-px-40 h-auto rounded-circle" />
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->level == 'admin' ? 'مدیر' : ($user->level == 'applicant' ? 'سرمایه‌پذیر' : 'نامشخص') }}</td>
                                                            <td>فعال</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="mdi mdi-chart-box mdi-24px"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-info mt-4 pt-1" data-bs-toggle="modal" data-bs-target="#contractsModal" style="cursor: pointer;">
                            <p class="text-muted">تعداد نمونه قرارداد</p>
                            <h5 class="mb-2">
                                {{DB::table('products')->Where('product_type' , 'contract')->where('status' , 4)->count()}}
                            </h5>
                        </div>
                        <div class="modal fade" id="contractsModal" tabindex="-1" aria-labelledby="contractsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="contractsModalLabel">تعداد طرح خاتمه یافته</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive rounded-3">
                                            <div style="max-height: 400px; overflow-y: auto;">
                                                <table class="table table-sm table-bordered" style="border-collapse: collapse;">
                                                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                                    <tr>
                                                        <th class="py-3"> عنوان </th>
                                                        <th class="py-3"> مبلغ </th>
                                                        <th class="py-3"> تعداد کلیک </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(DB::table('products')->Where('product_type' , 'contract')->where('status' , 4)->get() as $contract)
                                                        <tr>
                                                            <td>{{$contract->title}}</td>
                                                            <td>{{$contract->price}}</td>
                                                            <td>{{$contract->count_click}} </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="mdi mdi-chart-box mdi-24px"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-info mt-4 pt-1" data-bs-toggle="modal" data-bs-target="#rejectprojectsModal" style="cursor: pointer;">
                            <p class="text-muted">تعداد کارگاه ها</p>
                            <h5 class="mb-2">
                                {{DB::table('products')->Where('product_type' , 'workshop')->count()}}
                            </h5>
                        </div>
                        <div class="modal fade" id="rejectprojectsModal" tabindex="-1" aria-labelledby="rejectprojectsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectprojectsModalLabel">تعداد مقالات</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive rounded-3">
                                            <div style="max-height: 400px; overflow-y: auto;">
                                                <table class="table table-sm table-bordered" style="border-collapse: collapse;">
                                                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                                    <tr>
                                                        <th class="py-3">نام کارگاه</th>
                                                        <th class="py-3">نام استاد</th>
                                                        <th class="py-3">تعداد ثبت نامی</th>
                                                        <th class="py-3">مبلغ دریافتی</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(DB::table('invoices')->leftjoin('products' ,'products.id' ,'=' , 'invoices.product_id')
                                                                 ->select(DB::raw('COUNT(invoices.id) as user_count'),DB::raw('SUM(invoices.final_price) as total_amount') , 'products.title' , 'products.item1 as teacher_name')
                                                                 ->Where('products.product_type' , 'workshop')
                                                                 ->where('invoices.price_status' , 4)
                                                                 ->groupBy('products.id', 'products.title', 'products.item1')
                                                                 ->get() as $workshop)
                                                        <tr>
                                                            <td>{{$workshop->title}}</td>
                                                            <td>{{$workshop->teacher_name }}</td>
                                                            <td>{{$workshop->user_count }}</td>
                                                            <td>{{$workshop->total_amount > 0 ? number_format($workshop->total_amount) : 'رایگان' }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="mdi mdi-chart-box mdi-24px"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-info mt-4 pt-1">
                            <p class="text-muted">تعداد پست ها</p>
                            {{DB::table('posts')->Where('status' , 4)->count()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4">

            <!-- Line Chart -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">فروش کارگاه ها</h5>
                            <small class="text-muted primary-font">مجموع فروش هر کارگاه</small>
                        </div>
                        <div class="d-sm-flex d-none align-items-center primary-font">
                            <h5 class="fw-bold mb-0 me-3">1,300,000 تومان</h5>
                            <span class="badge bg-label-secondary">
                      <i class="bx bx-down-arrow-alt bx-xs text-danger"></i>
                      <span class="align-middle">20%</span>
                    </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Line Chart -->

            <div class="col-lg-12 col-md-12 col-12">
                <div class="card">

                    <div class="row g-0">

                        <div class="col-md-7 col-12">
                            <div class="card-header border-0 pb-1 pb-md-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="mb-1 d-flex align-items-center">
                                            <i class="mdi mdi-chart-areaspline ms-1"></i>
                                            کارگاه‌ها
                                        </h5>
                                        <small class="mb-0 text-body">
                                            مجموع کارگاه‌های برگزار شده
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-2 pt-0">
                                <div id="projectTimelineChart"></div>
                            </div>
                        </div>

                        {{-- سمت راست: لیست کارگاه‌ها --}}
                        <div class="col-md-5 col-12 border-start">
                            <div class="card-header border-0 pb-2 pt-3 pt-md-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1 d-flex align-items-center">
                                            <i class="mdi mdi-teach ms-1"></i>
                                            لیست کارگاه‌ها
                                        </h5>
{{--                                        <small class="text-body mb-0 d-block">--}}
{{--                                            پروژه در حال اجرا--}}
{{--                                        </small>--}}
                                    </div>

                                    <div class="dropdown">
                                        <button class="btn btn-icon p-0" type="button"
                                                id="projectTimeline"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectTimeline">
                                            <a class="dropdown-item" href="javascript:void(0);">
                                                <i class="mdi mdi-refresh ms-1"></i> نوسازی
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);">
                                                <i class="mdi mdi-share-variant ms-1"></i> اشتراک‌گذاری
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);">
                                                <i class="mdi mdi-update ms-1"></i> بروزرسانی
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-2">

                                @foreach(
                                    DB::table('invoices')
                                        ->leftJoin('products' ,'products.id' ,'=' , 'invoices.product_id')
                                        ->select(
                                            DB::raw('COUNT(invoices.id) as user_count'),
                                            DB::raw('SUM(invoices.final_price) as total_amount'),
                                            'products.title',
                                            'products.item1 as teacher_name',
                                            'products.cover'
                                        )
                                        ->where('products.product_type' , 'workshop')
                                        ->where('invoices.price_status' , 4)
                                        ->groupBy('products.id', 'products.title', 'products.item1', 'products.cover')
                                        ->get() as $workshop
                                )

                                    <div class="workshop-item d-flex align-items-center mb-3">

                                        {{-- بخش تصویر 16:9 وسط‌چین --}}
                                        <div class="workshop-thumb ms-3 ml-2">
                                            <img src="{{ asset('storage/'.$workshop->cover) }}" alt="{{ $workshop->title }}">
                                        </div>

                                        {{-- بخش متن --}}
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="fw-semibold workshop-title" title="{{ $workshop->title }}">
                                                    {{ $workshop->title }}
                                                </h6>

                                                <span class="chip chip-sm participant-chip">
                {{ $workshop->user_count }} نفر
            </span>
                                            </div>

                                            @if(!empty($workshop->teacher_name))
                                                <small class="text-muted d-block mt-1">
                                                    مدرس: {{ $workshop->teacher_name }}
                                                </small>
                                            @endif

                                            <small class="text-muted d-block mt-1">
                                                مجموع فروش:
                                                <span class="fw-semibold">
                {{ number_format($workshop->total_amount) }} تومان
            </span>
                                            </small>
                                        </div>

                                    </div>
                                @endforeach

                                @if(
                                    DB::table('invoices')
                                        ->leftJoin('products' ,'products.id' ,'=' , 'invoices.product_id')
                                        ->where('products.product_type' , 'workshop')
                                        ->where('invoices.price_status' , 4)
                                        ->count() === 0
                                )
                                    <div class="text-center py-4">
                                        <i class="mdi mdi-calendar-blank-outline d-block mb-2 mdi-24px text-muted"></i>
                                        <span class="text-muted small d-block">هنوز کارگاهی ثبت نشده است.</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-12">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-header d-flex align-items-center justify-content-between bg-white rounded-top-4">
                        <h6 class="card-title m-0 me-2 fw-bold">موجودی کیف پول ها</h6>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="paymentHistory" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical mdi-24px"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="paymentHistory">
                                <a class="dropdown-item" href="javascript:void(0);">۲۸ روز گذشته</a>
                                <a class="dropdown-item" href="javascript:void(0);">ماه گذشته</a>
                                <a class="dropdown-item" href="javascript:void(0);">سال پیش</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body py-0">
                        <div class="payment-scroll">
                            <ul class="list-group list-group-flush">
                                @foreach($wallets as $wallet)
                                    <li class="list-group-item px-3 py-3 payment-item d-flex align-items-center gap-3">

                                        <div class="payment-logo rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                            <img src="{{$wallet->gender == 2 ? asset('assets/img/avatars/8.png') : asset('assets/img/avatars/1.png')}}" alt="user" width="28" height="28" class="rounded-2">
                                        </div>

                                        <div class="flex-grow-1 min-w-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-truncate fw-semibold">{{ $wallet->name }}</div>
{{--                                                <div class="small text-muted ms-2">{{ $finance->date }}</div>--}}
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <div class="fw-semibold">{{ number_format($wallet->balance) }} <span class="text-muted small">تومان</span></div>
{{--                                            <div class="text-muted small">{{ number_format($wallet->balance) }}</div>--}}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-12">
                <div class="card h-100 border-0 shadow-sm rounded-4 portfolio-card">
                    <!-- Header -->
                    <div class="card-header d-flex align-items-center justify-content-between bg-white rounded-top-4">
                        <div>
                            <h6 class="card-title m-0 me-2 fw-bold">مجموع پرداختی کارگاه ها (ریال)</h6>
                            <small class="text-muted">نمای کلی سهم هر کارگاه از کل پرداختی ها</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="portfolioMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical mdi-24px"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="portfolioMenu">
                                <a class="dropdown-item" href="javascript:void(0);">۲۸ روز گذشته</a>
                                <a class="dropdown-item" href="javascript:void(0);">ماه گذشته</a>
                                <a class="dropdown-item" href="javascript:void(0);">سال پیش</a>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="card-body py-2">
                        <div class="portfolio-scroll">
                            <ul class="list-group list-group-flush">
{{--                                @foreach($projects as $project)--}}
{{--                                    @php--}}
{{--                                        $share = $totalPaid > 0 ? round(($project->total_amount / $totalPaid) * 100) : 0;--}}
{{--                                        // tone: primary (>=25), info (10-24), warning (<10)--}}
{{--                                        $tone = $share >= 25 ? 'primary' : ($share >= 10 ? 'info' : 'warning');--}}
{{--                                    @endphp--}}

{{--                                    <li class="list-group-item px-3 py-3 border-0 border-bottom d-flex flex-column portfolio-item">--}}
{{--                                        <!-- Top row -->--}}
{{--                                        <div class="d-flex justify-content-between align-items-center mb-1">--}}
{{--                                            <div class="d-flex align-items-center gap-2 min-w-0">--}}
{{--                                                <span class="tone-dot tone-{{ $tone }}"></span>--}}
{{--                                                <span class="fw-semibold text-dark text-truncate" title="{{ $project->title }}">{{ $project->title }}</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="text-end">--}}
{{--                                                <span class="fw-semibold">{{ number_format($project->total_amount) }}</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <!-- Meta -->--}}
{{--                                        <div class="d-flex justify-content-between align-items-center mb-2 small">--}}
{{--                                            <span class="text-muted">سهم از پورتفو</span>--}}
{{--                                            <span class="pill pill-{{ $tone }}">{{ $share }}%</span>--}}
{{--                                        </div>--}}

{{--                                        <!-- Progress (gradient) -->--}}
{{--                                        <div class="progress sleek" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $share }}">--}}
{{--                                            <div class="progress-bar bar-{{ $tone }}" style="width: {{ $share }}%;"></div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-12">
                <div class="card border-0 shadow-sm rounded-4 user-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center bg-white rounded-top-4">
                        <h6 class="m-0 fw-bold">کاربران</h6>
                        <div class="d-flex gap-2">
                            <input id="usersSearch" type="text" class="form-control form-control-sm rounded-3"
                                   placeholder="جستجو نام یا ایمیل..." dir="rtl" style="min-width:220px">
                        </div>
                    </div>

                    <div class="card-body py-0">
                        <div class="user-scroll">
                            <ul class="list-group list-group-flush">
                                @foreach($users as $user)
                                    @php
                                        $avatar = $user->gender == 2
                                          ? asset('assets/img/avatars/8.png')
                                          : asset('assets/img/avatars/1.png');

                                        $roleLabel = $user->level === 'admin' ? 'مدیر'
                                                    : ($user->level === 'applicant' ? 'سرمایه‌پذیر' : 'نامشخص');

                                        $statusLabel = 'فعال';
                                        $statusTone  = 'success'; // در صورت نیاز از فیلد وضعیت بخوانید

                                        $lastSeen = ($user->lastLogin && $user->lastLogin->created_at)
                                          ? jdate($user->lastLogin->created_at)->format('Y/m/d ساعت H:i')
                                          : 'ورود ثبت نشده';
                                    @endphp

                                    <li class="list-group-item px-3 py-3 border-0 border-bottom user-item"
                                        data-name="{{ Str::lower($user->name) }}"
                                        data-email="{{ Str::lower($user->email) }}">

                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Avatar -->
                                            <div class="user-avatar rounded-circle overflow-hidden flex-shrink-0">
                                                <img src="{{ $avatar }}" alt="avatar" width="44" height="44">
                                            </div>

                                            <!-- Main info -->
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="min-w-0">
                                                        <div class="fw-semibold text-truncate" title="{{ $user->name }}">{{ $user->name }}</div>
                                                        <div class="small text-muted text-truncate" title="{{ $user->email }}">{{ $user->email }}</div>
                                                    </div>
                                                    <div class="text-end ms-2">
                                                    <span class="badge role-badge me-1
                                                      {{ $user->level==='admin' ? 'role-admin' : ($user->level==='applicant' ? 'role-applicant' : 'role-unknown') }}">
                                                      {{ $roleLabel }}
                                                    </span>
                                                        <span class="pill pill-{{ $statusTone }}">{{ $statusLabel }}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                                    <span class="d-flex align-items-center gap-1">
                                                      <i class="mdi mdi-clock-outline mdi-18px"></i> آخرین ورود:
                                                    </span>
                                                    <span class="text-end">{{ $lastSeen }}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card h-100">
                    <div class="card-header pb-1">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-1">فروش سالانه</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="monthlyBudgetDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="monthlyBudgetDropdown">
                                    <a class="dropdown-item" href="javascript:void(0);">نو سازی</a>
                                    <a class="dropdown-item" href="javascript:void(0);">بروزرسانی</a>
                                    <a class="dropdown-item" href="javascript:void(0);">اشتراک گذاری</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="monthlyBudgetChart"></div>
                        <div class="mt-3">
                            <p class="mb-0 text-muted">در سال گذشته شما فروش داشته اید</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 me-2">جدول زمانبندی جلسات</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="meetingSchedule" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical mdi-24px"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="meetingSchedule">
                                <a class="dropdown-item" href="javascript:void(0);">28 روز گذشته</a>
                                <a class="dropdown-item" href="javascript:void(0);">ماه گذشته</a>
                                <a class="dropdown-item" href="javascript:void(0);">سال پیش</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <ul class="p-0 m-0">
{{--                            @foreach($calendars as $calendar)--}}
{{--                                <li class="d-flex mb-4 pb-1">--}}
{{--                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">--}}
{{--                                        <div class="me-2">--}}
{{--                                            <h6 class="mb-0 fw-semibold">{{$calendar->title}}</h6>--}}
{{--                                            <small class="text-muted">--}}
{{--                                                <i class="mdi mdi-calendar-blank-outline mdi-14px"></i>--}}
{{--                                                <span>{{$calendar->start}}</span> ----}}
{{--                                                <span>{{$calendar->location}}</span>--}}
{{--                                            </small>--}}
{{--                                        </div>--}}
{{--                                        <div class="badge bg-label-primary rounded-pill">--}}
{{--                                            @if($calendar->label === 'meeting')--}}
{{--                                                جلسه--}}
{{--                                            @elseif($calendar->label === 'session')--}}
{{--                                                نشست--}}
{{--                                            @elseif($calendar->label === 'event')--}}
{{--                                                رویداد--}}
{{--                                            @elseif($calendar->label === 'person')--}}
{{--                                                شخصی--}}
{{--                                            @elseif($calendar->label === 'other')--}}
{{--                                                سایر--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="card h-100">
                    <div class="card-header pb-1">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-1">میزان تحقق اهداف</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="organicSessionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="organicSessionsDropdown">
                                    <a class="dropdown-item" href="javascript:void(0);">28 روز گذشته</a>
                                    <a class="dropdown-item" href="javascript:void(0);">ماه گذشته</a>
                                    <a class="dropdown-item" href="javascript:void(0);">سال پیش</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="organicSessionsChart"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/timeline-chart.js') }}"></script>
    <script src="{{ asset('assets/js/charts-apex.js') }}"></script>
{{--    <script src="{{asset('assets/vendor/js/katex.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/vendor/js/quill.min.js')}}"></script>--}}
    {{-- KaTeX must be loaded BEFORE initializing Quill formula module --}}
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>

    <script>
        "use strict";

        document.addEventListener("DOMContentLoaded", function () {
            const editorEl = document.querySelector("#snow-editor");
            const toolbarEl = document.querySelector("#snow-toolbar");
            if (!editorEl || !toolbarEl) return;

            // If formula module is enabled, KaTeX must exist on window
            if (!window.katex) {
                console.error("KaTeX is not loaded. Formula module requires KaTeX.");
                // You can return here if you want to prevent Quill from initializing:
                // return;
            }

            const quill = new Quill(editorEl, {
                theme: "snow",
                bounds: editorEl,
                modules: {
                    toolbar: toolbarEl,
                    formula: true
                }
            });

            // Keep hidden input synced (optional, useful for form submit)
            const hidden = document.querySelector("#content_html");
            if (hidden) {
                const sync = () => { hidden.value = quill.root.innerHTML; };
                sync();
                quill.on("text-change", sync);
            }
        });
    </script>


    <script>
        // جستجوی سبک در کلاینت بر اساس نام/ایمیل
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('usersSearch');
            const items = Array.from(document.querySelectorAll('.user-item'));
            if (!input) return;

            input.addEventListener('input', () => {
                const q = (input.value || '').trim().toLowerCase();
                items.forEach(li => {
                    const name  = li.dataset.name  || '';
                    const email = li.dataset.email || '';
                    li.style.display = (name.includes(q) || email.includes(q)) ? '' : 'none';
                });
            });
        });
    </script>

@endpush


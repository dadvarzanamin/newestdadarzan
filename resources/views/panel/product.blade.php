@extends('layouts.base')
@section('title', 'مدیریت منوی داشبورد')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'}}" />
    <link rel="stylesheet" href="{{'https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css'}}">
    <script type="text/javascript" src="{{'https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js'}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        jdp-container{z-index:99999999 !important;}
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{$thispage['list']}}</h5>
                @if(Gate::allows('can-access', ['product', 'insert']))
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">{{$thispage['add']}}</a>
                @endif
            </div>

            <div class="table-responsive">
                <style> table{margin: 0 auto;width: 100% !important;clear: both;border-collapse: collapse;table-layout: fixed;word-wrap:break-word;} .dt-layout-start{margin-right: 0 !important;} .dt-layout-end{margin-left: 0 !important;}</style>
                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>سریال</th>
                        <th>نام خدمات</th>
                        <th>هزینه خدمات</th>
                        <th>نوع خدمات</th>
                        <th>تاریخ شروع</th>
                        <th>وضعیت</th>
                        <th>تغییر</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title w-100" id="deleteModalLabel">{{ $thispage['delete'] }}</h5>
                        <button type="button" class="btn-close position-absolute start-0 mx-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        آیا از حذف این زیر منو مطمئن هستید؟
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">انصراف</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">{{$thispage['add']}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-4" action="{{route(request()->segment(2).'.store') }}">
                        {{csrf_field()}}
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input required type="text" class="form-control" id="title" name="title" placeholder="عنوان فارسی" >
                                <label for="title">عنوان فارسی</label>
                                <div class="invalid-feedback" id="titleFeedback">عنوان فارسی اجباری می باشد.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="en_title" name="en_title" placeholder="عنوان انگلیسی" >
                                <label for="en_title">عنوان انگلیسی</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="زیر عنوان" >
                                <label for="sub_title">زیر عنوان</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="item1" name="item1" placeholder="ایتم مربوط به خدمات" >
                                <label for="item1">ایتم مربوط به خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="item2" name="item2" placeholder="ایتم مربوط به خدمات" >
                                <label for="item2">ایتم مربوط به خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="item3" name="item3" placeholder="ایتم مربوط به خدمات" >
                                <label for="item3">ایتم مربوط به خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="item4" name="item4" placeholder="ایتم مربوط به خدمات" >
                                <label for="item4">ایتم مربوط به خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="item5" name="item5" placeholder="ایتم مربوط به خدمات" >
                                <label for="item5">ایتم مربوط به خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control input-number" id="price" name="price" placeholder="هزینه خدمات" >
                                <label for="price">هزینه خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="product_type" id="product_type" class="form-control">
                                    <option value="" >انتخاب کنید</option>
                                    <option value="workshop" >کارگاه</option>
                                    <option value="estelam" >استعلام</option>
                                    <option value="contract" >قرارداد</option>
                                </select>
                                <label for="product_type">نوع خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="product_use" id="product_use" multiple class="form-control">
                                    <option value="" >انتخاب کنید</option>
                                    <option value="حضوری" >حضوری</option>
                                    <option value="آنلاین" >آنلاین</option>
                                </select>
                                <label for="product_type">شرایط خدمات</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="product_time" name="product_time" placeholder="زمان اجرا" >
                                <label for="price">زمان اجرا</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" data-jdp id="start_date" autocomplete="off" name="start_date" placeholder="تاریخ شروع" >
                                <label for="price">تاریخ شروع</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" data-jdp id="end_date" autocomplete="off" name="end_date" placeholder="تاریخ پایان" >
                                <label for="price">تاریخ پایان</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" data-jdp id="exp_date" autocomplete="off" name="exp_date" placeholder="تاریخ انقضا" >
                                <label for="price">تاریخ انقضا</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="certificate" id="certificate" class="form-control">
                                    <option value="" >انتخاب کنید</option>
                                    <option value="دارد" >دارد</option>
                                    <option value="ندارد" >ندارد</option>
                                </select>
                                <label for="certificate">گواهی دوره</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control input-number" id="price_certificate" name="price_certificate" placeholder="هزینه گواهینامه">
                                <label for="class">هزینه گواهینامه</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="status" id="status" class="form-control">
                                    <option value="0" >لغو</option>
                                    <option value="1" >غیر فعال</option>
                                    <option value="2" >تکمیل ظرفیت</option>
                                    <option value="3">پایان یافته</option>
                                    <option value="4">فعال</option>
                                </select>
                                <label for="status">وضعیت نمایش</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <textarea name="description" id="description" class="form-control" cols="30" rows="30"></textarea>
                                <label for="class">توضیحات کلی</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <textarea name="full_description" id="full_description" class="form-control" cols="30" rows="30"></textarea>
                                <label for="class">توضیحات طولانی</label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">ذخیره اطلاعات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">ویرایش اطلاعات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <div class="text-center text-muted py-5">در حال بارگذاری...</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendor/js/dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/formhandler.js')}}"></script>
    <script type="text/javascript">
        $(function () {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route(request()->segment(2).'.index')}}",
                columns: [
                    {data: 'id'             , name: 'id'            },
                    {data: 'title'          , name: 'title'         },
                    {data: 'price'          , name: 'price'         },
                    {data: 'product_type'   , name: 'product_type'  },
                    {data: 'start_date'     , name: 'start_date'    },
                    {data: 'status'         , name: 'status'        },
                    {data: 'action'         , name: 'action', orderable: true, searchable: true},
                ],
                language: {
                    url: "{{asset('assets/vendor/js/fa.json')}}"
                }
            });

        });
    </script>
@endsection

@extends('layouts.base')
@section('title', 'لیست کاربران داشبورد')
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
                @if(Gate::allows('can-access', ['paneluser', 'insert']))
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">{{$thispage['add']}}</a>
                @endif
            </div>

            <div class="table-responsive">
                <style> table{margin: 0 auto;width: 100% !important;clear: both;border-collapse: collapse;table-layout: fixed;word-wrap:break-word;} .dt-layout-start{margin-right: 0 !important;} .dt-layout-end{margin-left: 0 !important;}</style>
                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>نام و نام خانوادگی</th>
                        <th>نوع کاربر</th>
                        <th>ایمیل</th>
                        <th>موبایل</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
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
                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-4" action="{{route(request()->segment(2).'.'.'store')}}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">نام و نام خانوادگی</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="نام و نام خانوادگی را وارد کنید">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">شماره موبایل</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="نام کاربری را وارد کنید">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">آدرس ایمیل</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="آدرس ایمیل را وارد کنید">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">کد ملی</label>
                                <input type="text" name="national_id" id="national_id" class="form-control" placeholder="کد ملی را وارد کنید">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">نوع کاربری</label>
                                <select name="typeuser_id" id="typeuser_id" class="form-control select-lg select2">
                                    <option value="" selected>انتخاب کنید</option>
                                    @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->title_fa}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تاریخ تولد</label>
                                <input type="text" name="birthday" data-jdp id="birthday" class="form-control" autoComplete="off" placeholder="تاریخ تولد را وارد کنید">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">جنسیت</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" selected>انتخاب کنید</option>
                                    <option value="1" >مرد</option>
                                    <option value="2" >زن</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">رمز عبور</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="رمز عبور را وارد کنید">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تکرار رمز عبور</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="تکرار رمز عبور">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" id="submit" class="btn btn-primary">ذخیره اطلاعات</button>
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
                    {data: 'name'           , name: 'name'      },
                    {data: 'title'          , name: 'title'     },
                    {data: 'email'          , name: 'email'     },
                    {data: 'phone'          , name: 'title'     },
                    {data: 'status'         , name: 'status'    },
                    {data: 'action'         , name: 'action', orderable: true, searchable: true},
                ],
                language: {
                    url: "{{asset('assets/vendor/js/fa.json')}}"
                }
            });

        });
    </script>

@endsection

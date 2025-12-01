@extends('layouts.base')

@section('title', 'مدیریت دوره‌های آموزشی')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/jalalidatepicker.min.css') }}">
    <script type="text/javascript" src="{{ asset('assets/vendor/js/jalalidatepicker.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        jdp-container{z-index:99999999 !important;}
        .select2-container{ z-index: 999999 !important; }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{ $thispage['list'] }}</h5>
                @if(Gate::allows('can-access', ['course', 'insert']))
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">{{ $thispage['add'] }}</a>
                @endif
            </div>

            <div class="table-responsive">
                <style>
                    table{margin:0 auto;width:100% !important;clear:both;border-collapse:collapse;table-layout:auto;word-wrap:break-word;}
                    .dt-layout-start{margin-right:0 !important;}
                    .dt-layout-end{margin-left:0 !important;}
                </style>

                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>سریال</th>
                        <th>عنوان دوره</th>
                        <th>مدرس</th>
                        <th>شرایط</th>
                        <th>هزینه</th>
                        <th>وضعیت</th>
                        <th>تغییر</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title w-100">{{ $thispage['delete'] }}</h5>
                    <button type="button" class="btn-close position-absolute start-0 mx-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    آیا از حذف این دوره مطمئن هستید؟
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $thispage['add'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>

                <div class="modal-body">
                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-4"
                          action="{{ route(request()->segment(2).'.store') }}">
                        @csrf

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input required type="text" class="form-control" name="title" placeholder="عنوان دوره">
                                <label>عنوان دوره</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="en_title" placeholder="عنوان انگلیسی">
                                <label>عنوان انگلیسی</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="instructor" placeholder="مدرس">
                                <label>مدرس</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control input-number" name="price" placeholder="هزینه دوره">
                                <label>هزینه دوره</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="course_use[]" id="course_use" multiple class="form-control">
                                    <option value="حضوری">حضوری</option>
                                    <option value="آنلاین">آنلاین</option>
                                </select>
                                <label>شرایط دوره</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="certificate" class="form-control">
                                    <option value="">انتخاب کنید</option>
                                    <option value="دارد">دارد</option>
                                    <option value="ندارد">ندارد</option>
                                </select>
                                <label>گواهی دوره</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" autocomplete="off" name="start_date" placeholder="تاریخ شروع">
                                <label>تاریخ شروع</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" autocomplete="off" name="end_date" placeholder="تاریخ پایان">
                                <label>تاریخ پایان</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="status" class="form-control">
                                    <option value="0">لغو</option>
                                    <option value="1">غیر فعال</option>
                                    <option value="2">تکمیل ظرفیت</option>
                                    <option value="3">پایان یافته</option>
                                    <option value="4">فعال</option>
                                </select>
                                <label>وضعیت نمایش</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <textarea name="description" class="form-control" cols="30" rows="30"></textarea>
                                <label>توضیحات کلی</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <textarea name="full_description" class="form-control" cols="30" rows="30"></textarea>
                                <label>توضیحات طولانی</label>
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ویرایش اطلاعات</h5>
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
    <script src="{{ asset('assets/vendor/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/formhandler.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route(request()->segment(2).'.index') }}",
                columns: [
                    {data: 'id',          name: 'id',className:'text-center'},
                    {data: 'title',       name: 'title'},
                    {data: 'instructor',  name: 'instructor'},
                    {data: 'course_use',  name: 'course_use', orderable: false, searchable: false},
                    {data: 'price',       name: 'price'},
                    {data: 'status',      name: 'status', orderable: false, searchable: false,className:'text-center'},
                    {data: 'action',      name: 'action', orderable: false, searchable: false,className:'text-center'},
                ],
                language: { url: "{{ asset('assets/vendor/js/fa.json') }}" }
            });
        });
    </script>
@endsection

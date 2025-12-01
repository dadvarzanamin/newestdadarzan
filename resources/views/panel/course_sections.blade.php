@extends('layouts.base')

@section('title', 'مدیریت سرفصل‌های دوره')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column">
                    <h5 class="card-title mb-1">{{ $thispage['list'] ?? 'لیست سرفصل‌ها' }}</h5>
                    @isset($course)
                        <small class="text-muted">دوره: {{ $course->title ?? '-' }}</small>
                    @endisset
                </div>

                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    {{ $thispage['add'] ?? 'افزودن سرفصل' }}
                </a>
            </div>

            <div class="table-responsive">
                <style>
                    table{margin:0 auto;width:100%!important;clear:both;border-collapse:collapse;table-layout:fixed;word-wrap:break-word;}
                    .dt-layout-start{margin-right:0!important;}
                    .dt-layout-end{margin-left:0!important;}
                    th, td { vertical-align: middle; }
                </style>

                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>عنوان سرفصل</th>
                        <th>توضیح کوتاه</th>
                        <th>اولویت</th>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title w-100" id="deleteModalLabel">{{ $thispage['delete'] ?? 'حذف' }}</h5>
                    <button type="button" class="btn-close position-absolute start-0 mx-3" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    آیا از حذف این سرفصل مطمئن هستید؟
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
                    <h5 class="modal-title" id="addModalLabel">{{ $thispage['add'] ?? 'افزودن سرفصل' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">

                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-2"
                          action="{{ route(request()->segment(2).'.store') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="course_id" value="{{ $course->id ?? request('course_id') }}"/>

                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input required type="text" class="form-control" id="title" name="title"
                                       placeholder="عنوان سرفصل">
                                <label for="title">عنوان سرفصل</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="priority" name="priority"
                                       placeholder="اولویت" min="0">
                                <label for="priority">اولویت</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select required name="status" id="status" class="form-control">
                                    <option value="4">فعال</option>
                                    <option value="1">غیرفعال</option>
                                    <option value="0">لغو</option>
                                    <option value="2">تکمیل ظرفیت</option>
                                    <option value="3">پایان یافته</option>
                                </select>
                                <label for="status">وضعیت</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control" id="description" name="description"
                                          style="height: 120px" placeholder="توضیح کوتاه"></textarea>
                                <label for="description">توضیح کوتاه</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
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
                    <h5 class="modal-title" id="editModalLabel">{{ $thispage['edit'] ?? 'ویرایش' }}</h5>
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
            $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('panel/course-section') }}",
                    data: function (d) {
                        d.course_id = {{ (int) $course->id }};
                    }
                },
                columns: [
                    {data: 'title', name: 'title',className:'text-start'},
                    {data: 'description', name: 'description'},
                    {data: 'priority', name: 'priority',className:'text-center'},
                    {data: 'status', name: 'status',className:'text-center'},
                    {data: 'action', name: 'action', orderable: true, searchable: true,className:'text-center'},
                ],
                language: { url: "{{ asset('assets/vendor/js/fa.json') }}" }
            });
        });
    </script>
@endsection

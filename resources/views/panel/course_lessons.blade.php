@extends('layouts.base')

@section('title', 'مدیریت درس‌های سرفصل')

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
                    <h5 class="card-title mb-1">{{ $thispage['list'] ?? 'لیست درس‌ها' }}</h5>
                    @isset($section)
                        <small class="text-muted">
                            دوره: {{ $section->course->title ?? '-' }} | سرفصل: {{ $section->title ?? '-' }}
                        </small>
                    @endisset
                </div>

                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    {{ $thispage['add'] ?? 'افزودن درس' }}
                </a>
            </div>

            <div class="table-responsive">
                <style>
                    table{margin:0 auto;width:100%!important;clear:both;border-collapse:collapse;table-layout:auto;word-wrap:break-word;}
                    .dt-layout-start{margin-right:0!important;}
                    .dt-layout-end{margin-left:0!important;}
                    th, td { vertical-align: middle; }
                </style>

                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>عنوان درس</th>
                        <th>نوع محتوا</th>
                        <th>مدت</th>
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
                    آیا از حذف این درس مطمئن هستید؟
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
                    <h5 class="modal-title" id="addModalLabel">{{ $thispage['add'] ?? 'افزودن درس' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">

                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-2"
                          action="{{ url('panel/course-lesson') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="course_section_id" value="{{ $section->id ?? request('course_section_id') }}"/>

                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input required type="text" class="form-control" id="title" name="title"
                                       placeholder="عنوان درس">
                                <label for="title">عنوان درس</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select required class="form-control" id="lesson_type" name="lesson_type">
                                    <option value="video">ویدئو</option>
                                    <option value="file">جزوه</option>
                                    <option value="mixed">ترکیبی</option>
                                    <option value="text">متن/مقاله</option>
                                </select>
                                <label for="lesson_type">نوع محتوا</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="priority" name="priority" min="0" placeholder="اولویت">
                                <label for="priority">اولویت</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" min="0"
                                       placeholder="مدت (دقیقه)">
                                <label for="duration_minutes">مدت (دقیقه)</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select required name="status" id="status" class="form-control">
                                    <option value="4">فعال</option>
                                    <option value="1">غیرفعال</option>
                                    <option value="0">لغو</option>
                                </select>
                                <label for="status">وضعیت</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 lesson-field lesson-video">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="video_url" name="video_url"
                                       placeholder="لینک ویدئو / آدرس فایل">
                                <label for="video_url">آدرس ویدئو</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 lesson-field lesson-doc">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="file_path" name="file_path"
                                       placeholder="مسیر جزوه / لینک فایل">
                                <label for="file_path">جزوه</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control" id="content" name="content" style="height: 120px"
                                          placeholder="توضیحات / متن درس"></textarea>
                                <label for="content">توضیحات</label>
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

    <script>
        function syncLessonFields() {
            const v = ($('#lesson_type').val() || 'video').toString();
            const showVideo = (v === 'video' || v === 'mixed');
            const showDoc   = (v === 'file'  || v === 'mixed');
            const showText  = (v === 'text');

            $('.lesson-video').toggle(showVideo);
            $('.lesson-doc').toggle(showDoc);

            $('#content').closest('.col-12').toggle(showText);
        }

        $(function () {
            syncLessonFields();
            $(document).on('change', '#lesson_type', syncLessonFields);

            $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('panel/course-lesson') }}",
                    data: function (d) {
                        d.section_id = {{ (int) $section->id }};
                    }
                },

                columns: [
                    {data: 'title', name: 'title',className: 'text-start'},
                    {data: 'lesson_type', name: 'lesson_type'},
                    {data: 'duration', name: 'duration_seconds'},
                    {data: 'priority', name: 'priority'},
                    {data: 'status', name: 'status',className: 'text-center'},
                    {data: 'action', name: 'action', orderable: true, searchable: true,className: 'text-center'},
                ],
                language: { url: "{{ asset('assets/vendor/js/fa.json') }}" }
            });
        });
    </script>
@endsection

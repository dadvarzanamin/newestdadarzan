@extends('layouts.base')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/select2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dropzone.min.css') }}"/>

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
    <style>
        .avatar-column img {
            border-radius: 24px;
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{$thispage['list']}}</h5>
                @if(Gate::allows('can-access', ['requestuser', 'insert']))
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">{{$thispage['add']}}</a>
                @endif
            </div>

            <div class="table-responsive">
                <style> table{margin: 0 auto;width: 100% !important;clear: both;border-collapse: collapse;table-layout: auto;word-wrap:break-word;} .dt-layout-start{margin-right: 0 !important;} .dt-layout-end{margin-left: 0 !important;}</style>
                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>تصویر</th>
                        <th>نام و نام خانوادگی</th>
                        <th>سمت</th>
                        <th>اولویت نمایش</th>
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
                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-4" action="{{ route('emploee.store') }}">
                        {{csrf_field()}}
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input required type="text" class="form-control" id="fullname" name="fullname"
                                       placeholder="نام و نام خانوادگی" >
                                <label for="fullname">نام و نام خانوادگی</label>
                                <div class="invalid-feedback" id="fullnameFeedback">نام و نام خانوادگی اجباری می باشد.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input required type="text" class="form-control" id="side" name="side"
                                       placeholder="سمت" >
                                <label for="side">سمت</label>
                                <div class="invalid-feedback" id="sideFeedback">سمت اجباری می باشد.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="phone" name="phone"
                                       placeholder="شماره موبایل">
                                <label for="phone">شماره موبایل</label>
                                <div class="invalid-feedback" id="phoneFeedback">شماره موبایل اجباری می باشد.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="instagram" name="instagram"
                                       placeholder="آدرس پیج اینستاگرام" >
                                <label for="instagram">آدرس پیج اینستاگرام</label>
                                <div class="invalid-feedback" id="instagramFeedback">آدرس پیج اینستاگرام اجباری می باشد.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="status" id="status" class="form-control">
                                    <option value="0" >لغو</option>
                                    <option value="1" >غیر فعال</option>
                                    <option value="2" >تکمیل ظرفیت</option>
                                    <option value="3" >پایان یافته</option>
                                    <option value="4" selected>فعال</option>
                                </select>
                                <label for="status">وضعیت نمایش</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-floating form-floating-outline">
                                <textarea name="description" id="description" class="form-control" cols="30" rows="30" style="min-height: 100px"></textarea>
                                <label for="class">معرفی</label>
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
    <!-- Media Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel"> بارگزاری </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('storemedia') }}" enctype="multipart/form-data" class="dropzone" id="fileUploadZone" style="min-height: 200px; border-style: dashed; border: 2px dashed #ccc; padding: 20px; margin-bottom: 30px;">
                        <input type="hidden" name="record_id"   id="recordIdInput"  >
                        <input type="hidden" name="subject_id"  id="subjectIdInput" >
                        <input type="hidden" name="title"       id="fileTitleInput" >
                        <div class="dz-message text-center text-muted">
                            <div class="mb-3">
                                <i class="bi bi-cloud-arrow-up" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-2">برای آپلود فایل، کلیک کنید یا فایل را بکشید اینجا</h5>
                            <p class="small text-secondary mb-0">فرمت‌های مجاز: JPG, PNG, PDF, MP4, DOCX (حداکثر 40 مگابایت)</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- مودال پیش نمایش عمومی -->
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">پیش نمایش فایل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body text-center" id="previewContent">
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
                order: [3, 'asc'],
                ajax: "{{route(request()->segment(2).'.index')}}",
                columns: [
                    {data: 'image'      , name: 'image', className: 'avatar-column text-center'   },
                    {data: 'fullname'   , name: 'fullname'  },
                    {data: 'side'       , name: 'side'      },
                    {data: 'priority'   , name: 'priority',className: 'text-center'  },
                    {data: 'status'     , name: 'status',className: 'text-center'    },
                    {data: 'action'     , name: 'action', orderable: true, searchable: true,className: 'text-center'},
                ],
                language: {
                    url: "{{asset('assets/vendor/js/fa.json')}}"
                }
            });

        });
    </script>

    <script>
        //تبدیل اعداد با جدا کننده
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('input', function (e) {
                if (!e.target.matches('input.numeric')) return;
                const input = e.target;

                const selStart = input.selectionStart;
                const rawBefore = input.value;
                const digitsLeft = rawBefore.slice(0, selStart).replace(/[^0-9]/g, '').length;

                let unformatted = rawBefore.replace(/[^0-9]/g, '');
                if (!unformatted) { input.value = ''; return; }

                const formatted = unformatted.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                input.value = formatted;

                let pos = 0, digitsCount = 0;
                while (pos < formatted.length && digitsCount < digitsLeft) {
                    if (/\d/.test(formatted[pos])) digitsCount++;
                    pos++;
                }
                input.setSelectionRange(pos, pos);
            });
        });
    </script>

    <script>
        Dropzone.autoDiscover = false;

        document.addEventListener("DOMContentLoaded", function () {
            const fileFormSelector = "#fileUploadZone";

            const dz = new Dropzone(fileFormSelector, {
                url: "{{ route('storemedia') }}",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                maxFilesize: 20,
                acceptedFiles: 'image/*,video/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                dictDefaultMessage: "فایل‌ها را اینجا رها کنید یا کلیک کنید برای انتخاب",
                init: function () {
                    this.on("sending", function (file, xhr, formData) {
                        formData.append("record_id" , document.getElementById('recordIdInput').value);
                        formData.append("subject_id", document.getElementById('subjectIdInput').value);
                        formData.append("title"     , document.getElementById('fileTitleInput').value);
                    });
                    this.on("success", function (file, response) {
                        const extension = file.name.split('.').pop().toLowerCase();
                        previewFile(response.file_path.replace(/^\/+/, ''), extension);
                        showToast("✅ فایل با موفقیت آپلود شد");
                        this.removeFile(file);
                    });
                    this.on("error", function (file, response) {
                        showToast("❌ خطا در آپلود فایل", "danger");
                    });
                }
            });

            $(document).on('click', '.upload-btn', function () {
                let recordId = $(this).data('id');
                let subjectId = $(this).data('subject');
                let title = $(this).data('title');

                $('#recordIdInput').val(recordId);
                $('#subjectIdInput').val(subjectId);
                $('#fileTitleInput').val(title);

                dz.removeAllFiles(true);
                $('#uploadModal').modal('show');
            });
        });
    </script>
    <script>
        //انتخاب و مدیریت فایل های یک پروژه
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('file-selector')) {
                e.preventDefault();

                const recordId = e.target.dataset.recordId;
                const inputId = e.target.dataset.inputId;
                const url = "{{ route('selectfile') }}?record_id=" + recordId;

                window.open(url, 'FileManager', 'width=800,height=600');

                window.setFileUrl = function (fileUrl) {
                    document.getElementById(inputId).value = fileUrl;
                };
            }
        });
    </script>
@endsection

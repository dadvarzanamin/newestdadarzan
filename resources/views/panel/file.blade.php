@extends('layouts.base')
@section('title', 'مدیریت فایل‌ها')
<style> table{margin: 0 auto;width: 100% !important;clear: both;border-collapse: collapse;table-layout: fixed;word-wrap:break-word;} .dt-layout-start{margin-right: 0 !important;} .dt-layout-end{margin-left: 0 !important;}</style>
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">{{$thispage['list']}}</h5>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">{{$thispage['add']}}</a>
            </div>

            <div class="table-responsive">
                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th> فایل</th>
                        <th>نام فایل</th>
                        <th>نام اصلی فایل</th>
                        <th>نوع فایل</th>
                        <th>سایز فایل</th>
                        <th>تاریخ آپلود</th>
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
    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">{{$thispage['add']}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('storemedia') }}" enctype="multipart/form-data" class="dropzone dz-clickable border rounded-3 shadow-sm bg-light p-4" id="fileUploadZone" style="min-height: 220px; border-style: dashed;">
                        @csrf

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
    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">پیش نمایش فایل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body text-center" id="previewContent">
                    <!-- فایل پیش نمایش اینجا لود می‌شود -->
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
                order: [[0, 'desc']],
                ajax: "{{route(request()->segment(2).'.index')}}",
                columns: [
                    {data: 'file_path'      , name: 'file_path'     },
                    {data: 'title'          , name: 'title'         },
                    {data: 'original_name'  , name: 'original_name' },
                    {data: 'type'           , name: 'type'          },
                    {data: 'size'           , name: 'size'          },
                    {data: 'date'           , name: 'date'          },
                    {data: 'action'         , name: 'action', orderable: true, searchable: true},
                ],
                language: {
                    url: "{{asset('assets/vendor/js/fa.json')}}"
                }
            });

        });
    </script>

    <script>
        Dropzone.autoDiscover = false;

        document.addEventListener("DOMContentLoaded", function () {
            const fileFormSelector = "#fileUploadZone";
            //let currentRecordId = null;
            const recordId = $(this).data('id');

            const dz = new Dropzone(fileFormSelector, {
                url: "{{ route('storemedia') }}",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                maxFilesize: 20,
                acceptedFiles: 'image/*,video/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                dictDefaultMessage: "فایل‌ها را اینجا رها کنید یا کلیک کنید برای انتخاب",
                init: function () {
                    this.on("sending", function (file, xhr, formData) {

                        formData.append("record_id", recordId || document.getElementById('recordIdInput').value);
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
                currentRecordId = $(this).data('id');
                $('#recordIdInput').val(currentRecordId);

                dz.removeAllFiles(true);

                $('#uploadModal').modal('show');
            });
        });
    </script>

@endsection

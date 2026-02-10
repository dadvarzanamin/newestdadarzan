@extends('layouts.base')

@section('title', 'مدیریت نقش کاربران داشبورد')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/select2.min.css')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* برای اینکه داخل مودال روی همه چیز دیده شود */
        .select2-container {
            z-index: 9999 !important;
        }

        /* ظرف اصلی چند انتخابی – شبیه input متریال، راست‌چین و مرتب */
        .select2-container--default .select2-selection--multiple {
            direction: rtl;
            text-align: right;
            min-height: 44px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 4px 6px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
            cursor: text;
        }

        /* خود input کوچک داخل فیلد */
        .select2-container--default .select2-search--inline .select2-search__field {
            margin-top: 0;
            padding: 4px 0;
            font-size: .85rem;
        }

        /* استایل هر آیتم انتخاب شده (chip) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 2px 8px;
            margin: 2px 2px;
            border: none;
            font-size: .8rem;
            /* رنگ پس‌زمینه و متن از تم فعلی می‌آد */
            background-color: rgba(0,0,0,0.06);
            color: inherit;
        }

        /* دکمه حذف روی chip (x) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            margin-left: 4px;
            margin-right: 0;
            font-size: 1rem;
            line-height: 1;
        }

        /* در RTL ترتیب text و X را برعکس کن */
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice {
            flex-direction: row-reverse;
        }

        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
            margin-right: 4px;
            margin-left: 0;
            padding-left: 0;
            border-right: 1px;
        }

        /* Dropdown هم راست‌چین و تمیز */
        .select2-container--default .select2-results > .select2-results__options {
            direction: rtl;
            text-align: right;
            font-size: .85rem;
        }




        /* استایل آیتم‌های انتخاب‌شده (chip) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;      /* متن سمت راست، ضربدر سمت چپ */
            flex-direction: row;
            border-radius: 999px;
            padding: 2px 10px;
            margin: 2px 3px;
            border: none;
            font-size: .85rem;
            background-color: rgba(0,0,0,0.06);
            color: inherit;
        }

        /* خود ضربدر (×) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            float: none;                     /* حذف float پیش‌فرض */
            position: static;                /* از حالت عجیب پیش‌فرض دربیاد */
            margin: 0 0 0 .4rem;             /* فاصله بین ضربدر و متن */
            padding: 0 .3rem 0 0;
            border: none !important;                    /* خط عمودی کنارش حذف بشه */
            border-right: 1px solid rgba(0,0,0,0.12); !important; /* خط جداساز ظریف مثل اسکرین دوم */
            font-size: .9rem;
            line-height: 1;
            color: inherit;
        }

        /* در حالت RTL، متن راست‌چین بماند */
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice {
            text-align: right;
            padding-left: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{$thispage['list']}}</h5>
                @if(Gate::allows('can-access', ['roleuser', 'insert']))
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">{{$thispage['add']}}</a>
                @endif
            </div>

            <div class="table-responsive">
                <style> table{margin: 0 auto;width: 100% !important;clear: both;border-collapse: collapse;table-layout: fixed;word-wrap:break-word;} .dt-layout-start{margin-right: 0 !important;} .dt-layout-end{margin-left: 0 !important;}</style>
                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>عنوان فارسی</th>
                        <th>عنوان انگلیسی</th>
                        <th>دسترسی</th>
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
                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-4" action="{{route(request()->segment(2).'.'.'store')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">عنوان فارسی</label>
                                <input type="text" name="title_fa" id="title_fa" data-required="1" placeholder="عنوان فارسی را وارد کنید" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">عنوان انگلیسی</label>
                                <input type="text" name="title" id="title" data-required="1" placeholder="عنوان را وارد کنید" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">فعال/غیر فعال</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" selected>انتخاب کنید</option>
                                    <option value="4" >فعال</option>
                                    <option value="0" >غیر فعال</option>
                                </select>
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
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/js/dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/formhandler.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route(request()->segment(2).'.index')}}",
                columns: [
                    {data: 'title_fa'       , name: 'title_fa'  },
                    {data: 'title'          , name: 'title'     },
                    {data: 'permission'     , name: 'permission'},
                    {data: 'status'         , name: 'status',className: "text-center"    },
                    {data: 'action'         , name: 'action', orderable: true, searchable: true, className: "text-center"},
                ],
                language: {
                    url: "{{asset('assets/vendor/js/fa.json')}}"
                }
            });

            // Select2 برای فرم افزودن
            $('.select2-permissions').select2({
                dir: "rtl",
                width: '100%',
                placeholder: 'انتخاب دسترسی‌ها',
                dropdownParent: $('#addModal'), // مهم: زیر مودال نره
                closeOnSelect: false
            });

            // اگر داخل editModal هم همین select هست، بعد از لود Ajax:
            $(document).on('shown.bs.modal', '#editModal', function () {
                $(this).find('.select2-permissions').select2({
                    dir: "rtl",
                    width: '100%',
                    placeholder: 'انتخاب دسترسی‌ها',
                    dropdownParent: $('#editModal'),
                    closeOnSelect: false
                });
            });
        });
    </script>
@endsection

@extends('layouts.base')
@section('title', 'مدیریت منوی داشبورد')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/select2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/quill.snow.css') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{$thispage['list']}}</h5>
                @if(Gate::allows('can-access', ['menupanel', 'insert']))
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">{{$thispage['add']}}</a>
                @endif
            </div>

            <div class="table-responsive">
                <style> table{margin: 0 auto;width: 100% !important;clear: both;border-collapse: collapse;table-layout: fixed;word-wrap:break-word;} .dt-layout-start{margin-right: 0 !important;} .dt-layout-end{margin-left: 0 !important;}</style>
                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>سریال</th>
                        <th>عنوان محتوا</th>
                        <th>منو</th>
                        <th>زیر منو</th>
                        <th>اسلاید</th>
                        <th>کاور</th>
                        <th>تصویر</th>
                        <th>ویدئو</th>
                        <th>آپارات</th>
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
                        آیا از حذف این محتوا مطمئن هستید؟
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
                    <form id="addform" data-type="create" method="POST" class="row g-4 mb-4" action="{{ route('content.store') }}">
                        {{csrf_field()}}
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input required type="text" class="form-control" id="title" name="title" placeholder="عنوان محتوا" >
                                <label for="label">عنوان محتوا</label>
                                <div class="invalid-feedback" id="labelFeedback">عنوان محتوا اجباری می باشد.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="اسلاگ">
                                <label for="slug">اسلاگ (اختیاری)</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="عنوان متا">
                                <label for="meta_title">عنوان متا</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="menupanel_id" id="menupanel_id" class="form-control select-lg select2">
                                    <option value="" >انتخاب منو</option>
                                @foreach(DB::table('menus')->whereType('site')->whereStatus(4)->whereNot('id' , 11)->get() as $submenusite)
                                        <option value="{{$submenusite->id}}" >{{$submenusite->label}}</option>
                                    @endforeach
                                </select>
                                <label for="submenu">انتخاب منو</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="submenupanel_id" id="submenupanel_id" class="form-control select-lg select2">
                                    <option value="" >انتخاب زیر منو</option>
                                    @foreach(DB::table('submenus')->whereType('site')->whereStatus(4)->get() as $submenu)
                                        <option value="{{$submenu->id}}" data-menu-id="{{$submenu->menu_id}}">{{$submenu->label}}</option>
                                    @endforeach
                                </select>
                                <label for="submenu">انتخاب زیر منو</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="status" id="status" class="form-control">
                                    <option value="4" >نمایش</option>
                                    <option value="1">غیرفعال</option>
                                    <option value="2">تکمیل ظرفیت</option>
                                    <option value="3">پایان یافته</option>
                                    <option value="0">عدم نمایش</option>
                                </select>
                                <label for="status">نمایش/عدم نمایش</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <textarea name="description" id="description" class="form-control" style="height: 120px" placeholder="توضیحات کوتاه"></textarea>
                                <label for="description">توضیحات کوتاه</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <textarea name="meta_description" id="meta_description" class="form-control" style="height: 120px" placeholder="توضیحات متا"></textarea>
                                <label for="meta_description">توضیحات متا</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="slide" name="slide" placeholder="مسیر فایل اسلاید">
                                <label for="slide">مسیر اسلاید</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="cover" name="cover" placeholder="مسیر فایل کاور">
                                <label for="cover">مسیر کاور</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="image" name="image" placeholder="مسیر تصویر/تصاویر">
                                <label for="image">مسیر تصویر</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="video" name="video" placeholder="مسیر ویدئو">
                                <label for="video">مسیر ویدئو</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="aparat" name="aparat" placeholder="لینک/مسیر آپارات">
                                <label for="aparat">آپارات (لینک/فایل)</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="file" name="file" placeholder="مسیر فایل پیوست">
                                <label for="file">مسیر فایل پیوست</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label mb-2">محتوای کامل</label>
                            <div class="quill-wrapper border rounded p-2">
                                <div id="contentToolbar" class="ql-toolbar ql-snow rounded mb-2">
                                    <span class="ql-formats">
                                        <select class="ql-header">
                                            <option selected></option>
                                            <option value="1"></option>
                                            <option value="2"></option>
                                            <option value="3"></option>
                                        </select>
                                        <select class="ql-font"></select>
                                        <select class="ql-size"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-strike"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <select class="ql-color"></select>
                                        <select class="ql-background"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                        <button class="ql-indent" value="-1"></button>
                                        <button class="ql-indent" value="+1"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <select class="ql-align"></select>
                                        <button class="ql-direction" value="rtl"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-link"></button>
                                        <button class="ql-image"></button>
                                        <button class="ql-video"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-clean"></button>
                                    </span>
                                </div>
                                <div id="contentEditor" style="height: 260px"></div>
                            </div>
                            <input type="hidden" name="content_html" id="content_html">
                            <input type="hidden" name="full_description" id="full_description">
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
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script type="text/javascript">
        $(function () {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route(request()->segment(2).'.index')}}",
                columns: [
                    {data: 'id'             , name: 'id'            ,className: 'text-center'},
                    {data: 'title'          , name: 'title'         ,className: 'text-center'},
                    {data: 'menu_title'     , name: 'menu_title'    ,className: 'text-center'},
                    {data: 'submenu_title'  , name: 'submenu_title' ,className: 'text-center'},
                    {data: 'slide'          , name: 'slide'         ,className: 'text-center'},
                    {data: 'cover'          , name: 'cover'         ,className: 'text-center'},
                    {data: 'image'          , name: 'image'         ,className: 'text-center'},
                    {data: 'video'          , name: 'video'         ,className: 'text-center'},
                    {data: 'aparat'         , name: 'aparat'        ,className: 'text-center'},
                    {data: 'status'         , name: 'status'        ,className: 'text-center'},
                    {data: 'action'         , name: 'action', orderable: true, searchable: true,className: 'text-center'},
                ],
                language: {
                    url: "{{asset('assets/vendor/js/fa.json')}}"
                }
            });


            let quill;
            const hidden = document.getElementById('content_html');
            const fullDescriptionHidden = document.getElementById('full_description');
            const menuSelect = document.getElementById('menupanel_id');
            const submenuSelect = document.getElementById('submenupanel_id');

            const filterSubmenuOptions = (menuId, targetSelect) => {
                const options = Array.from(targetSelect.options);
                options.forEach((option, index) => {
                    if (index === 0) {
                        option.hidden = false;
                        return;
                    }
                    const optionMenuId = option.getAttribute('data-menu-id');
                    option.hidden = !!menuId && optionMenuId !== menuId;
                });

                if (targetSelect.selectedIndex > 0) {
                    const selected = targetSelect.options[targetSelect.selectedIndex];
                    if (selected.hidden) {
                        targetSelect.value = '';
                    }
                }
            };

            const initQuill = () => {
                if (quill) return;
                const editorEl = document.getElementById('contentEditor');
                quill = new Quill(editorEl, {
                    theme: 'snow',
                    placeholder: 'متن محتوا را اینجا بنویسید...',
                    modules: {
                        toolbar: '#contentToolbar'
                    }
                });
                // راست‌چین کردن محتوای داخل ادیتور
                quill.format('direction', 'rtl');
                quill.format('align', 'right');
                const sync = () => {
                    const html = quill.root.innerHTML.trim();
                    hidden.value = html;
                    if (fullDescriptionHidden) {
                        fullDescriptionHidden.value = html;
                    }
                };
                quill.on('text-change', sync);
                sync();
            };

            if (menuSelect && submenuSelect) {
                filterSubmenuOptions(menuSelect.value, submenuSelect);
                menuSelect.addEventListener('change', function () {
                    filterSubmenuOptions(this.value, submenuSelect);
                });
            }

            $(document).on('change', '.content-edit-menu', function () {
                const contentId = $(this).data('content-id');
                const submenu = document.getElementById('submenupanel_id_' + contentId);
                if (!submenu) return;
                filterSubmenuOptions($(this).val(), submenu);
            });

            $(document).on('shown.bs.modal', '#editModal', function () {
                document.querySelectorAll('.content-edit-menu').forEach((menuItem) => {
                    const contentId = menuItem.getAttribute('data-content-id');
                    const submenu = document.getElementById('submenupanel_id_' + contentId);
                    if (submenu) {
                        filterSubmenuOptions(menuItem.value, submenu);
                    }
                });
            });

            const addModal = document.getElementById('addModal');
            addModal?.addEventListener('shown.bs.modal', () => {
                initQuill();
                setTimeout(() => quill && quill.focus(), 120);
            });

        });
    </script>
    <style>
        .quill-wrapper .ql-toolbar {
            direction: ltr;
        }

        .quill-wrapper .ql-editor {
            direction: rtl;
            text-align: right;
            min-height: 180px;
            font-family: IRANSans, sans-serif;
        }

        .quill-wrapper .ql-toolbar button {
            padding-inline: 6px;
        }
    </style>
@endsection

@extends('layouts.base')
@section('title', 'مدیریت منوی داشبورد')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/dataTables.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/jalalidatepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/quill.snow.css') }}"/>
    <script type="text/javascript" src="{{asset('assets/vendor/js/jalalidatepicker.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        jdp-container { z-index: 99999999 !important; }
        .steps-wrap {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }
        .add-step-indicator {
            border: 1px solid #d9dee8;
            border-radius: 14px;
            padding: 14px 12px;
            text-align: center;
            font-weight: 700;
            font-size: 15px;
            line-height: 1.8;
            background: #fff;
            color: #6b7280;
            transition: all .2s ease;
        }
        .add-step-indicator.active {
            border-color: #696cff;
            background: rgba(105, 108, 255, .10);
            color: #2f2f88;
            box-shadow: 0 6px 16px rgba(105, 108, 255, .16);
            transform: translateY(-1px);
        }
        .type-choice-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }
        .type-choice-card {
            border: 1px solid #e4e8f1;
            border-radius: 16px;
            padding: 18px 16px;
            background: linear-gradient(180deg, #ffffff 0%, #f8faff 100%);
            cursor: pointer;
            transition: all .2s ease;
        }
        .type-choice-card:hover {
            border-color: #c8cffd;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(105, 108, 255, .12);
        }
        .type-choice-card.active {
            border-color: #696cff;
            background: #696cff;
            box-shadow: 0 12px 24px rgba(105, 108, 255, .22);
        }
        .type-choice-title {
            font-weight: 800;
            font-size: 16px;
            margin-bottom: 6px;
            color: #2f2f88;
        }
        .type-choice-desc {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }
        .type-choice-card.active .type-choice-title,
        .type-choice-card.active .type-choice-desc {
            color: #fff;
        }
        .use-option-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .product-use-field {
            border: 1px solid #dfe3ee;
            border-radius: 12px;
            padding: 8px 10px;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #fff;
        }
        .product-use-label {
            font-size: 13px;
            color: #6b7280;
            white-space: nowrap;
            margin: 0;
        }
        .use-option {
            border: 1px solid #dfe3ee;
            border-radius: 10px;
            padding: 7px 12px;
            background: #fff;
            cursor: pointer;
            user-select: none;
            transition: all .2s ease;
            font-weight: 700;
            color: #4b5563;
            text-align: center;
            font-size: 13px;
            margin: 0;
        }
        .use-option:hover {
            border-color: #9ea9ff;
        }
        .use-option.active {
            background: #696cff;
            border-color: #696cff;
            color: #fff;
            box-shadow: 0 8px 16px rgba(105, 108, 255, .18);
        }
        @media (max-width: 767.98px) {
            .steps-wrap {
                grid-template-columns: 1fr;
            }
            .add-step-indicator {
                font-size: 14px;
                padding: 12px 10px;
            }
            .type-choice-grid {
                grid-template-columns: 1fr;
            }
            .use-option-grid {
                width: 100%;
            }
            .product-use-field {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        .quill-wrapper .ql-toolbar {
            direction: rtl;
        }
        .quill-wrapper .ql-editor {
            direction: rtl;
            text-align: right;
            line-height: 2;
            min-height: 220px;
            font-family: IRANSans, Vazirmatn, Tahoma, sans-serif;
        }
        .quill-wrapper .ql-picker-options {
            direction: rtl;
        }
        .quill-wrapper .ql-snow .ql-picker.ql-expanded .ql-picker-options {
            left: auto;
            right: 0;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{$thispage['list']}}</h5>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">{{$thispage['add']}}</a>
            </div>

            <div class="table-responsive">
                <style> table{margin: 0 auto;width: 100% !important;clear: both;border-collapse: collapse;table-layout: fixed;word-wrap:break-word;} .dt-layout-start{margin-right: 0 !important;} .dt-layout-end{margin-left: 0 !important;}</style>
                <table id="sample1" class="table table-striped table-bordered yajra-datatable">
                    <thead>
                    <tr class="table-light">
                        <th>سریال</th>
                        <th>نام محصول</th>
                        <th>قیمت محصول</th>
                        <th>نوع محصول</th>
                        <th>تاریخ شروع</th>
                        <th>وضعیت</th>
                        <th>تغییر</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


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

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">{{$thispage['add']}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <form id="addform" data-type="create" method="POST" class="mb-0" action="{{route(request()->segment(2).'.store') }}">
                        {{csrf_field()}}

                        <div class="steps-wrap mb-4">
                            <span class="add-step-indicator active" data-step="1">مرحله 1: نوع محصول</span>
                            <span class="add-step-indicator" data-step="2">مرحله 2: تکمیل فرم</span>
                            <span class="add-step-indicator" data-step="3">مرحله 3: پیش‌نمایش</span>
                        </div>

                        <div class="product-step" data-step="1">
                            <div class="row g-4">
                                <div class="col-12">
                                    <h6 class="mb-1">انتخاب نوع محصول</h6>
                                    <p class="text-muted mb-0">یکی از گزینه‌ها را انتخاب کنید تا فرم همان نوع نمایش داده شود.</p>
                                </div>
                                <div class="col-12">
                                    <div class="type-choice-grid">
                                        <div class="type-choice-card" data-type-choice="workshop">
                                            <div class="type-choice-title">کارگاه</div>
                                            <p class="type-choice-desc">مناسب ثبت دوره‌ها، مدرس، سوابق و زمان‌بندی برگزاری</p>
                                        </div>
                                        <div class="type-choice-card" data-type-choice="estelam">
                                            <div class="type-choice-title">استعلام</div>
                                            <p class="type-choice-desc">برای درخواست‌های استعلام با جزئیات و تاریخ انقضا</p>
                                        </div>
                                        <div class="type-choice-card" data-type-choice="contract">
                                            <div class="type-choice-title">قرارداد</div>
                                            <p class="type-choice-desc">برای تعریف محصولات قراردادی با اطلاعات کلیدی</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-none">
                                    <div class="form-floating form-floating-outline">
                                        <select name="product_type" id="create_product_type" class="form-control" required>
                                            <option value="">انتخاب کنید</option>
                                            <option value="workshop">کارگاه</option>
                                            <option value="estelam">استعلام</option>
                                            <option value="contract">قرارداد</option>
                                        </select>
                                        <label for="create_product_type">نوع محصول</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-step d-none" data-step="2">
                            <div class="row g-4">
                                <div class="col-12 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="text" class="form-control" id="title" name="title" placeholder="عنوان فارسی">
                                        <label for="title">عنوان فارسی</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control input-number" id="price" name="price" placeholder="قیمت محصول">
                                        <label for="price">قیمت محصول</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="status" id="status" class="form-control">
                                            <option value="0">لغو</option>
                                            <option value="1">غیر فعال</option>
                                            <option value="2">تکمیل ظرفیت</option>
                                            <option value="3">پایان یافته</option>
                                            <option value="4" selected>فعال</option>
                                        </select>
                                        <label for="status">وضعیت نمایش</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 d-none" data-type-set="workshop">
                                    <div class="product-use-field">
                                        <p class="product-use-label">شرایط محصول</p>
                                        <div class="use-option-grid">
                                            <label class="use-option" for="product_use_present">حضوری</label>
                                            <label class="use-option" for="product_use_online">آنلاین</label>
                                        </div>
                                        <input class="d-none product-use-input" type="checkbox" id="product_use_present" name="product_use[]" value="حضوری">
                                        <input class="d-none product-use-input" type="checkbox" id="product_use_online" name="product_use[]" value="آنلاین">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-none" data-type-set="workshop">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="product_time" name="product_time" placeholder="زمان اجرا">
                                        <label for="product_time">زمان اجرا</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-none" data-type-set="workshop">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" data-jdp id="start_date" autocomplete="off" name="start_date" placeholder="تاریخ شروع">
                                        <label for="start_date">تاریخ شروع</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-none" data-type-set="workshop">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" data-jdp id="end_date" autocomplete="off" name="end_date" placeholder="تاریخ پایان">
                                        <label for="end_date">تاریخ پایان</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-none" data-type-set="workshop">
                                    <div class="form-floating form-floating-outline">
                                        <select name="certificate" id="certificate" class="form-control">
                                            <option value="دارد">دارد</option>
                                            <option value="ندارد" selected>ندارد</option>
                                        </select>
                                        <label for="certificate">گواهی دوره</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-none" data-type-set="workshop">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control input-number" id="price_certificate" name="price_certificate" placeholder="هزینه گواهینامه">
                                        <label for="price_certificate">هزینه گواهینامه</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 d-none" data-type-set="workshop,estelam,contract">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="item1" name="item1" placeholder="آیتم 1">
                                        <label for="item1">آیتم 1</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-none" data-type-set="workshop,estelam,contract">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="item2" name="item2" placeholder="آیتم 2">
                                        <label for="item2">آیتم 2</label>
                                    </div>
                                </div>
                                <div class="col-12 d-none" data-type-set="workshop">
                                    <label class="form-label mb-2">سوابق مدرس</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="workshop_item3_input" placeholder="یک سابقه وارد کنید">
                                        <button type="button" class="btn btn-outline-primary" id="addWorkshopItem3Btn">افزودن</button>
                                    </div>
                                    <input type="hidden" id="item3_workshop_hidden" name="item3">
                                    <div id="workshopItem3List" class="d-flex flex-wrap gap-2"></div>
                                </div>
                                <div class="col-12 col-md-4 d-none" data-type-set="estelam">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="item3_estelam" name="item3" placeholder="آیتم 3">
                                        <label for="item3_estelam">آیتم 3</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 d-none" data-type-set="estelam,contract">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" data-jdp id="exp_date" autocomplete="off" name="exp_date" placeholder="تاریخ انقضا">
                                        <label for="exp_date">تاریخ انقضا</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <textarea name="description" id="description" class="form-control" cols="30" rows="30"></textarea>
                                        <label for="description">توضیحات کلی</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label mb-2">توضیحات طولانی</label>
                                    <div class="quill-wrapper border rounded p-2">
                                        <div id="productFullDescriptionToolbar" class="ql-toolbar ql-snow rounded mb-2">
                                            <span class="ql-formats">
                                                <select class="ql-header">
                                                    <option selected></option>
                                                    <option value="1"></option>
                                                    <option value="2"></option>
                                                </select>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
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
                                                <button class="ql-clean"></button>
                                            </span>
                                        </div>
                                        <div id="productFullDescriptionEditor" style="height: 220px"></div>
                                    </div>
                                    <input type="hidden" name="full_description" id="full_description">
                                </div>
                            </div>
                        </div>

                        <div class="product-step d-none" data-step="3">
                            <div class="alert alert-info mb-3">
                                اطلاعات زیر را بررسی کنید. در صورت تایید، روی «ذخیره اطلاعات» بزنید.
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody id="productPreviewBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">انصراف</button>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary d-none" id="addPrevStepBtn">مرحله قبل</button>
                                <button type="button" class="btn btn-primary" id="addNextStepBtn">مرحله بعد</button>
                                <button type="submit" class="btn btn-success d-none" id="addSubmitBtn">ذخیره اطلاعات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

            $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route(request()->segment(2).'.index')}}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'price', name: 'price'},
                    {data: 'product_type', name: 'product_type'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ],
                language: {
                    url: "{{asset('assets/vendor/js/fa.json')}}"
                }
            });

            const addModal = document.getElementById('addModal');
            const addForm = document.getElementById('addform');
            const typeSelect = document.getElementById('create_product_type');
            const nextBtn = document.getElementById('addNextStepBtn');
            const prevBtn = document.getElementById('addPrevStepBtn');
            const submitBtn = document.getElementById('addSubmitBtn');
            const previewBody = document.getElementById('productPreviewBody');
            const stepIndicators = document.querySelectorAll('.add-step-indicator');
            const stepPanels = document.querySelectorAll('.product-step');
            const typedFields = document.querySelectorAll('[data-type-set]');
            const typeChoiceCards = document.querySelectorAll('[data-type-choice]');
            let currentStep = 1;
            let fullDescriptionQuill = null;

            const typeLabels = {
                workshop: 'کارگاه',
                estelam: 'استعلام',
                contract: 'قرارداد'
            };

            const updateTypeFields = () => {
                const selectedType = typeSelect.value;
                typeChoiceCards.forEach((card) => {
                    card.classList.toggle('active', card.getAttribute('data-type-choice') === selectedType);
                });

                typedFields.forEach((container) => {
                    const allowedTypes = (container.dataset.typeSet || '')
                        .split(',')
                        .map((x) => x.trim())
                        .filter(Boolean);

                    const isVisible = selectedType && allowedTypes.includes(selectedType);
                    container.classList.toggle('d-none', !isVisible);

                    container.querySelectorAll('input, select, textarea').forEach((input) => {
                        input.disabled = !isVisible;
                    });
                });
            };

            const renderStep = () => {
                stepPanels.forEach((panel) => {
                    const step = parseInt(panel.dataset.step, 10);
                    panel.classList.toggle('d-none', step !== currentStep);
                });

                stepIndicators.forEach((item) => {
                    const step = parseInt(item.dataset.step, 10);
                    item.classList.toggle('active', step === currentStep);
                });

                prevBtn.classList.toggle('d-none', currentStep === 1);
                nextBtn.classList.toggle('d-none', currentStep === 3);
                submitBtn.classList.toggle('d-none', currentStep !== 3);
            };

            const getFieldValue = (name) => {
                if (name === 'item3') {
                    if (typeSelect.value === 'workshop') {
                        const workshopValue = document.getElementById('item3_workshop_hidden')?.value || '';
                        return workshopValue.trim() || '-';
                    }
                    const estelamValue = document.getElementById('item3_estelam')?.value || '';
                    return estelamValue.trim() || '-';
                }

                if (name === 'product_use') {
                    const uses = Array.from(document.querySelectorAll('input[name="product_use[]"]:checked')).map((x) => x.value);
                    return uses.length ? uses.join('، ') : '-';
                }

                const target = addForm.querySelector(`[name="${name}"]`);
                if (!target) return '-';

                if (target.tagName === 'SELECT') {
                    const selectedOption = target.options[target.selectedIndex];
                    return selectedOption && selectedOption.text ? selectedOption.text : '-';
                }

                return (target.value || '').trim() || '-';
            };

            const buildPreview = () => {
                const selectedType = typeSelect.value;
                const rows = [
                    ['نوع محصول', typeLabels[selectedType] || '-'],
                    ['عنوان فارسی', getFieldValue('title')],
                    ['قیمت محصول', getFieldValue('price')],
                    ['وضعیت نمایش', getFieldValue('status')],
                    ['توضیحات کلی', getFieldValue('description')],
                    ['توضیحات طولانی', getFieldValue('full_description')]
                ];

                if (selectedType === 'workshop') {
                    rows.push(['شرایط محصول', getFieldValue('product_use')]);
                    rows.push(['زمان اجرا', getFieldValue('product_time')]);
                    rows.push(['تاریخ شروع', getFieldValue('start_date')]);
                    rows.push(['تاریخ پایان', getFieldValue('end_date')]);
                    rows.push(['گواهی دوره', getFieldValue('certificate')]);
                    rows.push(['هزینه گواهینامه', getFieldValue('price_certificate')]);
                    rows.push(['نام مدرس', getFieldValue('item1')]);
                    rows.push(['مسیر تصویر مدرس', getFieldValue('item2')]);
                    rows.push(['سوابق مدرس', getFieldValue('item3')]);
                }

                if (selectedType === 'estelam') {
                    rows.push(['تاریخ انقضا', getFieldValue('exp_date')]);
                    rows.push(['آیتم 1', getFieldValue('item1')]);
                    rows.push(['آیتم 2', getFieldValue('item2')]);
                    rows.push(['آیتم 3', getFieldValue('item3')]);
                }

                if (selectedType === 'contract') {
                    rows.push(['تاریخ انقضا', getFieldValue('exp_date')]);
                    rows.push(['آیتم 1', getFieldValue('item1')]);
                    rows.push(['آیتم 2', getFieldValue('item2')]);
                }

                previewBody.innerHTML = rows.map(([label, value]) => `<tr><th style="width:220px">${label}</th><td>${value}</td></tr>`).join('');
            };

            const resetMultiStepForm = () => {
                addForm.reset();
                document.getElementById('status').value = '4';
                document.getElementById('full_description').value = '';
                if (fullDescriptionQuill) {
                    fullDescriptionQuill.root.innerHTML = '';
                }
                currentStep = 1;
                typeSelect.classList.remove('is-invalid');
                workshopItem3Items = [];
                renderWorkshopItem3List();
                updateTypeFields();
                renderStep();
            };

            const initFullDescriptionEditor = () => {
                if (fullDescriptionQuill) return;

                fullDescriptionQuill = new Quill('#productFullDescriptionEditor', {
                    theme: 'snow',
                    placeholder: 'توضیحات کامل محصول را وارد کنید...',
                    modules: {
                        toolbar: '#productFullDescriptionToolbar'
                    }
                });

                fullDescriptionQuill.root.setAttribute('dir', 'rtl');
                fullDescriptionQuill.format('direction', 'rtl');
                fullDescriptionQuill.format('align', 'right');

                const fullDescriptionHidden = document.getElementById('full_description');
                const sync = () => {
                    const html = fullDescriptionQuill.root.innerHTML.trim();
                    fullDescriptionHidden.value = html === '<p><br></p>' ? '' : html;
                };

                fullDescriptionQuill.on('text-change', sync);
                sync();
            };

            const item1Input = document.getElementById('item1');
            const item2Input = document.getElementById('item2');
            const item1Label = document.querySelector('label[for="item1"]');
            const item2Label = document.querySelector('label[for="item2"]');

            const updateWorkshopItemLabels = () => {
                const isWorkshop = typeSelect.value === 'workshop';

                if (item1Label) item1Label.textContent = isWorkshop ? 'نام مدرس' : 'آیتم 1';
                if (item2Label) item2Label.textContent = isWorkshop ? 'مسیر تصویر مدرس' : 'آیتم 2';
                if (item1Input) item1Input.placeholder = isWorkshop ? 'نام مدرس' : 'آیتم 1';
                if (item2Input) item2Input.placeholder = isWorkshop ? 'مسیر تصویر مدرس' : 'آیتم 2';
            };

            const workshopItem3Input = document.getElementById('workshop_item3_input');
            const addWorkshopItem3Btn = document.getElementById('addWorkshopItem3Btn');
            const workshopItem3List = document.getElementById('workshopItem3List');
            const workshopItem3Hidden = document.getElementById('item3_workshop_hidden');
            let workshopItem3Items = [];

            const syncWorkshopItem3Hidden = () => {
                if (workshopItem3Hidden) {
                    workshopItem3Hidden.value = workshopItem3Items.join(' | ');
                }
            };

            const renderWorkshopItem3List = () => {
                if (!workshopItem3List) return;

                workshopItem3List.innerHTML = workshopItem3Items.map((item, index) => `
                    <span class="badge bg-label-primary d-inline-flex align-items-center gap-1 py-2 px-2">
                        <span>${item}</span>
                        <button type="button" class="btn-close btn-close-sm remove-workshop-item3" data-index="${index}" aria-label="حذف"></button>
                    </span>
                `).join('');

                syncWorkshopItem3Hidden();
            };

            const addWorkshopItem3 = () => {
                const value = (workshopItem3Input?.value || '').trim();
                if (!value) return;

                workshopItem3Items.push(value);
                workshopItem3Input.value = '';
                renderWorkshopItem3List();
                workshopItem3Input.focus();
            };

            nextBtn.addEventListener('click', function () {
                if (currentStep === 1) {
                    if (!typeSelect.value) {
                        typeSelect.classList.add('is-invalid');
                        return;
                    }
                    typeSelect.classList.remove('is-invalid');
                    currentStep = 2;
                    renderStep();
                    return;
                }

                if (currentStep === 2) {
                    if (!addForm.checkValidity()) {
                        addForm.reportValidity();
                        return;
                    }
                    buildPreview();
                    currentStep = 3;
                    renderStep();
                }
            });

            prevBtn.addEventListener('click', function () {
                if (currentStep > 1) {
                    currentStep -= 1;
                    renderStep();
                }
            });

            typeSelect.addEventListener('change', function () {
                this.classList.remove('is-invalid');
                updateTypeFields();
                updateWorkshopItemLabels();
            });

            typeChoiceCards.forEach((card) => {
                card.addEventListener('click', function () {
                    const type = this.getAttribute('data-type-choice');
                    if (!type) return;
                    typeSelect.value = type;
                    typeSelect.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });

            document.querySelectorAll('.product-use-input').forEach((input) => {
                input.addEventListener('change', function () {
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    if (!label) return;
                    label.classList.toggle('active', this.checked);
                });
            });

            addWorkshopItem3Btn?.addEventListener('click', addWorkshopItem3);

            workshopItem3Input?.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addWorkshopItem3();
                }
            });

            document.addEventListener('click', function (e) {
                const removeBtn = e.target.closest('.remove-workshop-item3');
                if (!removeBtn) return;

                const index = parseInt(removeBtn.getAttribute('data-index'), 10);
                if (!Number.isNaN(index)) {
                    workshopItem3Items.splice(index, 1);
                    renderWorkshopItem3List();
                }
            });

            addModal.addEventListener('shown.bs.modal', function () {
                initFullDescriptionEditor();
                resetMultiStepForm();
                updateWorkshopItemLabels();
            });

            addModal.addEventListener('hidden.bs.modal', function () {
                resetMultiStepForm();
                updateWorkshopItemLabels();
            });
        });
    </script>
@endsection

    <form data-type="update" data-id="{{ $emploee->id }}"  class="row g-4 mb-4" method="POST" action="{{route(request()->segment(2).'.update' , $emploee->id) }}">
        @csrf
        @method('PATCH')
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input required type="text" class="form-control" id="fullname" name="fullname" value="{{$emploee->fullname}}" >
                <label for="title">نام و نام خانوادگی</label>
                <div class="invalid-feedback" id="fullnameFeedback">نام و نام خانوادگی اجباری می باشد.</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="side" name="side"  value="{{$emploee->side}}">
                <label for="side">سمت</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="phone" name="phone" value="{{$emploee->phone}}">
                <label for="phone">شماره موبایل</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="instagram" name="instagram" value="{{$emploee->instagram}}">
                <label for="instagram">آدرس پیج اینستاگرام</label>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-group mb-3">
                <input type="text" name="image" class="form-control" value="{{ $emploee->image }}" id="image_{{ $emploee->id }}" readonly placeholder="انتخاب فایل تصویر  {{ $emploee->id }}">
                <button class="btn btn-outline-secondary file-selector" type="button" data-record-id="{{ $emploee->id }}" data-input-id="image_{{ $emploee->id }}">
                    انتخاب فایل
                </button>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="status" id="status" class="form-control">
                    <option value="0" {{$emploee->status == '0' ? 'selected' : ''}}>لغو</option>
                    <option value="1" {{$emploee->status == '1' ? 'selected' : ''}}>غیر فعال</option>
                    <option value="2" {{$emploee->status == '2' ? 'selected' : ''}}>تکمیل ظرفیت</option>
                    <option value="3" {{$emploee->status == '3' ? 'selected' : ''}}>پایان یافته</option>
                    <option value="4" {{$emploee->status == '4' ? 'selected' : ''}}>فعال</option>
                </select>
                <label for="status">وضعیت نمایش</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="priority" name="priority" value="{{$emploee->priority}}">
                <label for="priority">اولویت نمایش</label>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="form-floating form-floating-outline">
                <textarea name="description" id="description" class="form-control" cols="30" rows="30" style="min-height: 500px">{{$emploee->description}}</textarea>
                <label for="class">معرفی</label>
            </div>
        </div>
        <div class="card mb-12">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">ویرایشگر متن</h5>
                </div>

                <div class="quill-wrapper">
                    {{-- Quill Toolbar --}}
                    <div id="snow-toolbar">
                <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                </span>
                        <span class="ql-formats">
                    <button class="ql-bold" type="button"></button>
                    <button class="ql-italic" type="button"></button>
                    <button class="ql-underline" type="button"></button>
                    <button class="ql-strike" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                </span>
                        <span class="ql-formats">
                    <button class="ql-script" value="sub" type="button"></button>
                    <button class="ql-script" value="super" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-header" value="1" type="button"></button>
                    <button class="ql-header" value="2" type="button"></button>
                    <button class="ql-blockquote" type="button"></button>
                    <button class="ql-code-block" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-list" value="ordered" type="button"></button>
                    <button class="ql-list" value="bullet" type="button"></button>
                    <button class="ql-indent" value="-1" type="button"></button>
                    <button class="ql-indent" value="+1" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-direction" value="rtl" type="button"></button>
                    <select class="ql-align"></select>
                </span>
                        <span class="ql-formats">
                    <button class="ql-link" type="button"></button>
                    <button class="ql-image" type="button"></button>
                    <button class="ql-video" type="button"></button>
                    <button class="ql-formula" type="button"></button>
                </span>
                        <span class="ql-formats">
                    <button class="ql-clean" type="button"></button>
                </span>
                    </div>

                    {{-- Quill Editor --}}
                    <div id="snow-editor">
                        <p>متن نمونه…</p>
                    </div>

                    {{-- Hidden input for submitting HTML (optional) --}}
                    <input type="hidden" name="content_html" id="content_html" value="">
                </div>

            </div>
        </div>
        <div class="text-center">
            <button type="submit" id="editsubmit_{{$emploee->id}}" class="btn btn-primary" >ذخیره اطلاعات</button>
        </div>
    </form>

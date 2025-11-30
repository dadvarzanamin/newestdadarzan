<form data-type="update" data-id="{{ $submenusite->id }}"  class="row g-4 mb-4" method="POST" action="{{ route('submenupanel.update', $submenusite->id) }}">
        {{csrf_field()}}
        <input type="hidden" name="menu_id" id="menu_id_{{$submenusite->id}}" value="{{$submenusite->id}}" />

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input required type="text" class="form-control" id="label_{{$submenusite->id}}" name="label"
                   placeholder="نام  زیرمنو داشبورد فارسی" value="{{ $submenusite->label }}">
            <label for="label">نام  زیرمنو داشبورد فارسی</label>
            <div class="invalid-feedback" id="labelFeedback">نام  زیرمنو داشبورد فارسی اجباری می باشد.</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input required type="text" class="form-control" id="title_{{$submenusite->id}}" name="title"
                   placeholder="نام  زیرمنو داشبورد" value="{{ $submenusite->title }}">
            <label for="title">نام  زیرمنو داشبورد</label>
            <div class="invalid-feedback" id="titleFeedback">نام  زیرمنو داشبورد اجباری می باشد.</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <select name="menupanel_id" id="menupanel_id_{{$submenusite->id}}" class="form-control select-lg select2">
                @foreach(DB::table('menus')->whereType('site')->whereSubmenu(1)->whereStatus(4)->get() as $menusite)
                    <option value="{{$menusite->id}}" {{$submenusite->menu_id == $menusite->id ? 'selected' : '' }}>{{$menusite->label}}</option>
                @endforeach
            </select>
            <label for="submenu">انتخاب زیر منو</label>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input required type="text" class="form-control" id="class_{{$menusite->id}}" name="class"
                   placeholder="کلاس داشبورد" value="{{ $menusite->class }}">
            <label for="class">کلاس داشبورد</label>
            <div class="invalid-feedback" id="classFeedback">کلاس داشبورد اجباری می باشد.</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input required type="text" class="form-control" id="controller_{{$menusite->id}}" name="controller"
                   placeholder="کنترلر داشبورد" value="{{ $menusite->controller }}">
            <label for="controller">کنترلر داشبورد</label>
            <div class="invalid-feedback" id="controllerFeedback">کنترلر داشبورد اجباری می باشد.</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <select name="status" id="status_{{$submenusite->id}}" class="form-control">
                <option value="4" {{$submenusite->status == 4 ? 'selected' : '' }}>نمایش</option>
                <option value="0" {{$submenusite->status == 0 ? 'selected' : '' }}>عدم نمایش</option>
            </select>
            <label for="status">نمایش/عدم نمایش</label>
        </div>
    </div>
        <div class="text-center">
            <button type="submit" id="editsubmit_{{$submenusite->id}}" class="btn btn-primary" >ذخیره اطلاعات</button>
        </div>
    </form>

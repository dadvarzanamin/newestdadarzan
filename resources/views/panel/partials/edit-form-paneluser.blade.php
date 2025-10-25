<form data-type="update" data-id="{{ $user->id }}"  class="row g-4 mb-4" method="POST" action="{{ route('paneluser.update', $user->id) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="user_id" id="user_id_{{$user->id}}" value="{{$user->id}}" />
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">نام و نام خانوادگی</label>
                <input type="text" name="name" id="name_{{$user->id}}" value="{{$user->name}}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">شماره موبایل</label>
                <input type="text" name="phone" id="phone_{{$user->id}}" value="{{$user->phone}}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">آدرس ایمیل</label>
                <input type="email" name="email" id="email_{{$user->id}}" value="{{$user->email}}" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">کد ملی</label>
                <input type="text" name="national_id" id="national_id_{{$user->id}}" value="{{$user->national_id}}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">نوع کاربری</label>
                <select name="typeuser_id" id="typeuser_id_{{$user->id}}" class="form-control select-lg select2">
                    <option value="" selected>انتخاب کنید</option>
                    @foreach($roles as $role)
                        <option value="{{$role->id}}" {{$user->role_id == $role->id ? 'selected' : ''}}>{{$role->title_fa}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاریخ تولد</label>
                <input type="text" name="birthday" data-jdp id="birthday_{{$user->id}}" autocomplete="off" value="{{$user->birthday}}" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">جنسیت</label>
                <select name="gender" id="gender_{{$user->id}}" class="form-control">
                    <option value="" selected>انتخاب کنید</option>
                    <option value="1" {{$user->gender == 1 ? 'selected' : ''}}>مرد</option>
                    <option value="2" {{$user->gender == 2 ? 'selected' : ''}}>زن</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">وضعیت</label>
                <select name="status" id="status_{{$user->id}}" class="form-control">
                    <option value="" selected>انتخاب کنید</option>
                    <option value="4" {{$user->status == 4 ? 'selected' : ''}}>فعال</option>
                    <option value="0" {{$user->status == 0 ? 'selected' : ''}}>غیر فعال</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">نوع دسترسی</label>
                <select name="level" id="level_{{$user->id}}" class="form-control">
                    <option value="" selected>انتخاب کنید</option>
                    <option value="admin" {{$user->level == 'admin' ? 'selected' : ''}}>کاربر داشبورد</option>
                    <option value="site"  {{$user->level == 'site' ? 'selected' : '' }}>کاربر سایت</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">رمز عبور</label>
                <input type="password" name="password" id="password_{{$user->id}}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" id="password_confirmation_{{$user->id}}" class="form-control">
            </div>
        </div>
        <div class="text-end">
            <button type="submit" id="editsubmit_{{$user->id}}" class="btn btn-primary" >ذخیره اطلاعات</button>
        </div>
    </form>

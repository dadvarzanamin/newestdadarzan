<form data-type="update" data-id="{{ $role->id }}"  class="row g-4 mb-4" method="POST" action="{{ route('roleuser.update', $role->id) }}">
        {{csrf_field()}}
        <input type="hidden" name="role_id" id="role_id_{{$role->id}}" value="{{$role->id}}" />
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">عنوان فارسی</label>
                <input type="text" name="title_fa" id="title_fa_{{$role->id}}" value="{{$role->title_fa}}" class="form-control" />
            </div>
            <div class="col-md-3">
                <label class="form-label">عنوان انگلیسی</label>
                <input type="text" name="title" id="title_{{$role->id}}" value="{{$role->title}}" class="form-control" />
            </div>
            <div class="col-md-3">
                <label for="permission_id_{{ $role->id }}" class="form-label">انتخاب دسترسی</label>
                <select name="permission_id[]" id="permission_id_{{ $role->id }}" multiple class="form-control select2-permission">
                    <option value="all">انتخاب همه</option>
                    @foreach(\App\Models\Permission::where('submenu_panel_id' , '<>' , null )->get() as $permission)
                        <option value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $permission->label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">فعال/غیر فعال</label>
                <select name="status" id="status_{{$role->id}}" class="form-control">
                    <option value="" selected>انتخاب کنید</option>
                    <option value="4" {{$role->status == 4 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{$role->status == 0 ? 'selected' : '' }}>غیر فعال</option>
                </select>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" id="editsubmit_{{$role->id}}" class="btn btn-primary" >ذخیره اطلاعات</button>
        </div>
    </form>
<script>
    $(document).ready(function () {
        $('.select2-permission').select2({
            placeholder: "دسترسی‌ها را انتخاب کنید",
            dir: "rtl",
            closeOnSelect: false,
            width: '100%'
        }).on('select2:select', function (e) {
            const $select = $(this);
            if (e.params.data.id === 'all') {
                const values = [];
                $select.find('option').each(function () {
                    if (this.value !== 'all') {
                        values.push(this.value);
                    }
                });
                $select.val(values).trigger('change');
            }
        }).on('select2:unselect', function (e) {
            if (e.params.data.id === 'all') {
                $(this).val(null).trigger('change');
            }
        });
    });
</script>

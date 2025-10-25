<form data-type="update" data-id="{{ $role->id }}"  class="row g-4 mb-4" method="POST" action="{{ route('roleuser.update', $role->id) }}">
        @csrf
        <input type="hidden" name="role_id" value="{{ $role->id }}">
        <input type="hidden" name="type" value="permission_update">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">مدیریت دسترسی‌ها: {{ $role->title_fa }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>صفحه</th>
                        <th>مشاهده</th>
                        <th>افزودن</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($role->permissions as $permission)
                        @php $pivot = $permission->pivot; @endphp
                        <tr>
                            <td>{{ $permission->label }}</td>
                            @foreach(['can_view', 'can_insert', 'can_edit', 'can_delete'] as $field)
                                <td>
                                    <input type="checkbox"
                                           name="permissions[{{ $permission->id }}][{{ $field }}]"
                                        {{ $pivot->$field ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="submit" id="editpermissionsubmit_{{$role->id}}" class="btn btn-primary">ذخیره اطلاعات</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </form>

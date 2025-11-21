    <div class="tab-pane fade show active justify-content-center" id="navs-user-card" role="tabpanel">

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">اطلاعات کاربر</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <form onsubmit="handleUpdate(this); return false;" data-type="update" class="row g-4 mb-4" data-table-target="#companyTable" action="{{ route('fullregister.update', Auth::user()->id) }}" method="POST" data-id="{{ Auth::user()->id }}">
                                @csrf
                                @method('PATCH')
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="text" id="user_name" name="name" class="form-control"
                                               placeholder="نام و نام خانوادگی" value="{{ old('name', Auth::user()->name ?? '') }}">
                                        <label for="user_name">نام و نام خانوادگی</label>
                                        <div class="invalid-feedback">لطفاً نام و نام خانوادگی را حداقل ۳ حرف وارد کنید.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input required inputmode="numeric" pattern="^\d{10}$" maxlength="10" minlength="10"
                                               type="text" id="user_national_id" name="national_id" class="form-control"
                                               placeholder="کد ملی" value="{{ old('national_id', Auth::user()->national_id ?? '') }}">
                                        <label for="user_national_id">کد ملی</label>
                                        <div class="invalid-feedback" id="nationalIdFeedback">کد ملی نامعتبر است. باید ۱۰ رقم و معتبر باشد.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="user_father_name" name="father_name" class="form-control"
                                               placeholder="نام پدر" value="{{ old('father_name', Auth::user()->father_name ?? '') }}">
                                        <label for="user_father_name">نام پدر</label>
                                        <div class="invalid-feedback">در صورت وارد کردن، حداقل ۳ حرف لازم است.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="email" id="user_email" name="email" class="form-control"
                                               placeholder="ایمیل" value="{{ old('email', Auth::user()->email ?? '') }}">
                                        <label for="user_email">ایمیل</label>
                                        <div class="invalid-feedback">لطفاً یک ایمیل معتبر وارد کنید.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="tel" id="user_phone" name="phone" class="form-control"
                                               placeholder="شماره موبایل" value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                               pattern="^(?:\+98|0)?9\d{9}$" inputmode="tel" maxlength="11">
                                        <label for="user_phone">شماره موبایل</label>
                                        <div class="invalid-feedback">شماره موبایل معتبر نیست. مثال: 0912xxxxxxx </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="gender" name="gender" class="form-select">
                                            <option value="">انتخاب</option>
                                            <option value="1" {{ (old('gender', Auth::user()->gender) == 1) ? 'selected' : '' }}>مرد</option>
                                            <option value="2" {{ (old('gender', Auth::user()->gender) == 2) ? 'selected' : '' }}>زن</option>
                                        </select>
                                        <label for="gender">جنسیت</label>
                                        <div class="invalid-feedback">جنسیت نامعتبر است.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="user_postalcode" name="postalcode" class="form-control"
                                               placeholder="کد پستی" value="{{ old('postalcode', Auth::user()->postalcode ?? '') }}"
                                               inputmode="numeric" pattern="^\d{10}$" maxlength="10">
                                        <label for="user_postalcode">کد پستی</label>
                                        <div class="invalid-feedback">کد پستی باید ۱۰ رقم باشد.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating form-floating-outline">
                                        <textarea id="user_address" name="address" class="form-control" rows="3" placeholder="آدرس">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                                        <label for="user_address">آدرس ثبتی</label>
                                        <div class="invalid-feedback">آدرس بیش از حد طولانی است یا نامعتبر است.</div>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary" id="editsubmit_{{Auth::user()->id}}">ذخیره</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table id="usersTable" class="table yajra-datatable yajra-datatable-users">
            <thead class="d-none">
            <tr>
                <th>user</th>
            </tr>
            </thead>
        </table>

    @push('scripts')
            <script>
                $(function() {
                    $('#usersTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{ route("userdata") }}',
                        columns: [
                            { data: 'card', name: 'card', orderable: false, searchable: false }
                        ],
                        paging: false,
                        searching: false,
                        ordering: false,
                        info: false,
                        language: { emptyTable: "کاربری یافت نشد" }
                    })
                });
            </script>

        @endpush

    </div>

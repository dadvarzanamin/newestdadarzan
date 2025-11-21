@php
    $avatar = $row->gender == 2
        ? asset('assets/img/avatars/8.png')
        : asset('assets/img/avatars/1.png');

    $statusClass = $row->status == 4 ? 'bg-label-success' : 'bg-label-danger';
    $statusText  = $row->status == 4 ? 'فعال' : 'غیرفعال';
@endphp

<div class="card border-0 shadow-sm mb-4" style="max-width:480px; margin:0 auto; border-radius:1.25rem;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex justify-content-center align-items-center shadow-sm"
                     style="width:56px; height:56px; background:#f2f3f6;">
                    <img src="{{ $avatar }}" class="w-px-40 h-auto rounded-circle" />
                </div>

                <div>
                    <div class="fw-bold mb-1" style="font-size:1.2rem;">
                        {{ $row->name }}
                    </div>

                    <div class="small text-secondary" dir="ltr" style="font-size:0.95rem;">
                        {{ $row->userlevel }}
                    </div>
                </div>
            </div>

            <button class="btn btn-primary edit-user"
                    data-id="{{ $row->id }}"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal">
                <span class="d-none d-md-inline">ویرایش</span>
            </button>
        </div>

        <dl class="row g-3" style="font-size:0.95rem;">
            <div class="col-12 d-flex">
                <dt class="col-5 text-start text-muted">کد ملی:</dt>
                <dd class="col-7 text-dark mb-0">{{ $row->national_id }}</dd>
            </div>

            <div class="col-12 d-flex border-top pt-3">
                <dt class="col-5 text-start text-muted">موبایل:</dt>
                <dd class="col-7 text-dark mb-0">{{ $row->phone }}</dd>
            </div>

            <div class="col-12 d-flex border-top pt-3">
                <dt class="col-5 text-start text-muted">ایمیل:</dt>
                <dd class="col-7 text-dark mb-0">{{ $row->email }}</dd>
            </div>

            <div class="col-12 d-flex border-top pt-3">
                <dt class="col-5 text-start text-muted">وضعیت:</dt>
                <dd class="col-7 text-dark mb-0">
                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                </dd>
            </div>

            <div class="col-12 d-flex border-top pt-3">
                <dt class="col-5 text-start text-muted">نقش:</dt>
                <dd class="col-7 text-dark mb-0">{{ $row->role_name }}</dd>
            </div>

            <div class="col-12 d-flex border-top pt-3">
                <dt class="col-5 text-start text-muted">آدرس:</dt>
                <dd class="col-7 text-dark mb-0" style="max-width:200px; word-wrap:break-word; white-space:normal;">
                    {{ $row->address }}
                </dd>
            </div>
        </dl>
    </div>
</div>

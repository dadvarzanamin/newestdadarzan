<form id="editform" data-type="edit" method="POST" class="row g-4 mb-4"
      action="{{ route('course.update', $course->id) }}">
    @csrf
    @method('PUT')

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input required type="text" class="form-control" name="title" value="{{ $course->title }}" placeholder="عنوان دوره">
            <label>عنوان دوره</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" name="en_title" value="{{ $course->en_title }}" placeholder="عنوان انگلیسی">
            <label>عنوان انگلیسی</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" name="instructor" value="{{ $course->instructor }}" placeholder="مدرس">
            <label>مدرس</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input type="text" class="form-control input-number" name="price" value="{{ $course->price }}" placeholder="هزینه دوره">
            <label>هزینه دوره</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            @php($uses = is_array($course->course_use) ? $course->course_use : [])
            <select name="course_use[]" multiple class="form-control">
                <option value="حضوری" @selected(in_array('حضوری', $uses))>حضوری</option>
                <option value="آنلاین" @selected(in_array('آنلاین', $uses))>آنلاین</option>
            </select>
            <label>شرایط دوره</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <select name="certificate" class="form-control">
                <option value="">انتخاب کنید</option>
                <option value="دارد" @selected($course->certificate === 'دارد')>دارد</option>
                <option value="ندارد" @selected($course->certificate === 'ندارد')>ندارد</option>
            </select>
            <label>گواهی دوره</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" name="start_date" value="{{ $course->start_date }}" autocomplete="off">
            <label>تاریخ شروع</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" name="end_date" value="{{ $course->end_date }}" autocomplete="off">
            <label>تاریخ پایان</label>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-floating form-floating-outline">
            <select name="status" class="form-control">
                <option value="0" @selected($course->status==0)>لغو</option>
                <option value="1" @selected($course->status==1)>غیر فعال</option>
                <option value="2" @selected($course->status==2)>تکمیل ظرفیت</option>
                <option value="3" @selected($course->status==3)>پایان یافته</option>
                <option value="4" @selected($course->status==4)>فعال</option>
            </select>
            <label>وضعیت نمایش</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-floating form-floating-outline">
            <textarea name="description" class="form-control">{{ $course->description }}</textarea>
            <label>توضیحات کلی</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-floating form-floating-outline">
            <textarea name="full_description" class="form-control">{{ $course->full_description }}</textarea>
            <label>توضیحات طولانی</label>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
    </div>
</form>

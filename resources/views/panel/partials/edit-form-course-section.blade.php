<form data-type="update" method="POST" action="{{ route('course-section.update', $section->id) }}" class="row g-4">
    @csrf
    @method('PATCH')

    <input type="hidden" name="course_id" value="{{ $section->course_id }}"/>

    <div class="col-12 col-md-6">
        <div class="form-floating form-floating-outline">
            <input required type="text" class="form-control" id="title" name="title"
                   value="{{ $section->title }}" placeholder="عنوان سرفصل">
            <label for="title">عنوان سرفصل</label>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="priority" name="priority"
                   value="{{ $section->priority }}" placeholder="اولویت" min="0">
            <label for="priority">اولویت</label>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-floating form-floating-outline">
            <select required name="status" id="status" class="form-control">
                <option value="4" @selected((int)$section->status === 4)>فعال</option>
                <option value="1" @selected((int)$section->status === 1)>غیرفعال</option>
                <option value="0" @selected((int)$section->status === 0)>لغو</option>
                <option value="2" @selected((int)$section->status === 2)>تکمیل ظرفیت</option>
                <option value="3" @selected((int)$section->status === 3)>پایان یافته</option>
            </select>
            <label for="status">وضعیت</label>
        </div>
    </div>

    <div class="col-12">
        <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="description" name="description" style="height: 130px"
                      placeholder="توضیح کوتاه">{{ $section->description }}</textarea>
            <label for="description">توضیح کوتاه</label>
        </div>
    </div>

    <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
    </div>
</form>

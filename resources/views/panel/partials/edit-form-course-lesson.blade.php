<form data-type="update" method="POST" action="{{ route('course-lesson.update', $lesson->id) }}" class="row g-4">
    @csrf
    @method('PATCH')

    <input type="hidden" name="course_section_id" value="{{ $lesson->course_section_id }}"/>

    <div class="col-12 col-md-6">
        <div class="form-floating form-floating-outline">
            <input required type="text" class="form-control" id="title" name="title"
                   value="{{ $lesson->title }}" placeholder="عنوان درس">
            <label for="title">عنوان درس</label>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-floating form-floating-outline">
            <select required class="form-control" id="lesson_type" name="lesson_type">
                <option value="video" @selected($lesson->lesson_type === 'video')>ویدئو</option>
                <option value="document" @selected($lesson->lesson_type === 'document')>جزوه</option>
                <option value="mixed" @selected($lesson->lesson_type === 'mixed')>ترکیبی</option>
            </select>
            <label for="lesson_type">نوع محتوا</label>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="priority" name="priority" min="0"
                   value="{{ $lesson->priority }}" placeholder="اولویت">
            <label for="priority">اولویت</label>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" min="0"
                   value="{{ $lesson->duration_minutes }}" placeholder="مدت (دقیقه)">
            <label for="duration_minutes">مدت (دقیقه)</label>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-floating form-floating-outline">
            <select required name="status" id="status" class="form-control">
                <option value="4" @selected((int)$lesson->status === 4)>فعال</option>
                <option value="1" @selected((int)$lesson->status === 1)>غیرفعال</option>
                <option value="0" @selected((int)$lesson->status === 0)>لغو</option>
            </select>
            <label for="status">وضعیت</label>
        </div>
    </div>

    <div class="col-12 col-md-6 lesson-video">
        <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="video_url" name="video_url"
                   value="{{ $lesson->video_url }}" placeholder="آدرس ویدئو">
            <label for="video_url">آدرس ویدئو</label>
        </div>
    </div>

    <div class="col-12 col-md-6 lesson-doc">
        <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="document_path" name="document_path"
                   value="{{ $lesson->document_path }}" placeholder="جزوه">
            <label for="document_path">جزوه</label>
        </div>
    </div>

    <div class="col-12">
        <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="content" name="content" style="height: 130px"
                      placeholder="توضیحات">{{ $lesson->content }}</textarea>
            <label for="content">توضیحات</label>
        </div>
    </div>

    <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
    </div>
</form>

<script>
    (function () {
        function syncLessonFields() {
            const v = ($('#lesson_type').val() || 'video').toString();
            const showVideo = (v === 'video' || v === 'mixed');
            const showDoc   = (v === 'document' || v === 'mixed');
            $('.lesson-video').toggle(showVideo);
            $('.lesson-doc').toggle(showDoc);
        }
        syncLessonFields();
        $(document).off('change.editLessonType').on('change.editLessonType', '#lesson_type', syncLessonFields);
    })();
</script>

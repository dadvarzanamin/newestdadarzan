    <form data-type="update" data-id="{{ $product->id }}"  class="row g-4 mb-4" method="POST" action="{{route(request()->segment(2).'.update' , $product->id) }}">
        @csrf
        @method('PATCH')
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input required type="text" class="form-control" id="title" name="title" value="{{$product->title}}" >
                <label for="title">عنوان فارسی</label>
                <div class="invalid-feedback" id="titleFeedback">عنوان فارسی اجباری می باشد.</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="en_title" name="en_title"  value="{{$product->en_title}}">
                <label for="en_title">عنوان انگلیسی</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="sub_title" name="sub_title" value="{{$product->sub_title}}">
                <label for="sub_title">زیر عنوان</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="item1" name="item1" value="{{$product->item1}}">
                <label for="item1">ایتم مربوط به خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="item2" name="item2" value="{{$product->item2}}">
                <label for="item2">ایتم مربوط به خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="item3" name="item3" value="{{$product->item3}}">
                <label for="item3">ایتم مربوط به خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="item4" name="item4" value="{{$product->item4}}">
                <label for="item4">ایتم مربوط به خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="item5" name="item5" value="{{$product->item5}}">
                <label for="item5">ایتم مربوط به خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control input-number" id="price" name="price" value="{{$product->price}}">
                <label for="price">هزینه خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="product_type" id="product_type" class="form-control">
                    <option value="" >انتخاب کنید</option>
                    <option value="workshop" {{$product->product_type == 'workshop' ? 'selected' : ''}}>کارگاه</option>
                    <option value="estelam"  {{$product->product_type == 'estelam'  ? 'selected' : ''}}>استعلام</option>
                    <option value="contract" {{$product->product_type == 'contract' ? 'selected' : ''}}>قرارداد</option>
                </select>
                <label for="product_type">نوع خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="product_use" id="product_use" multiple class="form-control">
                    <option value="" >انتخاب کنید</option>
                    <option value="حضوری"  {{$product->product_use == 'حضوری' ? 'selected' : ''}}>حضوری</option>
                    <option value="آنلاین"  {{$product->product_use == 'آنلاین' ? 'selected' : ''}} >آنلاین</option>
                </select>
                <label for="product_type">شرایط خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="product_time" name="product_time" value="{{$product->product_time}}" >
                <label for="price">زمان اجرا</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" data-jdp id="start_date" autocomplete="off" name="start_date"  value="{{$product->start_date}}" >
                <label for="price">تاریخ شروع</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" data-jdp id="end_date" autocomplete="off" name="end_date"  value="{{$product->end_date}}" >
                <label for="price">تاریخ پایان</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" data-jdp id="exp_date" autocomplete="off" name="exp_date"  value="{{$product->exp_date}}" >
                <label for="price">تاریخ انقضا</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="certificate" id="certificate" class="form-control">
                    <option value="" >انتخاب کنید</option>
                    <option value="دارد"  {{$product->certificate == 'دارد' ? 'selected' : ''}}>دارد</option>
                    <option value="ندارد" {{$product->certificate == 'ندارد' ? 'selected' : ''}}>ندارد</option>
                </select>
                <label for="certificate">گواهی دوره</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control input-number" id="price_certificate" name="price_certificate" value="{{$product->price_certificate}}" >
                <label for="class">هزینه گواهینامه</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="status" id="status" class="form-control">
                    <option value="0" {{$product->status == '0' ? 'selected' : ''}}>لغو</option>
                    <option value="1" {{$product->status == '1' ? 'selected' : ''}}>غیر فعال</option>
                    <option value="2" {{$product->status == '2' ? 'selected' : ''}}>تکمیل ظرفیت</option>
                    <option value="3" {{$product->status == '3' ? 'selected' : ''}}>پایان یافته</option>
                    <option value="4" {{$product->status == '4' ? 'selected' : ''}}>فعال</option>
                </select>
                <label for="status">وضعیت نمایش</label>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <textarea name="description" id="description" class="form-control" cols="30" rows="30">{{$product->description}}</textarea>
                <label for="class">توضیحات کلی</label>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <textarea name="full_description" id="full_description" class="form-control" cols="30" rows="30">{{$product->full_description}}</textarea>
                <label for="class">توضیحات طولانی</label>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" id="editsubmit_{{$product->id}}" class="btn btn-primary" >ذخیره اطلاعات</button>
        </div>
    </form>

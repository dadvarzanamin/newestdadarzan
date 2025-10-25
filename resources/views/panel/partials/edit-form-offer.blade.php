    <form data-type="update" data-id="{{ $offer->id }}"  class="row g-4 mb-4" method="POST" action="{{route(request()->segment(2).'.update' , $offer->id) }}">
        @csrf
        @method('PATCH')
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="product_id" id="product_id" class="form-control">
                    <option value="" >انتخاب کنید</option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}" {{$offer->product_id == $product->id ? 'selected' : ''}}>{{$product->title}}</option>
                    @endforeach
                </select>
                <label for="status">انتخاب خدمات</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="user_offer" id="user_offer" class="form-control">
                    <option value="" >انتخاب همه</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}" {{$offer->user_offer == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                    @endforeach
                </select>
                <label for="user_offer">کاربر خاص</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input  type="text" class="form-control" id="percentage" name="percentage" value="{{$offer->percentage}}" >
                <label for="percentage">درصد تخفیف</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input  type="text" class="form-control" id="discount" name="discount" value="{{$offer->discount}}">
                <label for="discount">مبلغ تخفیف</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <select name="status" id="status" class="form-control">
                    <option value="" >انتخاب کنید</option>
                    <option value="4" {{$offer->status == '4' ? 'selected' : ''}}>فعال</option>
                    <option value="1" {{$offer->status == '1' ? 'selected' : ''}}>غیر فعال</option>
                </select>
                <label for="submenu">وضعیت کد تخفیف</label>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">ذخیره اطلاعات</button>
        </div>
    </form>

<footer class="footer-area section-two-bg">
    <div class="footer-widget">
        <div class="container">
            <div class="row row-gap-5 justify-content-center">
                <div class="col-lg-4 col-md-8">
                    <div class="footer-widget__item text-center text-lg-end">
                        <a href="{{ route('/') }}" class="d-block">
                            <img src="{{ asset('site/assets/images/logo/darklogodadvarzan.png') }}" style="max-width: 60px"
                                 alt="logo">
                        </a>
                        <br>
                        <p>موسسه حقوقی دادورزان امین</p>
                        <br>
                        <p>
                            ما اینجا هستیم تا دسترسی همه افراد به خدمات حقوقی تخصصی، با کیفیت و مقرون‌ به‌ صرفه را آسان
                            کنیم. ما به‌ عنوان ارائه‌ دهنده آنلاین راهکارهای حقوقی تخصصی به شرکت‌ها و کسب‌ و کارهای
                            ایران فعالیت می‌کنیم و تا امروز به بیش از 500 شرکت کوچک، متوسط و بزرگ ایرانی کمک کرده‌ایم تا
                            راه بهتری برای رفع نیازهای قانونی خود بیابند.
                        </p>
                        <div class="footer-email">
                            <a href="#"><span class="__cf_email__">[email&#160;protected]</span></a>
                        </div>
                        <div class="footer-phone">
                            <h4><a href="tel:09124917054">09124917054</a></h4>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.whatsapp.com/" target="_blank"><i
                                        class="fab fa-whatsapp"></i></a></li>
                            <li><a href="https://www.telegram.com/?lang=en" target="_blank"><i
                                        class="fa-brands fa-telegram"></i></a></li>
                            <li><a href="https://www.instagram.com/" target="_blank"><i
                                        class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="footer-widget__content ps-xl-5">
                        <div class="footer-widget__item">
                            <h4>خدمات موکلین</h4>
                            {{--                            <ul class="useful-list">--}}
                            {{--                                @if($servicelawyers != null)--}}
                            {{--                                    @foreach($servicelawyers as $servicelawyer)--}}
                            {{--                                        <li>--}}
                            {{--                                            <a href="{{url('خدمات/'.$servicelawyer->slug)}}">{{$servicelawyer->title}}</a>--}}
                            {{--                                        </li>--}}
                            {{--                                    @endforeach--}}
                            {{--                                @endif--}}

                            {{--                            </ul>--}}
                            <ul class="useful-list">
                                <li><a href="#">انواع خدمات قرادادی</a></li>
                                <li><a href="#">انواع خدمات کیفری</a></li>
                                <li><a href="#">انواع خدمات حقوقی</a></li>
                                <li><a href="#">انواع خدمات شرکت ها</a></li>
                                <li><a href="#">انواع خدمات مالیاتی</a></li>
                                <li><a href="#">انواع خدمات ملکی</a></li>
                                <li><a href="#">انواع خدمات بیمه ای</a></li>
                            </ul>
                        </div>

                        <div class="footer-widget__item">
                            <h4>خدمات وکلا</h4>
                            <ul class="useful-list">
                                <li><a href="#">انواع خدمات قرادادی</a></li>
                                <li><a href="#">انواع خدمات کیفری</a></li>
                                <li><a href="#">انواع خدمات حقوقی</a></li>
                                <li><a href="#">انواع خدمات شرکت ها</a></li>
                                <li><a href="#">انواع خدمات مالیاتی</a></li>
                                <li><a href="#">انواع خدمات ملکی</a></li>
                                <li><a href="#">انواع خدمات بیمه ای</a></li>
                            </ul>
                        </div>

                        <div class="footer-widget__item">
                            <h4>بروز بمانید</h4>
                            <p>به خبرنامه ما بپیوندید ...</p>
                            <div class="footer-widget__form">
                                <form action="#" method="post">
                                    @csrf
                                    <input type="email" name="email" placeholder="ایمیل خود را وارد کنید">
                                    <button type="submit" class="btn btn--base">ما را دنبال کنید</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="copy-right">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copy-right__content">
                        <p class="copy-right__text">
                            تمامی حقوق محفوظ است. طراحی شده توسط <a href="{{ route('/') }}">تیم توسعه دادروزان امین</a>
                        </p>
                        <ul class="nav gap-4 row-gap-2">
                            <li><a href="{{ url('/') }}">پشتیبانی</a></li>
                            <li><a href="{{ url('تیم-ما/حریم-خصوصی') }}">حریم خصوصی</a></li>
                            <li><a href="{{ url('تیم-ما/شرایط-و-ضوابط') }}">شرایط خدمات</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

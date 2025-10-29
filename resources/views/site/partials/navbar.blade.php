<nav class="navbar navbar-expand-lg navbar-main">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('/') }}">
            <img src="{{ asset('site/assets/images/logo/darklogodadvarzan.png') }}" alt="logo" class="logo-img">
        </a>
        <div class="right-nav">
            <a href="#" class="card___btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M16.7605 21.24C17.089 21.24 17.3552 20.9774 17.3552 20.6533C17.3552 20.3293 17.089 20.0667 16.7605 20.0667C16.432 20.0667 16.1658 20.3293 16.1658 20.6533C16.1658 20.9774 16.432 21.24 16.7605 21.24ZM16.7605 23C18.0743 23 19.1394 21.9493 19.1394 20.6533C19.1394 19.3574 18.0743 18.3067 16.7605 18.3067C15.4467 18.3067 14.3816 19.3574 14.3816 20.6533C14.3816 21.9493 15.4467 23 16.7605 23Z"
                          fill="black"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.6237 21.24C9.95217 21.24 10.2184 20.9774 10.2184 20.6533C10.2184 20.3293 9.95217 20.0667 9.6237 20.0667C9.29523 20.0667 9.02896 20.3293 9.02896 20.6533C9.02896 20.9774 9.29523 21.24 9.6237 21.24ZM9.6237 23C10.9375 23 12.0026 21.9493 12.0026 20.6533C12.0026 19.3574 10.9375 18.3067 9.6237 18.3067C8.30987 18.3067 7.24477 19.3574 7.24477 20.6533C7.24477 21.9493 8.30987 23 9.6237 23Z"
                          fill="black"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M1.14992 1.39195C1.42322 0.987572 1.9771 0.8783 2.38704 1.14789L3.77635 2.06152C4.22008 2.35331 4.53332 2.80196 4.65149 3.31492L7.09912 13.9384C7.25297 14.6061 7.85478 15.08 8.54902 15.08H17.8352C18.5295 15.08 19.1313 14.6061 19.2851 13.9384L21.1775 5.72513C21.3889 4.80735 20.6817 3.9334 19.7276 3.9334H10.5158C10.0231 3.9334 9.6237 3.53942 9.6237 3.05342C9.6237 2.56741 10.0231 2.17342 10.5158 2.17342H19.7276C21.8267 2.17342 23.3825 4.09602 22.9173 6.11514L21.025 14.3284C20.6864 15.7975 19.3625 16.84 17.8352 16.84H8.54902C7.02174 16.84 5.69775 15.7975 5.35929 14.3284L2.91166 3.70495C2.89478 3.6317 2.85003 3.5676 2.78664 3.52591L1.39735 2.61229C0.987401 2.3427 0.876626 1.79634 1.14992 1.39195Z"
                          fill="black"></path>
                </svg>                <div class="card-number">3</div>
            </a>
            @guest
                <a href="{{ route('login') }}" class="btn btn--border">ورود</a>
                <a href="{{ route('register') }}" class="btn btn--base">ثبت نام</a>
            @else
                <a href="{{ route('profile') }}" class="btn btn--border">پروفایل</a>
            @endguest

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" ...> ... </svg>
            </button>
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                    <img src="{{ asset('site/assets/images/logo/logo.svg') }}" alt="logo" class="logo-img">
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="d-flex d-lg-none gap-4 pt-3 justify-content-center">
                <a href="{{ route('login') }}" class="btn btn--border">ورود</a>
                <a href="{{ route('register') }}" class="btn btn--base">ثبت نام</a>
            </div>
            <div class="offcanvas-body align-items-center">
                <ul class="navbar-nav justify-content-center flex-grow-1">
                    @foreach($menus as $menu)
                        @if($menu->submenu == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">{{$menu->title}}</a>
                                <ul class="dropdown-menu fade-down">
                                    @foreach($submenus as $submenu)
                                        @if($submenu->menu_id == $menu->id)
                                            <li><a class="dropdown-item" href="{{ url($menu->slug.'/'.$submenu->slug) }}">{{$submenu->title}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @elseif($menu->submenu == 0)
                            <li class="nav-item"><a class="nav-link" href="{{ url($menu->slug) }}"><span>{{$menu->title}}</span></a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</nav>

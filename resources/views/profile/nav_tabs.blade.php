<ul class="nav nav-tabs nav-fill" role="tablist">
    <li class="nav-item">
        <button type="button" class="nav-link d-flex flex-column gap-1 active" role="tab"
                data-bs-toggle="tab" data-bs-target="#navs-user-card" aria-controls="navs-user-card"
                aria-selected="true">
            <i class="tf-icons mdi mdi-account-outline mdi-20px me-1"></i>
            اطلاعات کاربر
        </button>
    </li>
    @if(Auth::user()->level == 'site')
        <li class="nav-item">
            <button type="button" class="nav-link d-flex flex-column gap-1" role="tab"
                    data-bs-toggle="tab" data-bs-target="#navs-workshops-card"
                    aria-controls="navs-workshop-card" aria-selected="false">
                <i class="tf-icons mdi mdi-domain mdi-20px me-1"></i>
                اطلاعات کارگاه ها
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link d-flex flex-column gap-1" role="tab"
                    data-bs-toggle="tab" data-bs-target="#navs-orders-card"
                    aria-controls="navs-order-card" aria-selected="false">
                <i class="tf-icons mdi mdi-domain mdi-20px me-1"></i>
                اطلاعات سفارشات
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link d-flex flex-column gap-1" role="tab"
                    data-bs-toggle="tab" data-bs-target="#navs-wallets-card"
                    aria-controls="navs-wallet-card" aria-selected="false">
                <i class="tf-icons mdi mdi-clipboard-flow mdi-20px me-1"></i>
                اطلاعات کیف پول
            </button>
        </li>

    @elseif(Auth::user()->level == 'admin')
        <li class="nav-item">
            <button type="button" class="nav-link d-flex flex-column gap-1" role="tab"
                    data-bs-toggle="tab" data-bs-target="#navs-investor-projects-card"
                    aria-controls="navs-investor-projects-card" aria-selected="false">
                <i class="tf-icons mdi mdi-lightbulb-outline mdi-20px me-1"></i>
                کاربران
            </button>
        </li>
    @endif
</ul>

<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
               
            </li>
            <li>
                <a href="{{ route('admin.loan-types.index') }}">
                    <iconify-icon icon="ic:outline-account-balance" class="menu-icon"></iconify-icon>
                    <span>Loan Types</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.loans.index') }}">
                    <iconify-icon icon="ph:credit-card-bold" class="menu-icon"></iconify-icon>
                    <span>Loans</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.repayments.index') }}">
                    <iconify-icon icon="ph:clipboard-text" class="menu-icon"></iconify-icon>
                    <span>Repayments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payments.index') }}">
                    <iconify-icon icon="ph:currency-dollar" class="menu-icon"></iconify-icon>
                    <span>Payments</span>
                </a>
            </li>            
            
            <li>
                <a href="{{ route('admin.users.index') }}">
                    <iconify-icon icon="ic:outline-account-circle" class="menu-icon"></iconify-icon>
                    <span>Users</span>
                </a>
            </li>
            
            
        </ul>
    </div>
</aside>
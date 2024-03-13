<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo mb-4">
        <a href="javascript:void(0);" class="app-brand-link">
            <img src="{{asset('assets/logo/golden_woods_logo.png')}}" alt="Golden woods logo" style="height:50px;">
            <span style="margin-left:20px;font-size:20px;color:#333333;line-height:23px;">Golden <br> Woods</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="{{Request::segment(2) == 'dashboard' ? 'menu-item active' : 'menu-item'}}">
            <a href="{{route('admin.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="{{Request::segment(2) == 'blog' ? 'menu-item active' : 'menu-item'}}">
            <a href="{{route('admin.blog')}}" class="menu-link">
                <div data-i18n="Without menu">Blog</div>
            </a>
        </li>
    </ul>
</aside>

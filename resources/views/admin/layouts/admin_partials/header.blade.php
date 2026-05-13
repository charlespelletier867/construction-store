<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="mobile-toggle-icon d-xl-none">
            <i class="bi bi-list"></i>
        </div>
        <div class="top-navbar d-none d-xl-block">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}" data-i18n="menu.dashboard">{{ __('admin.menu.dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.pos.index') }}" data-i18n="menu.pos">{{ __('admin.menu.pos') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.sale_invoices.index') }}" data-i18n="menu.sales">{{ __('admin.menu.sales') }}</a>
                </li>
                <li class="nav-item d-none d-xxl-block">
                    <a class="nav-link" href="{{ route('admin.purchase_invoices.index') }}" data-i18n="menu.purchases">{{ __('admin.menu.purchases') }}</a>
                </li>
                <li class="nav-item d-none d-xxl-block">
                    <a class="nav-link" href="{{ route('admin.products.index') }}" data-i18n="menu.products">{{ __('admin.menu.products') }}</a>
                </li>
            </ul>
        </div>

        <div class="top-navbar-right ms-auto">
            <ul class="navbar-nav align-items-center">
                {{-- Branch switcher --}}
                @if(auth()->check() && session('current_branch_id'))
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-shop me-1"></i>
                        <span class="d-none d-md-inline">{{ session('current_branch_name', __('admin.menu.branch')) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header" data-i18n="header.switch_branch">{{ __('admin.header.switch_branch') }}</h6></li>
                        @foreach((auth()->user()->branches ?? collect()) as $b)
                            <li>
                                <form method="POST" action="{{ route('admin.branch.switch') }}" class="d-block">
                                    @csrf
                                    <input type="hidden" name="branch_id" value="{{ $b->id }}">
                                    <button type="submit" class="dropdown-item @if(session('current_branch_id') == $b->id) active @endif">
                                        <i class="bi bi-geo-alt me-2"></i>{{ $b->name }}
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endif

                {{-- Language switcher --}}
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" id="languageDropdown">
                        <i class="bi bi-translate me-1"></i>
                        <span class="d-none d-md-inline lang-label">{{ app()->getLocale() === 'km' ? 'ខ្មែរ' : 'English' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item lang-switch @if(app()->getLocale() === 'en') active @endif" href="#" data-locale="en">English</a></li>
                        <li><a class="dropdown-item lang-switch @if(app()->getLocale() === 'km') active @endif" href="#" data-locale="km">ខ្មែរ</a></li>
                    </ul>
                </li>

                {{-- User menu --}}
                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img src="{{ asset('assets/backend/assets/images/avatars/avatar-1.png') }}" class="user-img" alt="">
                            <div class="user-name d-none d-sm-block">{{ auth()->user()->name ?? 'Guest' }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/backend/assets/images/avatars/avatar-1.png') }}" alt="" class="rounded-circle" width="60" height="60">
                                    <div class="ms-3">
                                        <h6 class="mb-0 dropdown-user-name">{{ auth()->user()->name ?? '' }}</h6>
                                        <small class="mb-0 dropdown-user-designation text-secondary">{{ auth()->user()->role->name ?? '' }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="setting-icon"><i class="bi bi-person-fill"></i></div>
                                    <div class="setting-text ms-3"><span data-i18n="header.profile">{{ __('admin.header.profile') }}</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.system_settings.index') }}">
                                <div class="d-flex align-items-center">
                                    <div class="setting-icon"><i class="bi bi-gear-fill"></i></div>
                                    <div class="setting-text ms-3"><span data-i18n="header.settings">{{ __('admin.header.settings') }}</span></div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-icon"><i class="bi bi-box-arrow-right"></i></div>
                                        <div class="setting-text ms-3"><span data-i18n="header.logout">{{ __('admin.header.logout') }}</span></div>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

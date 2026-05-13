@include('admin.layouts.admin_partials.head')

<body>

  <div class="wrapper">

    @include('admin.layouts.admin_partials.header')

    @include('admin.layouts.admin_partials.left_sidebar')

    <main class="page-content">
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3" data-i18n="breadcrumb.pages">@yield('breadcrumb_title', __('admin.breadcrumb.pages'))</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
              </li>
              @hasSection('breadcrumb')
                @yield('breadcrumb')
              @else
                <li class="breadcrumb-item active" aria-current="page">@yield('pageTitle', __('admin.breadcrumb.page'))</li>
              @endif
            </ol>
          </nav>
        </div>
        <div class="ms-auto">
          @yield('page_actions')
        </div>
      </div>

      @yield('content')
    </main>

    <div class="overlay nav-toggle-icon"></div>

    <a href="javascript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
  </div>

  @include('admin.layouts.admin_partials.scripts')

</body>
</html>

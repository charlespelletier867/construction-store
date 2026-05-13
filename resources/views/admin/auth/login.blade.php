@include('admin.layouts.admin_partials.head')
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-1" data-i18n="auth.login_title">{{ __('admin.auth.login_title') }}</h3>
                    <p class="text-muted mb-4" data-i18n="auth.login_subtitle">{{ __('admin.auth.login_subtitle') }}</p>

                    <div class="text-end mb-3">
                        <a href="#" class="lang-switch @if(app()->getLocale() === 'en') fw-bold @endif" data-locale="en">English</a>
                        <span class="text-muted">|</span>
                        <a href="#" class="lang-switch @if(app()->getLocale() === 'km') fw-bold @endif" data-locale="km">ខ្មែរ</a>
                    </div>

                    <form method="POST" action="{{ route('admin.login.attempt') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" data-i18n="field.email">{{ __('admin.field.email') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autofocus required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" data-i18n="field.password">{{ __('admin.field.password') }}</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember" data-i18n="field.remember_me">{{ __('admin.field.remember_me') }}</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" data-i18n="auth.sign_in">{{ __('admin.auth.sign_in') }}</button>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted small mt-3">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</div>

@include('admin.layouts.admin_partials.scripts')

</body>
</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />
</head>

<body>
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="{{asset('assets/images/logos/dark-logo.svg')}}" width="180" alt="">
                            </a>
                            <p class="text-center">Your Social Campaigns</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email Address -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    @error('password')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" id="remember_me" name="remember">
                                        <label class="form-check-label text-dark" for="remember_me">
                                            Remember this Device
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="text-primary fw-bold" href="{{ route('password.request') }}">Forgot Password?</a>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>

                                <!-- Register Link -->
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                                    <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Create an account</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />
    <style>
        #signup-container {
            display: none; /* Initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Dark overlay */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Ensure form is on top */
        }

        /* Signup form box */
        .signup-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 400px; /* Set a fixed width */
            max-width: 90%;
        }

        /* Logo style */
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Input fields styling */
        .form-label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-select,
        .form-control {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.4);
        }

        /* Terms and conditions checkbox styling */
        .form-check {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }

        .form-check-input {
            margin-right: 10px;
        }

        .form-check-label {
            font-size: 14px;
            color: #555;
        }

        .terms-link {
            color: #007bff;
            text-decoration: none;
        }

        .terms-link:hover {
            text-decoration: underline;
        }

        /* Signup button */
        .signup-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .signup-btn:hover {
            background-color: #0056b3;
        }

        /* Signin link at the bottom */
        .signin-link {
            text-align: center;
            margin-top: 15px;
        }

        .signin-link a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .signin-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<!--  Body Wrapper -->
<div class="signup" style="display: flex;justify-content: center;align-items: center;height: 100vh">
    <div class="signup-container">
        <div class="logo">Psixotrop dorilar xisobini yurituvchi web-sayt</div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Ismingiz</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Parol</label>
                <input type="password" id="password" class="form-control" name="password" required>
                @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Parolni tasdiqlang</label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                @error('password_confirmation')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="signup-btn">Ro'yxatdan o'tish</button>

            <div class="signin-link">
                <a href="{{ route('login') }}">Kirish</a>
            </div>
        </form>
    </div>

</div>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>Reset Password</h1>
            <p>Please enter your email address, and we will send you a link to reset your password.</p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required autofocus>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn-primary">Send Password Reset Link</button>
            </form>

            <div class="extra-links">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>

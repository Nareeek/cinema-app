<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-primary">Login</button>
                <div class="extra-links">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                    <p>Don't have an account? <a href="{{ route('register') }}">Register Here</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

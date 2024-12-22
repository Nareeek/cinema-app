<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Ensure this path is correct -->
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>Email Verification Required</h1>
            <p>Please verify your email by clicking on the link sent to your email address. If you didn't receive the email, you can request another below.</p>

            @if (session('resent'))
                <div class="alert alert-success">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn-primary">Resend Verification Email</button>
            </form>

            <div class="extra-links">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>

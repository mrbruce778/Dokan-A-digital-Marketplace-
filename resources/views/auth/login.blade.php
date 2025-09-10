<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    @vite('resources/css/auth.css')
</head>
<body>
    <h2>Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>Don’t have an account? <a href="{{ route('register.form') }}">Register here</a></p>
</body>
</html>

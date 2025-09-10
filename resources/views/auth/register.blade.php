<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    @vite('resources/css/auth.css')
</head>
<body>
    <h2>Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Sign Up</button>
    </form>

    <p>Already registered? <a href="{{ route('login.form') }}">Login here</a></p>
</body>
</html>

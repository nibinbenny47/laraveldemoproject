<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div>
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
            @error('phone_number')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="address">Address</label>
            <textarea name="address" id="address">{{ old('address') }}</textarea>
            @error('address')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Register</button>
    </form>

    <a href="{{ route('login') }}">Already have an account? Login here.</a>
</body>
</html>

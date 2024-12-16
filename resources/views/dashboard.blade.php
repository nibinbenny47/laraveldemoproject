<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ Auth::user()->name }}</h1>
    <p>Email: {{ Auth::user()->email }}</p>
    <p>Phone Number: {{ Auth::user()->phone_number }}</p>
    <p>Address: {{ Auth::user()->address }}</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>

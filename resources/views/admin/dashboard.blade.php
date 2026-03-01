<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Dashboard Admin</h1>

    <p>Login sebagai: {{ $email }}</p>

    <form method="POST" action="/admin/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>

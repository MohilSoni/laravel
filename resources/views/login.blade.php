
<html lang="en">

<head>
    <title>Admin Panel</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="login-form">
    <h2>ADMIN LOGIN PANEL</h2>
    <form action="{{ route('admin.login') }}" method="POST" >
        @csrf
        <div class="input-field">
            <i class="bi bi-envelope-fill"></i>
            <input type="email" class="@error('email') is-invalid @enderror" placeholder="Email Address" name="email">
            <span class="text-danger">
                @error('email')
                {{ $message }}
                @enderror
            </span>
        </div>
        <div class="input-field">
            <i class="bi bi-shield-lock-fill"></i>
            <input type="password" placeholder="Password" name="password">
            <span class="text-danger">
                @error('password')
                {{ $message }}
                @enderror
            </span>
        </div>

        <button type="submit" name="submit">Login</button>

    </form>
</div>



</body>

</html>

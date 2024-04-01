<html>
<head>
    <title>User Panel</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>


<div class="login-form">
    <h2>USER LOGIN PANEL</h2>
    <form action="{{ route('user.login') }}" method="POST">
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
        <div class="extra">
            <a href="#" style="margin: auto;">Forgot Password ?</a>
            <a href="{{ route('google.login') }}"
               style="margin: auto; cursor: pointer; background: #5bd1d7; padding: 10px; color: white; border-radius:7px; text-decoration: none; font-size: 16px"><i
                    class="bi bi-google"></i> Login with Google</a>
            <a href="{{ route('user.register') }}" style="margin: auto;">Register</a>
        </div>
    </form>
</div>


{{--<div class="container">--}}
{{--    <form action="{{ route('user.login') }}" method="POST">--}}
{{--        @csrf--}}
{{--        <input type="email" name="email" placeholder="Email">--}}
{{--        <input type="password" name="password" placeholder="Password">--}}
{{--        <button type="submit" name="submit">Login</button>--}}
{{--    </form>--}}
{{--</div>--}}

</body>
</html>

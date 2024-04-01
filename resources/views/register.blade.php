<html>
<head>
    <title>User Panel</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: poppins;
            text-decoration: none;
        }

        body {
            background-color: #f2f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        div.login-form {
            height: 550px;
            width: 600px;
            background-color: white;
            box-shadow: 0px 5px 10px black;
        }

        div.login-form h2 {
            text-align: center;
            background-color: #204969;
            padding: 12px 0px;
            color: white;
        }

        div.login-form form {
            padding: 45px 60px;
        }

        div.login-form form div.input-field {
            display: flex;
            flex-direction: row;
            margin: 20px 0px;
        }

        div.login-form form div.input-field i {
            color: darkslategray;
            display: flex;
            justify-content: center;
            padding: 10px 14px;
            background-color: #f2f4f6;
            margin-right: 4px;
            padding-top: 22px;
        }

        div.login-form form div.input-field input {
            background-color: #f2f4f6;
            padding: 20px;
            border: none;
            width: 100%;
            font-size: 17px;
            padding-left: 15px;
            margin-left: 4px;
        }

        div.login-form form button {
            width: 100%;
            background-color: #5bd1d7;
            padding: 8px;
            border: none;
            font-size: 17px;
            font-weight: 500;
            color: white;
            margin: 15px 0;
            transition: background-color 0.4s;
        }

        div.login-form form button:hover {
            background-color: #41b6e6;
        }

        div.login-form form div.extra {
            font-size: 14px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        div.login-form form div.extra a:first-child {
            color: darkgrey;
        }

        div.login-form form div.extra a:last-child {
            color: grey;
        }

        #username-error,
        #password-error {
            color: red;
            margin-left: 7px;
        }

        span {
            color: red;
            display: flex;
            margin: auto;
            margin-left: 10px;
        }

    </style>
</head>
<body>


<div class="login-form">
    <h2>USER SIGN UP PANEL</h2>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="input-field">
            <i class="bi bi-person-fill"></i>
            <input type="text" class="@error('firstname') is-invalid @enderror" placeholder="Firstname"
                   name="firstname">
            <span class="text-danger">
                @error('firstname')
                {{ $message }}
                @enderror
            </span>
        </div>
        <div class="input-field">
            <i class="bi bi-person-fill"></i>
            <input type="text" class="@error('lastname') is-invalid @enderror" placeholder="Lastname" name="lastname">
            <span class="text-danger">
                @error('lastname')
                {{ $message }}
                @enderror
            </span>
        </div>
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
        <button type="submit" name="submit">Sign Up</button>
        <div class="extra">
            <a href="#" style="margin: auto;">Forgot Password ?</a>
            <a href="{{ route('google.login') }}"
               style="margin: auto; cursor: pointer; background: #5bd1d7; padding: 10px; color: white; border-radius:7px; text-decoration: none; font-size: 16px"><i
                    class="bi bi-google"></i> Sign up with Google</a>
            <a href="{{ route('user') }}" style="margin: auto;">Already have an Account ?</a>
        </div>
    </form>
</div>

</body>
</html>


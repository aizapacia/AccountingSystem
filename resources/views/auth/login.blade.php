<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Main Stylesheet -->
    <link href="{{url('/template/css/loginstyle.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="screen">
            <div class="screen__content">


                <form class="login" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="login__field">
                        <i class=" login__icon fa-solid fa-user"></i>
                        <input type="text" id="email" class="login__input" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fa-solid fa-lock"></i>
                        <input id="password" type="password" class="login__input" placeholder="Password" name="password" required autocomplete="current-password">
                        @error('email')<br>
                        <small class="text-danger">
                            <strong>The email or password you <br> entered is incorrect.</strong>
                        </small>
                        @enderror
                    </div>
                    <button class="button login__submit" type="submit">
                        <span class="button__text">Log In</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>
                <div class="social-login"><br>
                    <h3>AccSys</h3>
                    <img src="{{ url('/template/images/logo-white.png') }}" alt="logo">
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/3d127ccd55.js" crossorigin="anonymous"></script>
</body>

</html>
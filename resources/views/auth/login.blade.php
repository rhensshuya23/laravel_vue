<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>School Management System | Login</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/materialize.min.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <style>
        body {
          display: flex;
          min-height: 100vh;
          flex-direction: column;
        }

        main {
          flex: 1 0 auto;
        }

        body {
          background: #fff;
        }

        .cus-login {
            display: inline-block;
            padding: 32px 48px 0px 48px;
            border: 1px solid #EEE;
        }

        .input-field input[type=password] {
            width: 157%;
        }

        .input-field input[type=email]:focus + label,
        .input-field input[type=password]:focus + label {
          color: #e91e63;
        }

        .input-field input[type=email]:focus,
        .input-field input[type=password]:focus {
          border-bottom: 2px solid #e91e63;
          box-shadow: none;
    }
  </style>
</head>

<body>
  <div id="app"></div>
  <main>
    <center>
      <h5 class="indigo-text">School Management System - ROS</h5>
      <div class="section"></div>

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row cus-login">

          <form class="col s12" method="POST" action="{{ route('login') }}">
            @csrf
            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class="validate {{ $errors->has('email') ? ' is-invalid' : '' }}" type='email' name='email' id='email' value="{{ old('email') }}" required autofocus />
                <label for='email'>Enter your email</label>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class="validate{{ $errors->has('password') ? ' is-invalid' : '' }}" type='password' name='password' id='password' required />
                <label for='password'>Enter your password</label>
                 @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                 @endif
              </div>
              <label style='float: right; margin-top: 80px'>
                @if (Route::has('password.request'))
                <a class='pink-text' href="{{ route('password.request') }}"><b>Forgot Password?</b></a>
                @endif
              </label>
            </div>

           
              

            <br />
            <center>
              <div class='row'>
                <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect indigo'>
                <i class="fas fa-sign-in-alt"></i>
                Login
                </button>
              </div>
            </center>
          </form>
        </div>
      </div>
      <a href="/register">Create account</a>
      <p><b>Admin login</b> Un: <span style="color: blue">admin@gmail.com</span> Pwd: <span style="color: blue">password</span></p>
      <p><b>User login </b> Un: <span style="color: blue">user@gmail.com</span> Pwd: <span style="color: blue">password</span></p>
    </center>

    <div class="section"></div>
    <div class="section"></div>
  </main>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>
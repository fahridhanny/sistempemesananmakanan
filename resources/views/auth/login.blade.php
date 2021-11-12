<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{ asset('assets/auth/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{ asset('assets/auth/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset('assets/auth/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-black">
        @include('sweetalert::alert')
        <div class="form-box" id="login-box">
            <div class="header" style="background:#4e73df">Sign In</div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"/>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn btn-block" style="background:#4e73df"><p style="color: white;">Login</p></button>
                    <div class="text-center">
                        <a class="small" href="{{ route('register') }}">Belum punya akun ?Buat Akun</a>
                    </div>
                </div>
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="{{ asset('assets/auth/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('assets/auth/bootstrap.min.js') }}" type="text/javascript"></script>        

    </body>
</html>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{ asset('assets/auth/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{ asset('assets/auth/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset('assets/auth/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header" style="background:#4e73df">Register</div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="body bg-gray">
                    <div class="form-group">
                        <select name="hak_akses" id="" class="form-control @error('hak_akses') is-invalid @enderror">
                            <option value="">--- PILIH AKSES ---</option>
                            <option value="pelayan">pelayan</option>
                            <option value="kasir">kasir</option>
                        </select>
                        @error('hak_akses')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Full name"/>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email"/>
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
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"/>
                    </div>
                </div>
                <div class="footer">                    
                    <button type="submit" class="btn btn-block" style="background:#4e73df"><p style="color: white">Sign up</p></button>
                    <div class="text-center">
                        <a class="small" href="{{ route('login') }}">Sudah punya akun ?Silahkan login</a>
                    </div>
                </div>
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="{{ asset('assets/auth/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('assets/backend/js/bootstrap.min.js') }}" type="text/javascript"></script>

    </body>
</html>
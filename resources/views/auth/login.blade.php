<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" href="{{ Storage::url('/custom/logo.png') }}" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <title>Login</title>

        <style>
            .nav-container {
                display: flex;
                flex-direction: column;
                padding-bottom: 20px;
            }

            .nav-container .nav-link:not(.active):hover {
                background-color: #0d6efd;
                color: #fff;
                opacity: 0.5;
            }

            .login-box {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 20px;
                height: 100vh;
                background: linear-gradient(282deg, #00b0ff 5.54%, #3e98eb);
            }

            .login-box .card {
                width: 30rem;
                border-radius: 10px;
            }

            .logo-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding-block: 20px;
            }
            .logo-container .logo {
                object-fit: cover;
                width: 140px;
                height: 140px;
            }
        </style>
    </head>

    <body>
        <div class="login-box" style="height: 100vh">
            <div class="logo-container">
                <img class="logo" src="{{ Storage::url('/custom/logo.png') }}" alt="">
            </div>

            <div class="card" style="width: 30rem;">
                <div class="card-body">
                    <div class="nav-container">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Đăng nhập</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                            </li>
                        </ul>
                    </div>

                    <form action="{{ URL::to('login') }}" method="post" id="loginForm">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="password">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu"
                                    required>
                            </div>
                        </div>
                        <div style="padding-bottom: 20px;">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('sweetalert::alert')

        <script type="text/javascript">
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#loginForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = $(this).serialize();
                    var url = $(this).attr('action');
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: form,
                        dataType: 'json',
                        success: function() {
                            console.log('success!');
                            window.location.href = '/';
                        }
                    });
                });
            });
        </script>
    </body>
</html>

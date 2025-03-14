<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo kích hoạt tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            width: 150px;
        }
        .content {
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ env('APP_URL') . Storage::url('/custom/logo.png') }}" alt="Logo">
        </div>

        <!-- Nội dung -->
        <div class="content">
            <h1>Tài khoản của bạn đã được kích hoạt 🎉</h1>
            <p>Xin chào <strong>{{ $user['name'] }}</strong>,</p>
            <p>Tài khoản của bạn đã được kích hoạt thành công. Bây giờ bạn có thể đăng nhập và sử dụng hệ thống.</p>
            
            <a href="{{ route('login') }}" class="btn">Đăng nhập ngay</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Nếu bạn không yêu cầu kích hoạt tài khoản, vui lòng <a href="#">liên hệ với chúng tôi</a>.</p>
            <p>&copy; 2025 Công ty Accessary. All rights reserved.</p>
        </div>
    </div>

</body>
</html>

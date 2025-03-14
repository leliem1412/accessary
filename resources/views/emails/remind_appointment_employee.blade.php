<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhắc nhở lịch hẹn với khách hàng - Accessary</title>
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
        h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
        }
        .details {
            text-align: left;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .details p {
            margin: 5px 0;
            color: #333;
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
            <img src="{{ env('APP_URL') . Storage::url('/custom/logo.png') }}" alt="Accessary Logo">
        </div>

        <!-- Nội dung -->
        <div class="content">
            <h2>🔔 Nhắc nhở lịch hẹn với khách hàng</h2>
            <p>Xin chào <strong>{{ $appointment['employee']['name'] }}</strong>,</p>
            <p>Bạn có một lịch hẹn phục vụ khách hàng. Dưới đây là chi tiết:</p>
            
            <div class="details">
                <p><strong>📆 Ngày hẹn:</strong> {{ date('d/m/Y', strtotime($appointment['start_date'])) }}</p>
                <p><strong>⏰ Giờ hẹn:</strong> {{ date('H:i', strtotime($appointment['start_date'])) }}</p>
                <p><strong>💼 Dịch vụ:</strong> {{ $appointment['service']['service_name'] }}</p>
                <p><strong>👤 Khách hàng:</strong> {{ $appointment['customer']['name'] }}</p>
                <p><strong>📞 Số điện thoại:</strong> {{ $appointment['customer']['phone'] }}</p>
                <p><strong>📍 Địa điểm:</strong> 171/76 Đoàn Thị Điểm, Bình Dương</p>
            </div>

            <p>Vui lòng sắp xếp thời gian và đảm bảo phục vụ khách hàng đúng giờ.</p>

            <a href="[LINK XÁC NHẬN]" class="btn">Xác nhận lịch hẹn</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Mọi thắc mắc, vui lòng <a href="#">liên hệ quản lý</a>.</p>
            <p>&copy; 2025 Accessary. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
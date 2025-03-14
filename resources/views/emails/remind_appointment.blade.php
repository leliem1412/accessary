<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhắc nhở lịch hẹn - Accessary</title>
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
            background: #28a745;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #218838;
        }
        .cancel-btn {
            background: #dc3545;
        }
        .cancel-btn:hover {
            background: #c82333;
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
            <h2>📅 Nhắc nhở lịch hẹn của bạn</h2>
            <p>Xin chào <strong>{{ $appointment['customer']['name'] }}</strong>,</p>
            <p>Bạn có một lịch hẹn sử dụng dịch vụ tại Accessary. Dưới đây là chi tiết lịch hẹn của bạn:</p>
            
            <div class="details">
                <p><strong>📆 Ngày hẹn:</strong> {{ date('d/m/Y', strtotime($appointment['start_date'])) }}</p>
                <p><strong>⏰ Giờ hẹn:</strong> {{ date('H:i', strtotime($appointment['start_date'])) }}</p>
                <p><strong>💼 Dịch vụ:</strong> {{ $appointment['service']['service_name'] }}</p>
                <p><strong>👨‍💼 Nhân viên phụ trách:</strong> {{ $appointment['employee']['name'] }}</p>
                <p><strong>📍 Địa điểm:</strong> 171/76 Đoàn Thị Điểm, Bình Dương</p>
            </div>

            <p>Vui lòng đến đúng giờ để đảm bảo trải nghiệm tốt nhất. Nếu bạn có bất kỳ thắc mắc nào, hãy liên hệ với chúng tôi.</p>

            <a href="[LINK XÁC NHẬN]" class="btn">Xác nhận lịch hẹn</a>
            <a href="[LINK HỦY HẸN]" class="btn cancel-btn">Hủy lịch hẹn</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Nếu bạn không yêu cầu lịch hẹn này, vui lòng <a href="#">liên hệ với chúng tôi</a>.</p>
            <p>&copy; 2025 Accessary. All rights reserved.</p>
        </div>
    </div>

</body>
</html>

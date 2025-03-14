<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hàng Thành Công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .success-icon {
            font-size: 50px;
            color: #00b0ff;
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
            font-size: 16px;
        }
        .order-details {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .btn {
            display: inline-block;
            background: #00b0ff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <img src="{{ env('APP_URL') . Storage::url('/custom/logo.png') }}" alt="Company Logo" class="logo">
        <div class="success-icon">✅</div>
        <h2>Đặt Hàng Thành Công!</h2>
        <p>Cảm ơn bạn đã mua sắm với chúng tôi. Đơn hàng của bạn đã được xác nhận.</p>
        <div class="order-details">
            <p><strong>Mã đơn hàng:</strong>&nbsp;{{ $salesorder['order_code'] }}</p>
            <p><strong>Tên khách hàng:</strong>&nbsp;{{ $salesorder['customer']['name'] }}</p>
            <p><strong>Số điện thoại:</strong>&nbsp;{{ $salesorder['customer']['phone'] }}</p>
            <p><strong>Email:</strong>&nbsp;{{ $salesorder['customer']['email'] }}</p>
            <p><strong>Ngày đặt hàng:</strong>&nbsp;{{ date('d/m/Y H:i:s', strtotime($salesorder['created_at'])) }}</p>
            <p><strong>Tổng tiền phải trả:</strong>&nbsp;{{ number_format($salesorder['netTotal']) }}đ</p>
            <p><strong>Đã thanh toán:</strong>&nbsp;{{ number_format($salesorder['payment_amount']) }}đ</p>
            <p><strong>Còn nợ:</strong>&nbsp;{{ number_format($salesorder['netTotal'] - $salesorder['payment_amount']) }}đ</p>
        </div>
        <a href="{{ route('salesorder.info', ['id' => Illuminate\Support\Facades\Crypt::encrypt($salesorder['id'])]) }}" class="btn">Xem Chi Tiết hoá đơn</a>
        <p class="footer">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ <a href="mailto:jos.tuanliem@gmail.com">jos.tuanliem@gmail.com</a></p>
    </div>
</body>
</html>

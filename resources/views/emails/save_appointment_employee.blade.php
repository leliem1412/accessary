<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo lịch hẹn mới</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600px" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; padding: 20px; border-radius: 10px;">
                    
                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <img src="{{ env('APP_URL') . Storage::url('/custom/logo.png') }}" alt="Company Logo" width="150">
                        </td>
                    </tr>

                    <!-- Tiêu đề -->
                    <tr>
                        <td align="center" style="font-size: 24px; font-weight: bold; color: #333;">
                            📢 THÔNG BÁO LỊCH HẸN MỚI 📢
                        </td>
                    </tr>

                    <!-- Nội dung chính -->
                    <tr>
                        <td style="font-size: 16px; color: #555; padding: 20px 40px; text-align: center;">
                            Xin chào <strong>{{ $appointment['employee']['name'] }}</strong>,<br>
                            Bạn có một cuộc hẹn mới vừa được đặt.
                        </td>
                    </tr>

                    <!-- Thông tin chi tiết -->
                    <tr>
                        <td style="padding: 10px 40px; font-size: 16px; color: #333;">
                            <strong>📅 Ngày hẹn:</strong> {{ date('d/m/Y', strtotime($appointment['start_date'])) }} <br>
                            <strong>⏰ Giờ hẹn:</strong> {{ date('H:i', strtotime($appointment['start_date'])) }} <br>
                            <strong>👤 Khách hàng:</strong> {{ $appointment['customer']['name'] }} <br>
                            <strong>📞 Số điện thoại:</strong> {{ $appointment['customer']['phone'] }} <br>
                            <strong>💼 Dịch vụ:</strong> {{ $appointment['service']['service_name'] }} <br>
                        </td>
                    </tr>

                    <!-- Lưu ý -->
                    <tr>
                        <td style="font-size: 14px; color: #777; padding: 20px 40px; text-align: center;">
                            Vui lòng kiểm tra lại lịch trình và chuẩn bị trước khi gặp khách hàng. Nếu có bất kỳ thay đổi nào, hãy cập nhật ngay trên hệ thống.
                        </td>
                    </tr>

                    <!-- Nút xác nhận -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <a href="#" style="background-color: #007bff; color: white; padding: 12px 24px; font-size: 16px; text-decoration: none; border-radius: 5px;">
                                Xem Chi Tiết Lịch Hẹn
                            </a>
                        </td>
                    </tr>

                    <!-- Lời cảm ơn -->
                    <tr>
                        <td align="center" style="font-size: 16px; color: #555; padding-top: 20px;">
                            Cảm ơn bạn đã sẵn sàng hỗ trợ khách hàng! 🌟
                        </td>
                    </tr>

                    <!-- Chữ ký -->
                    <tr>
                        <td align="center" style="font-size: 14px; color: #777; padding-top: 20px;">
                            Trân trọng,<br>
                            <strong>Đội ngũ Accessary</strong>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="font-size: 12px; color: #aaa; padding-top: 20px;">
                            Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với quản lý.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt hẹn thành công</title>
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
                            XÁC NHẬN ĐẶT HẸN THÀNH CÔNG 🎉
                        </td>
                    </tr>

                    <!-- Nội dung chính -->
                    <tr>
                        <td style="font-size: 16px; color: #555; padding: 20px 40px; text-align: center;">
                            Xin chào <strong>{{ $appointment['customer']['name'] }}</strong>,<br>
                            Cuộc hẹn của bạn đã được đặt thành công!
                        </td>
                    </tr>

                    <!-- Thông tin chi tiết -->
                    <tr>
                        <td style="padding: 10px 40px; font-size: 16px; color: #333;">
                            <strong>📅 Ngày hẹn:</strong> {{ date('d/m/Y', strtotime($appointment['start_date'])) }} <br>
                            <strong>⏰ Giờ hẹn:</strong> {{ date('H:i', strtotime($appointment['start_date'])) }} <br>
                            <strong>👨‍⚕️ Nhân viên phụ trách:</strong> {{ $appointment['employee']['name'] }} <br>
                            <strong>💼 Dịch vụ:</strong> {{ $appointment['service']['service_name'] }} <br>
                        </td>
                    </tr>

                    <!-- Lưu ý -->
                    <tr>
                        <td style="font-size: 14px; color: #777; padding: 20px 40px; text-align: center;">
                            Vui lòng có mặt đúng giờ và chuẩn bị đầy đủ giấy tờ nếu cần thiết. Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi. 
                        </td>
                    </tr>

                    <!-- Nút xác nhận -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <a href="#" style="background-color: #28a745; color: white; padding: 12px 24px; font-size: 16px; text-decoration: none; border-radius: 5px;">
                                Xem Chi Tiết Cuộc Hẹn
                            </a>
                        </td>
                    </tr>

                    <!-- Lời cảm ơn -->
                    <tr>
                        <td align="center" style="font-size: 16px; color: #555; padding-top: 20px;">
                            Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi! 💙
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
                            Nếu bạn không yêu cầu cuộc hẹn này, vui lòng bỏ qua email này hoặc liên hệ với chúng tôi.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>

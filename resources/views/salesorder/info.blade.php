<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accessary</title>
    <link rel="icon" type="image/png" href="{{ Storage::url('/custom/logo.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-block: 20px;
        }
        .order-customer-info {
            padding-block: 20px;
        }
        .order-customer-info tr td:first-child {
            font-weight: bold;
        }

        .invoice-box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .content-title h4 {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding-block: 20px;
        }

        .content {
            min-width: 700px;
        }
    </style>

    @yield('css')
</head>

<body>
    <div class="template-content-layout" style="position: relative;">
        <div class="loading-container d-none">
            <div class="loading">
                <img src="{{ Storage::url('/custom/logo.png') }}" alt="Loading Logo" class="logo">
                <div class="water-drop"></div>
                <div class="waves"></div>
            </div>
        </div>

       <div class="container invoice-box">
                <div class="content">
                    <div class="content-title">
                        <h4>Hoá đơn bán hàng</h4>
                    </div>

                   <div class="order-customer-info">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Mã đơn hàng:</td>
                                    <td>{{ $entry_data['order_code'] }}</td>
                                </tr>
                                <tr>
                                    <td>Tên khách hàng:</td>
                                    <td>{{ $entry_data['customer']['name'] }}</td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại:</td>
                                    <td>{{ $entry_data['customer']['phone'] }}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $entry_data['customer']['email'] }}</td>
                                </tr>
                                <tr>
                                    <td>Ngày đặt hàng:</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($entry_data['created_at'])) }}</td>
                                </tr>
                                <tr>
                                    <td>Tình trạng thanh toán:</td>
                                    <td>{{ App\Enums\Picklist::getPicklistValue('salesorder', 'payment_status', $entry_data['payment_status']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                   </div>

                    <table class="table table-bordered table-responsive table-striped salesorder_entry_table">
                        <thead>
                            <tr>
                            <th style="width: 10%;">Mã sản phẩm / dịch vụ</th>
                                <th style="width: 50%;">Tên sản phẩm / dịch vụ</th>
                                <th style="width: 20%;">Số lượng</th>
                                <th style="width: 20%;">Giá</th>
                            </tr>
                        </thead>

                        <tbody class="product-service-table-body">
                            @foreach ($entry_data['inventory'] as $inventory)
                                <tr>
                                    <td>{{ $inventory['entry_code'] }}</td>
                                    <td>{{ $inventory['entry_name'] }}</td>
                                    <td>{{ $inventory['quantity'] }}</td>
                                    <td class="price" data-value="{{ $inventory['order_price'] }}">{{ number_format($inventory['order_price']) }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="3" style="text-align: center;">Giảm giá</td>
                                <td>{{ number_format($entry_data['discount']) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="text-align: center;">Thuế</td>
                                <td>{{ number_format($entry_data['tax']) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="text-align: center;">Tổng cộng</td>
                                <td class="total_order" data-value="0">{{ number_format($entry_data['netTotal']) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="text-align: center;">Đã thanh toán</td>
                                <td class="total_order" data-value="0">{{ number_format($entry_data['total_payment_amount']) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="text-align: center;">Còn lại</td>
                                <td class="total_order" data-value="0">{{ number_format($entry_data['netTotal'] - $entry_data['total_payment_amount']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
       </div>
    </div>
</body>

</html>

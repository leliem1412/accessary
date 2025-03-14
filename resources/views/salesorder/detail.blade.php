@extends('app')

@section('css')
<style>
    .entry-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding-block: 10px;
    }

    .entry-container .entry-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
        height: 75vh;
        overflow: hidden;
        overflow-y: auto;
    }

    .entry-container .entry-title {
        font-weight: bold;
        font-size: 1rem;
    }

    .entry-container .entry-list .entry-item {
        border: 1px solid #ccc;
        padding: 10px;
        cursor: pointer;
        border-radius: 10px;
    }

    .entry-container .entry-list .entry-item.active {
        background-color: green;
        color: #fff;
    }

    .entry-list .entry-item .image-box img {
        object-fit: cover;
        width: 100%;
        height: 100px;
    }

    .entry-list .entry-item .entry-name {
        font-size: 16px;
        font-weight: 500;
    }

    .entry-list .entry-item .entry-price {
        font-size: 13px;
    }

    .order-payment-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .order-payment-container .order-title {
        padding: 10px;
        background: linear-gradient(45deg, #1FA2FF, #12D8FA, #A6FFCB);
        font-weight: 600;
        border-radius: 10px;
    }

    .submit-btn-container {
        text-align: right;
        position: sticky;
        bottom: 0;
        width: 100%;
        background: #fff;
    }

    .customer-container,
    .entry-group-container {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 10px;
    }

    .customer-container .customer-title,
    .entry-group-container .entry-group-title {
        font-weight: 600;
        font-size: 1.5rem;
        padding-bottom: 20px;
    }

    .total-order-table tr input[type="text"],
    .salesorder_entry_table tr input[type="number"] {
        border: 1px solid #ccc;
        padding-left: 5px;
        padding-right: 5px;
    }

    .block-container {
        padding: 20px;
        border: 1px solid #ccc;
        display: flex;
        flex-direction: column;
        gap: 20px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .block-container .block-title {
        font-size: 18px;
        font-weight: 600;
        padding: 10px;
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: end;
    }

    .block-container .block-title p {
        margin-bottom: 0;
    }

    .block-container .block-title i.fa-clock-rotate-left {
        color: #A6FF;
        cursor: pointer;
    }

    .block-container .block-title i.fa-clock-rotate-left:hover {
        color: #12D8FA;
    }

    .block-container .block-title::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(45deg, #1FA2FF, #12D8FA, #A6FF);
    }
</style>
@endsection

@section('content')
    <div class="breakcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('salesorder.list') }}">Đơn hàng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
        </div>
    </div>

    <div class="row" style="min-height: 75vh;">
        <div class="col-md-8">

            <!-- Thông tin khách hàng -->
            <div class="block-container">
                <div class="block-title">Thông tin khách hàng</div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên khách hàng</label>
                        <input type="text" readonly class="form-control" name="customer_name">
                    </div>
                
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" readonly class="form-control" name="email">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" readonly class="form-control" name="phone">
                    </div>
                </div>
            </div>
            <!-- Ended thông tin khách hàng -->

           <div class="block-container">
                <div class="block-title">Thông tin dịch vụ / sản phẩm</div>

                <!-- Sản phẩm -->
                <div class="entry-container">
                    <div class="entry-title">Sản phẩm</div>

                    <div class="entry-list">
                        @foreach ($products as $item)
                            <div class="entry-item">
                                <div class="image-box">
                                    <img src="{{ Storage::url($item['image']) }}" alt="">
                                </div>
                                <div class="entry-name">{{ $item['product_name'] }}</div>
                                <div class="entry-price">{{ number_format($item['price']) }}đ</div>
                                <input type="hidden" name="entryData" value="{{ json_encode($item) }}">
                                <input type="hidden" name="entryType" value="product">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Ended Sản phẩm -->

                <!-- Dịch vụ -->
                <div class="entry-container">
                    <div class="entry-title">Dịch vụ</div>

                    <div class="entry-list">
                        @foreach ($services as $item)
                            <div class="entry-item">
                                <div class="image-box">
                                    <img src="{{ Storage::url($item['image']) }}" alt="">
                                </div>
                                <div class="entry-name">{{ $item['service_name'] }}</div>
                                <div class="entry-price">{{ number_format($item['price']) }}đ</div>
                                <input type="hidden" name="entryData" value="{{ json_encode($item) }}">
                                <input type="hidden" name="entryType" value="service">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Ended Dịch vụ -->
           </div>
        
        </div>
        <div class="col-md-4">
            <!-- Thông tin đơn hàng -->
            <div class="block-container">
            <div class="block-title">Thông tin đơn hàng</div>

            <div class="product-service-container">
                <table class="table table-bordered table-responsive table-striped salesorder_entry_table">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Tên sản phẩm / dịch vụ</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>

                    <tbody class="product-service-table-body">
                    </tbody>
                </table>

            </div>

            <table class="table table-bordered table-responsive table-striped total-order-table">
                <tbody>
                    <tr>
                        <td style="width: 200px;">Giảm giá</td>
                        <td><input type="text" readonly name="discount" value="0"></td>
                    </tr>

                    <tr>
                        <td style="width: 200px;">Thuế</td>
                        <td><input type="text" readonly name="tax" value="0"></td>
                    </tr>

                    <tr>
                        <td style="width: 200px;">Tổng cộng</td>
                        <td class="total_order" data-value="0">0</td>
                    </tr>
                </tbody>
            </table>
            </div>
            <!-- Ended thông tin đơn hàng -->

            <!-- Thông tin thanh toán -->
             <div class="block-container">
                <div class="block-title">
                    <p>Thông tin thanh toán</p>
                    <i class="fa-solid fa-clock-rotate-left show_payment_history" data-bs-toggle="tooltip" data-bs-placement="top" title="Xem lịch sử thanh toán"></i>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Tình trạng thanh toán</label>
                        {!! App\Enums\Picklist::getPicklistView('salesorder', 'Vui lòng chọn tình trạng thanh toán', 'payment_status', $entry_data['payment_status'], true) !!}
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="payment_amount" class="form-label">Tổng tiền đã thanh toán</label>
                        <input class="form-control" type="text" readonly name="payment_amount" value="{{ number_format($entry_data['total_payment_amount']) }}" disabled>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="payment_amount" class="form-label">Tổng tiền còn nợ</label>
                        <input class="form-control" type="text" readonly name="payment_amount" value="{{ number_format((float) $entry_data['netTotal'] - (float) $entry_data['total_payment_amount']) }}" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <input type="hidden" name="salesOrderData" value="{{ json_encode($entry_data) }}">

   <!-- Modal -->
   <div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-labelledby="paymentHistoryModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lịch sử thanh toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-primary table-bordered payment_history_table">
                        <thead>
                            <tr>
                                <th>Ngày thanh toán</th>
                                <th>Tổng tiền thanh toán</th>
                                <th>Loại thanh toán</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')
@endsection

@section('script')
<script>
    const Customer_CreateView_Js = new class {
        entryList = [];

        constructor() {
            this.initField();
            this.loadSalesOrderData();
            this.handleClickToShowPaymentHistoryEvent();
        }

        initField() {
            this.$showPaymentHistoryBtn = $('.show_payment_history');
            this.$salesOrderData = $('input[name=salesOrderData]');
            this.$paymentHistoryModal = $('#paymentHistoryModal');
        }

        addNewEntryData(newEntryData) {
            const entryList = this.entryList;
            const checkEntryExist = this.checkDublicateEntryList(entryList, newEntryData);

            if (entryList.length > 0 && checkEntryExist) {
                entryList.forEach(entry => {
                    if (this.checkDublicateEntryData(entry, newEntryData)) {
                        const newEntryQuantity = parseFloat(newEntryData['quantity']);
                        const entryPrice = parseFloat(entry['price']);
                        entry['quantity'] = newEntryQuantity;
                        entry['order_price'] = entryPrice * newEntryQuantity;
                    }
                });  
            }
            else {
                entryList.push(newEntryData);
            }

            this.resetEntryTableInfo();
        }

        setActiveEntryItem() {
            const entryList = this.entryList;

            $.each($('.entry-container .entry-list .entry-item'), (index, entryItem) => {
                const entryDataJson = $(entryItem).find('input[name=entryData]').val();
                const entryData = JSON.parse(entryDataJson);
                const entryType = $(entryItem).find('input[name=entryType]').val();

                const checkEntryExist = this.checkDublicateEntryList(entryList, {
                    'id': entryData['id'],
                    'entry_type': entryType
                });

                if (checkEntryExist) {
                    $(entryItem).addClass('active');
                }
                else {
                    $(entryItem).removeClass('active');
                }
            });
        }

        checkDublicateEntryList(entryList, compareEntryData) {
            console.log(entryList, compareEntryData)
            return entryList.some(entry => entry['id'] == compareEntryData['id'] && entry['entry_type'] == compareEntryData['entry_type']);
        }

        checkDublicateEntryData(entryData, compareEntryData) {
            return entryData['id'] == compareEntryData['id'] && entryData['entry_type'] == compareEntryData['entry_type'];
        }

        resetEntryTableInfo() {
            // Active entry item
            // this.setActiveEntryItem();

            // Reset entry table
            const entryList = this.entryList;
            const productServiceTableBody = $('.product-service-table-body');
            productServiceTableBody.empty();

            entryList.forEach(entry => {
                const entryItemHtml = this.generateEntryItemHtml(entry);
                productServiceTableBody.append(entryItemHtml);
            });

            // Reset order total
            let totalPrice = 0;
            const orderTax = parseFloat($('[name=tax]').val());
            const orderDiscount = parseFloat($('[name=discount]').val());
            totalPrice += orderTax + orderDiscount;

            $.each($('.product-service-table-body tr'), (index, item) => {
                const quantity = parseFloat($(item).find('input[name=quantity]').val());
                const price = parseFloat($(item).find('td.price').data('value'));
                totalPrice += price;
            });

            $('.total_order').html(this.fortmatCurrency(totalPrice));
            $('.total_order').attr('data-value', totalPrice);
        }

        generateEntryItemHtml(entryItem) {
            const entryName = this.getEntryName(entryItem);
            const entryId = entryItem['id'];
            const entryType = entryItem['entry_type'];
            const entryPrice = parseFloat(entryItem['order_price']);
            const entryQuantity = parseFloat(entryItem['quantity']);

            let html = '<tr>';
            html += '<td>';
            html += entryName;
            html += '<input type="hidden" name="entry_id" value="' + entryId + '">';
            html += '<input type="hidden" name="entry_type" value="' + entryType + '">';
            html += '</td>';
            html += '<td><input type="number" name="quantity" readonly value="' + entryQuantity + '" min="1" style="width: 75px;"></td>';
            html += '<td class="price" style="width: 120px;" data-value="' + entryPrice + '">' + this.fortmatCurrency(entryPrice) + '</td>';
            html += '</tr>';

            return html;
        }

        getEntryName(entryItem) {
            let entryName = '';
            const entryType = entryItem['entry_type'];

            switch (entryType) {
                case 'product':
                    entryName = entryItem['product_name'];
                    break;

                case 'service':
                    entryName = entryItem['service_name'];
                    break;
            }

            return entryName;
        }

        getTotalPrice() {
            const orderTax = parseFloat($('[name=tax]').val());
            const orderDiscount = parseFloat($('[name=discount]').val());
            const totalOrder = parseFloat($('.total_order').data('value'));

            return {
                'order_tax': orderTax,
                'order_discount': orderDiscount,
                'total_order': totalOrder
            };
        }

        resetTotalPrice() {
            let totalPrice = 0;
            const currentTotalPrice = this.getTotalPrice();
            const orderTax = parseFloat(currentTotalPrice['order_tax']);
            const orderDiscount = parseFloat(currentTotalPrice['order_discount']);
            totalPrice += orderTax + orderDiscount;

            $.each($('.product-service-table-body tr'), (index, item) => {
                const quantity = parseFloat($(item).find('input[name=quantity]').val());
                const price = parseFloat($(item).find('td.price').data('value'));
                totalPrice += quantity * price;
            });

            $('.total_order').html(totalPrice);
        }

        getCustomerInfo() {
            const customerName = $('[name=customer_name]').val();
            const customerPhone = $('[name=phone]').val();
            const customerEmail = $('[name=email]').val();

            return {
                'customer_name': customerName,
                'phone': customerPhone,
                'email': customerEmail,
            };
        }

        async loadSalesOrderData() {
            const salesOrderDataJson = $('input[name=salesOrderData]').val();
            try {
                const salesOrderData = JSON.parse(salesOrderDataJson);
                const customerInfo = await this.getCustomerInfoAjax(salesOrderData['customer_id']);
                const entryList = await this.getEntryListAjax(salesOrderData['id']);

                // set Customer info
                $('[name=customer_name]').val(customerInfo['name']);
                $('[name=phone]').val(customerInfo['phone']);
                $('[name=email]').val(customerInfo['email']);

                // update salesorder data
                const discount = parseFloat(salesOrderData['discount']);
                const tax = parseFloat(salesOrderData['tax']);
                $('table.total-order-table tbody tr input[name=discount]').val(discount);
                $('table.total-order-table tbody tr input[name=tax]').val(tax);

                // Update inventory
                entryList.forEach(entry => {
                    this.addNewEntryData(entry);
                });
                
          } 
          catch (error) {
            console.log(error);
          }
        }

        async getCustomerInfoAjax(customerId) {
            const params = {
                'customer_id': customerId
            };

            const response = await $.ajax({
                type: 'POST',
                url: '/salesorder/getCustomerInfo',
                data: params,
                dataType: 'json',
                success: function(reponse) {
                    return reponse
                },
                error: function({ responseJSON }) {
                    alert(responseJSON['message']);
                }
            });

            return response;
        }

        async getEntryListAjax(salesOrderId) {
            const params = {
                'sales_order_id': salesOrderId
            };

            const response = await $.ajax({
                type: 'POST',
                url: '/salesorder/getInventoryList',
                data: params,
                dataType: 'json',
                success: function(reponse) {
                    return reponse
                },
                error: function({ responseJSON }) {
                    alert(responseJSON['message']);
                }
            });

            return response;
        }

        fortmatCurrency(value) {
            const vndFormatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
                });

            const price = vndFormatter.format(value);

            return price;
        }

        handleClickToShowPaymentHistoryEvent() {
            this.$showPaymentHistoryBtn.on('click', (event) => {
                event.preventDefault();

                const salesorderDataJson = this.$salesOrderData.val();
                const salesorderData = JSON.parse(salesorderDataJson);

                this.onProcess();
                $.ajax({
                    type: 'GET',
                    url: '/salesorder/getPaymentHistory/' + salesorderData['hash_id'],
                    dataType: 'json',
                    success: ({ data }) => {
                        this.offProcess();
                        console.log(data);
                        let html = '';

                        data?.map(item => {
                            html += '<tr>';
                            html += '<td>' + item['created_at'] + '</td>';
                            html += '<td>' + item['amount'] + '</td>';
                            html += '<td>' + item['payment_method'] + '</td>';
                            html += '</tr>';

                        });

                        this.$paymentHistoryModal.find('table.payment_history_table tbody').empty().append(html);
                        this.$paymentHistoryModal.modal('show');
                    },
                    error: () => {
                        this.offProcess();
                    }
                });
            });
        }

        onProcess() {
            $('.loading-container').removeClass('d-none');
        }

        offProcess() {
            $('.loading-container').addClass('d-none');
        }
    }
</script>
@endsection

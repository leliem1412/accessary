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

    .search-box {
        /* width: 600px; */
        background: #fff;
        /* margin: 200px auto 0; */
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    
    .search-box .search-box-row {
        display: flex;
        align-items: center;
        height: 38px;
        padding-left: 5px;
        padding-right: 5px;
    }

    .search-box .search-box-row input {
        flex: 1;
        height: 50px;
        background: transparent;
        border: 0;
        outline: 0;
        /* font-size: 18px; */
        color: #333;
    }

    .search-box .search-box-row button {
        background: transparent;
        border: 0;
        outline: 0;
    }

    .search-box button .fa-solid {
        width: 25px;
        color: #555;
        font-size: 13px;
        cursor: pointer;
    }

    ::placeholder {
        color: #555;
    }

    .search-box .result-box {
        max-height: 200px;
        overflow-y: auto;
    }

    .search-box .result-box ul {
        border-top: 1px solid #999;
        padding-left: 10px;
        padding-right: 10px;
    }

    .search-box .result-box ul li {
        list-style: none;
        border-radius: 3px;
        padding: 10px;
        cursor: pointer;
    }

    .search-box .result-box ul li:hover {
        background: #e9f3ff;
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
                <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
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
                        <label for="customer_name" class="form-label">Tên khách hàng</label>
                        <div class="search-box">
                            <div class="search-box-row">
                                <input type="text" id="input-box" name="customer_name" placeholder="Nhập tên khách hàng" autocomplete="off">
                                <button><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>

                            <div class="result-box">
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Nhập email">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại">
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
                                <div class="entry-price">{{ number_format($item['price'], 0, ',', '.') }}đ</div>
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
                            <div class="entry-item entry-item-{{ $item['id'] . '-service' }}">
                                <div class="image-box">
                                    <img src="{{ Storage::url($item['image']) }}" alt="">
                                </div>
                                <div class="entry-name">{{ $item['service_name'] }}</div>
                                <div class="entry-price">{{ number_format($item['price'], 0, ',', '.') }}đ</div>
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
                                <th></th>
                            </tr>
                        </thead>

                        <tbody class="product-service-table-body">
                            <tr>
                                <td class="text-center" colspan="4">Dữ liệu trống</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <table class="table table-bordered table-responsive table-striped total-order-table">
                    <tbody>
                        <tr>
                            <td style="width: 200px;">Giảm giá</td>
                            <td><input type="text" name="discount" value="0"></td>
                        </tr>

                        <tr>
                            <td style="width: 200px;">Thuế</td>
                            <td><input type="text" name="tax" value="0"></td>
                        </tr>

                        <tr>
                            <td style="width: 200px;">Tổng cộng</td>
                            <td class="total_order" data-value="0">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
             <!-- Ended Thông tin đơn hàng -->

             <div class="block-container">
                <div class="block-title">Thông tin thanh toán</div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Hình thức thanh toán</label>
                        {!! App\Enums\Picklist::getPicklistView('salesorder', 'Vui lòng chọn hình thức thanh toán', 'payment_method') !!}
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Số tiền thanh toán</label>
                        <input type="text" class="form-control" name="payment_money" placeholder="Nhập tổng tiền thanh toán">
                    </div>
                </div>
             </div>
        </div>
    </div>

   <div class="submit-btn-container">
       <button class="btn btn-cancel">Huỷ</button>
        <button id="save_order" type="submit" class="btn btn-primary">Lưu</button>
   </div>

    @include('sweetalert::alert')
@endsection

@section('script')
<script>
    const Customer_CreateView_Js = new class {
        entryList = [];

        constructor() {
            this.initFormValidator();
            this.handleEntryItemSelectEvent();
            this.handleTaxEventChange();
            this.handleDiscountEventChange();
            this.handleEntryItemQuantityChangeEvent();
            this.handleRemoveEntryItemEvent();
            this.handleSaveOrderEvent();
            this.handleCustomerNameChangeEvent();
            this.handleSearchInputSelectEvent();
        }

        initFormValidator() {
            // just for the demos, avoids form submit
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });
            $('form[name=productForm]').validate({
                rules: {
                    product_name: {
                        required: true,
                    },
                    product_category: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                },
                messages: {
                    product_name: {
                        required: "Vui lòng nhập tên sản phẩm",
                    },
                    product_category: {
                        required: "Vui lòng chọn loại sản phẩm",
                    },
                    price: {
                        required: "Vui lòng nhập giá",
                    }
                }
            })
        }

        handleEntryItemSelectEvent() {
            $('.entry-item').on('click', (event) => {
                const entryDataJson = $(event.currentTarget).find('input[name=entryData]').val();
                const entryType = $(event.currentTarget).find('input[name=entryType]').val();
                const entryData = JSON.parse(entryDataJson);
                entryData['entry_type'] = entryType;
                entryData['quantity'] = 1;
                entryData['order_price'] = entryData['price'];
                const checkedEntryData = this.entryList.find(entry => this.checkDublicateEntryData(entry, entryData));

                if (checkedEntryData) {
                    const entryQuantity = parseFloat(entryData['quantity']);
                    const entryPrice = parseFloat(entryData['price']);
                    entryData['quantity'] = entryQuantity + checkedEntryData['quantity'];
                }

                this.addNewEntryData(entryData);
            });
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

        checkDublicateEntryList(entryList, compareEntryData) {
            return entryList.some(entry => entry['id'] == compareEntryData['id'] && entry['entry_type'] == compareEntryData['entry_type']);
        }

        checkDublicateEntryData(entryData, compareEntryData) {
            return entryData['id'] == compareEntryData['id'] && entryData['entry_type'] == compareEntryData['entry_type'];
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

        resetEntryTableInfo() {
            // Set active entry item
            this.setActiveEntryItem();

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

            $('.total_order').html(this.fortmatCurrency(parseFloat(totalPrice)));
            $('.total_order').attr('data-value', totalPrice);

            // Bind bootstrap tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
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
            html += '<td><input type="number" name="quantity" value="' + entryQuantity + '" min="1" style="width: 75px;"></td>';
            html += '<td class="price" style="width: 120px;" data-value="' + entryPrice + '">' + this.fortmatCurrency(entryPrice) + '</td>';
            html += '<td class="action text-center" style="width: 50px;"><i class="fa-solid fa-trash text-danger action-remove" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Xoá sản phẩm / dịch vụ" style="cursor: pointer;"></i></td>';
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

        handleTaxEventChange() {
            $('[name=tax]').on('change', (event) => {
                this.resetTotalPrice();
            });
        }

        handleDiscountEventChange() {
            $('[name=discount]').on('change', (event) => {
                this.resetTotalPrice();
            });
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

            $('.total_order').html(this.fortmatCurrency(parseFloat(totalPrice)));
        }

        handleEntryItemQuantityChangeEvent() {
            $(document).on('change', 'tbody.product-service-table-body td input[name=quantity]', (event) => {
                event.preventDefault();

                const quantity = parseFloat($(event.target).val());
                const entryId = $(event.target).closest('tr').find('input[name=entry_id]').val();
                const entryType = $(event.target).closest('tr').find('input[name=entry_type]').val();
                const entryData = this.entryList.find(entry => this.checkDublicateEntryData(entry, {
                    'id': entryId,
                    'entry_type': entryType
                }));

                entryData['quantity'] = quantity;

                this.addNewEntryData(entryData);
            });
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

        setCustomerInfo(customerName, customerPhone, customerEmail) {
            $('[name=customer_name]').val(customerName);
            $('[name=phone]').val(customerPhone);
            $('[name=email]').val(customerEmail);
        }

        handleRemoveEntryItemEvent() {
            $(document).on('click', 'tbody.product-service-table-body td .action-remove', (event) => {
                console.log('remove item')
                const entryId = $(event.target).closest('tr').find('input[name=entry_id]').val();
                const entryType = $(event.target).closest('tr').find('input[name=entry_type]').val();
                this.removeEntryData(entryId, entryType);
            });
        }

        removeEntryData($entryItemId, entryType) {
            this.entryList = this.entryList.filter(entry => !this.checkDublicateEntryData(entry, {
                'id': $entryItemId,
                'entry_type': entryType
            }));

            this.resetEntryTableInfo();
        }

        handleSaveOrderEvent() {
            $('button#save_order').on('click', (event) => {
                const customerInfo = this.getCustomerInfo();
                const entryList = this.entryList;
                const totalPrice = this.getTotalPrice();
                const orderPayment = this.getOrderPayment();
                const params =  {
                    'customer_info': customerInfo,
                    'entry_list': entryList,
                    'total_price': totalPrice,
                    'order_payment': orderPayment,
                };
                document.querySelector('.header-nav-custom').scrollIntoView({ behavior: "smooth", block: "start" });
                this.onProcess();
                
                $.ajax({
                    type: 'POST',
                    url: '/salesorder/store',
                    data: params,
                    dataType: 'json',
                    success: (response) => {
                        this.offProcess();
                        const { message, data } = response;
                        console.log('success!');
                        window.location.href = '/salesorder/detail/' + data['id'];
                    },
                    error: function({ responseJSON }) {
                        this.offProcess();
                        alert(responseJSON['message']);
                    }
                });
            });
        }

        fortmatCurrency(value) {
            const vndFormatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
                });

            const price = vndFormatter.format(value);

            return price;
        }

        handleCustomerNameChangeEvent() {
            $('input[name=customer_name]').on('keyup', async (event) => {
                event.preventDefault();
                const value = $(event.target).val().trim();

                if (value.length >= 3) {
                    const customers = await this.getCustomerListAjax(value);
                    this.displaySearchInputValue(customers);
                }
                else {
                    $('.result-box').empty();
                }
            })
        }

        displaySearchInputValue(customers) {
            const content = customers.map((customer) => {
                const customerNameShow = customer['customer_code'] + ' - ' + customer['name'];

                return "<li class='search-input-result' data-value='" + JSON.stringify(customer) + "'>" + customerNameShow + "</li>";
            });

            $('.result-box').empty().html("<ul>" + content.join('') + "</ul>");
        }

        handleSearchInputSelectEvent() {
            $(document).on('click', '.result-box .search-input-result', (event) => {
                const customer = $(event.target).data('value');
                console.log(customer);
                this.setCustomerInfo(customer['name'], customer['phone'], customer['email']);

                $('.result-box').empty();
            });
        }

        async getCustomerListAjax(value) {
            const params = {
                'keyword': value
            };

            const response = await $.ajax({
                type: 'POST',
                url: '/customer/getCustomerList',
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

        getOrderPayment() {
            const paymentMethod = $('select[name=payment_method]').val();
            const paymentMoney = $('input[name=payment_money]').val();

            return { paymentMethod, paymentMoney };
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

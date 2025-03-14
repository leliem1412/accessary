@extends('app')

@section('css')
    <style>
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
        .table-filter-custom input,
        .table-filter-custom select {
            border: 1px solid #ccc;
            outline: none;
            width: 100%;
            border-radius: 3px;
            padding: 5px;
        }
        .table-filter-custom select {
            font-weight: 300 !important;
        }
        .table-filter-custom .table-filter-custom-action {
            display: flex;
            flex-direction: row;
            gap: 5px;
            align-items: center;
            justify-content: center;
        }
        .table-filter-custom .table-filter-custom-action i {
            font-size: 18px;
        }
    </style>
@endsection

@section('content')
    <div class="breakcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Khách hàng</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <a href="{{ route('customer.create') }}" class="btn btn-primary pull-right">Thêm mới</a>
        </div>
   </div>

    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <table class="table table-bordered table-responsive table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã khách hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                    </tr>

                    <tr class="table-filter-custom">
                        <th class="table-filter-custom-action">
                            <a href="#" class="table-filter-search-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Lọc">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                            <a href="#" class="table-filter-remove-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Xoá lọc">
                                <i class="fa-solid fa-eraser"></i>
                            </a>
                        </th>
                        <th><input type="text" name="customer_code" placeholder="Nhập mã khách hàng"></th>
                        <th><input type="text" name="name" placeholder="Nhập tên khách hàng"></th>
                        <th><input type="text" name="email" placeholder="Nhập email"></th>
                        <th><input type="text" name="phone" placeholder="Nhập số điện thoại"></th>
                    </tr>
                </thead>
                <tbody id="customer_table_body">

                    @if (count($customers) > 0)
                        @foreach ($customers as $key => $customer)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td><a href="{{ route('customer.detail', ['id' => Illuminate\Support\Facades\Crypt::encrypt($customer['id'])]) }}">{{ $customer['customer_code'] }}</a></td>
                                <td>{{ $customer['name'] }}</td>
                                <td>{{ $customer['email'] }}</td>
                                <td>{{ $customer['phone'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                        </tr>
                    @endif
                </tbody>
            </table>


            {{ $customers->links() }}
        </div>
    </div>
@endsection

@section('script')
<script>
    const Customer_ListView_Js = new class {
        constructor() {
            this.handleSearchTableEvent();
            this.handleRemoveFilterTableEvent();
            this.loadCustomerFilterFormUrl();
            this.handleChangePageEvent();
        }

        handleSearchTableEvent() {
            $('.table-filter-search-btn').on('click', (e) => {
                e.preventDefault();

                const table = $(event.currentTarget).closest('table');
                const customer_code = table.find('input[name="customer_code"]').val();
                const name = table.find('input[name="name"]').val();
                const email = table.find('input[name="email"]').val();
                const phone = table.find('input[name="phone"]').val();

                const queryParams = {
                    customer_code: customer_code,
                    name: name,
                    email: email,
                    phone: phone,
                };

                $.pjax({
                    url: window.location.pathname + '?' + $.param(queryParams),
                    container: '#customer_table_body',
                    type: 'GET',
                    push: true,
                    replace: false,
                    timeout: 3000
                });

            });
        }

        handleRemoveFilterTableEvent() {
            $('.table-filter-custom .table-filter-remove-btn').on('click', (e) => {
                e.preventDefault();

                $.pjax({
                    url: window.location.pathname,
                    container: '#customer_table_body',
                    type: 'GET',
                    push: true,
                    replace: false,
                    timeout: 3000
                });
            });
        }

        loadCustomerFilterFormUrl() {
            const params = this.getQueryParams();

            // Lặp qua tất cả input và select để gán giá trị từ URL
            $(".table-filter-custom input, .table-filter-custom select").each(function () {
                let name = $(this).attr("name");
                if (params[name]) {
                    $(this).val(params[name]).trigger("change"); // Gán giá trị và kích hoạt sự kiện change
                }
            });
        }

        handleChangePageEvent() {
            const queryParams = this.getQueryParams();
            delete queryParams['page'];

            $('.pagination a').on('click', (e) => {
                e.preventDefault();
                let url = $(event.currentTarget).attr('href');
                if (Object.keys(queryParams).length > 0) url += '&' + $.param(queryParams);

                $.pjax({
                    url: url,
                    container: '#customer_table_body',
                    type: 'GET',
                    push: true,
                    timeout: 3000
                });
            });
        }

        getQueryParams() {
            let params = {};
            let search = window.location.search.substring(1);
            if (search) {
                search.split("&").forEach(function (part) {
                    let [key, value] = part.split("=");
                    if (key && value) {
                        params[decodeURIComponent(key)] = decodeURIComponent(value.replace(/\+/g, " "));
                    }
                });
            }
            return params;
        }
    }
</script>
@endsection

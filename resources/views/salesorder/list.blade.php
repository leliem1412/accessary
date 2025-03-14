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
                <li class="breadcrumb-item active" aria-current="page">Đơn hàng</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <a href="{{ route('salesorder.create') }}" class="btn btn-primary pull-right">Thêm mới</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <table class="table table-bordered table-responsive table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo</th>
                        <th>Người tạo</th>
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
                        <th><input type="text" placeholder="Nhập mã đơn hàng" name="order_code"></th>
                        <th><input type="text" placeholder="Nhập tên khách hàng" name="customer_name"></th>
                        <th><input type="text" placeholder="Nhập tổng tiền" name="netTotal"></th>
                        <th><input type="date" placeholder="Chọn ngày tạo" name="created_at"></th>
                        <th><input type="text" placeholder="Nhập người tạo" name="created_by_id" disabled></th>
                    </tr>
                </thead>
                <tbody id="salesorder_table_body">
                   @if (count($entry_data) > 0)
                        @foreach ($entry_data as $key => $item)
                            <tr>
                                <td>{{ ($entry_data->currentPage() - 1) * $entry_data->perPage() + $key + 1 }}</td>
                                <td><a href="{{ route('salesorder.detail', ['id' => Illuminate\Support\Facades\Crypt::encrypt($item['id'])]) }}">{{ $item['order_code'] }}</a></td>
                                <td>{{ $item['customer']['name'] }}</td>
                                <td>{{ number_format($item['netTotal']) }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($item['created_at'])) }}</td>
                                <td>{{ $item['user']['name'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu</td>
                        </tr>
                   @endif
                </tbody>
            </table>

            {{ $entry_data->links() }}
        </div>
    </div>
@endsection

@section('script')
<script>
    const Product_ListView_Js = new class {
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
                const order_code = table.find('input[name="order_code"]').val();
                const customer_name = table.find('input[name="customer_name"]').val();
                const status = table.find('select[name="status"]').val();
                const netTotal = table.find('input[name="netTotal"]').val();
                const created_at = table.find('input[name="created_at"]').val();
                const created_by_id = table.find('select[name="created_by_id"]').val();

                const queryParams = {
                    order_code: order_code,
                    customer_name: customer_name,
                    netTotal: netTotal,
                    created_at: created_at,
                    created_by_id: created_by_id,
                    status: status,
                };

                $.pjax({
                    url: window.location.pathname + '?' + $.param(queryParams),
                    container: '#salesorder_table_body',
                    type: 'GET',
                    push: true,
                    replace: false,
                    timeout: 3000
                });

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
                    container: '#salesorder_table_body',
                    type: 'GET',
                    push: true,
                    timeout: 3000
                });
            });
        }

        handleRemoveFilterTableEvent() {
            $('.table-filter-custom .table-filter-remove-btn').on('click', (e) => {
                e.preventDefault();

                $.pjax({
                    url: window.location.pathname,
                    container: '#salesorder_table_body',
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

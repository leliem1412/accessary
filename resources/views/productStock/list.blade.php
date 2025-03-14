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

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-size: 14px;
        padding-block: 10px;
    }

    .product-info .product-name,
    .product-info .product-quantity {
        font-weight: 500;
    }

    .product-info .product-name span,
    .product-info .product-quantity span {
        font-weight: 300;
    }
</style>
@endsection

@section('content')
    <div class="breakcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Lịch sử nhập / xuất kho</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <button class="btn btn-primary pull-right" data-bs-toggle="modal" data-bs-target="#importExportModal">Nhập / xuất kho</button>
        </div>
   </div>

    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <table class="table table-bordered table-responsive table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Loại</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng nhập / xuất</th>
                        <th>Nội dung</th>
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
                        <th>{!! App\Enums\Picklist::getPicklistView('product_stock', 'Chọn loại tồn kho', 'stock_type') !!}</th>
                        <th><input type="text" placeholder="Nhập tên sản phẩm" name="product_name"></th>
                        <th><input type="number" placeholder="Nhập số lượng nhập / xuất" name="quantity"></th>
                        <th>{!! App\Enums\Picklist::getPicklistView('product_stock', 'Chọn mô tả', 'description') !!}</th>
                        <th><input type="date" placeholder="Chọn ngày tạo" name="created_at"></th>
                        <th><input type="text" placeholder="Nhập người tạo" name="user_name"></th>
                    </tr>
                </thead>
                <tbody id="product_stock_table_body">
                    @if (count($entry_data) > 0)
                        @foreach ($entry_data as $key => $item)
                            <tr>
                                <td>{{ ($entry_data->currentPage() - 1) * $entry_data->perPage() + $key + 1 }}</td>
                                <td>{{ App\Enums\Picklist::getPicklistValue('product_stock', 'stock_type', $item['stock_type']) }}</td>
                                <td>{{ $item['product']['product_name'] }}</td>
                                <td>{{ number_format($item['quantity']) }}</td>
                                <td>{{ App\Enums\Picklist::getPicklistValue('product_stock', 'description', $item['description']) }}</td>
                                <td>{{ $item['created_at'] }}</td>
                                <td>{{ $item['user']['name'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{ $entry_data->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="importExportModal" tabindex="-1" aria-labelledby="importExportModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nhập / xuất kho</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form name="importExportForm" action="{{ route('product_stock.store') }}" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stock_type" class="form-label">Loại nhập / xuất</label>
                                <select class="form-select" aria-label="Default select example" name="stock_type" id="stock_type">
                                    <option selected>Chọn loại nhập / xuất</option>
                                    <option value="import">Nhập kho</option>
                                    <option value="export">Xuất kho</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service_name" class="form-label">Sản phẩm</label>
                                <!-- <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Nhập sản phẩm"> -->

                                <select class="form-select" aria-label="Default select example" name="product_id" id="product_id">
                                    <option selected>Vui lòng chọn sản phẩm</option>

                                    @foreach ($product_list as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['product_code'] }} - {{ $item['product_name'] }}</option>
                                    @endforeach
                                </select>

                              <div class="product-info text-danger d-none">
                                <div class="product-name">Sản phẩm:&nbsp;<span></span></div>
                                <div class="product-quantity">Số lượng:&nbsp;<span></span></div>
                                <input type="hidden" name="product_info_data">
                              </div>
                            </div>
                            

                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Số lượng nhập / xuất</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Nhập số lượng nhập / xuất">
                            </div>
                        </div>
                   </form>
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-primary save_stock">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    const ProductStock_ListView_Js = new class {
        constructor() {
            this.handleSearchTableEvent();
            this.handleRemoveFilterTableEvent();
            this.loadCustomerFilterFormUrl();
            this.handleChangePageEvent();
            this.handleStoreProductStockEvent();
            this.handleChangeProductFormEvent();
        }

        handleSearchTableEvent() {
            $('.table-filter-search-btn').on('click', (e) => {
                e.preventDefault();

                const table = $(event.currentTarget).closest('table');
                const stock_type = table.find('select[name="stock_type"]').val();
                const product_name = table.find('input[name="product_name"]').val();
                const quantity = table.find('input[name="quantity"]').val();
                const description = table.find('select[name="description"]').val();
                const created_at = table.find('input[name="created_at"]').val();
                const user_name = table.find('input[name="user_name"]').val();

                const queryParams = {
                    stock_type: stock_type,
                    product_name: product_name,
                    quantity: quantity,
                    description: description,
                    created_at: created_at,
                    user_name: user_name,
                };

                $.pjax({
                    url: window.location.pathname + '?' + $.param(queryParams),
                    container: '#product_stock_table_body',
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
                    container: '#product_stock_table_body',
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
                    container: '#product_stock_table_body',
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

        handleStoreProductStockEvent() {
            $('#importExportModal .save_stock').on('click',  (e) => {
                e.preventDefault();
                $('#importExportModal .modal-body').find('.alert').remove();

                if (!this.checkProductInStock()) {
                    const elm = document.createElement('div');
                    elm.classList.add('alert', 'alert-danger');
                    elm.innerHTML = 'Số lượng xuất kho đã vượt quá mức, vui lòng kiểm tra lại';
                    $('#importExportModal .modal-body').prepend(elm);
                    return;
                }

                const form = $('form[name=importExportForm]');
                if (!$(form).valid()) return false;

                var formData = $(form).serialize();
                console.log(formData);
                var url = $(event.target).attr('action');

                this.onProcess();
                $.ajax({
                    type: 'POST',
                    url: '/product_stock/store',
                    data: formData,
                    dataType: 'json',
                    success: (response) => {
                        this.onProcess();
                        console.log(response);
                        window.location.reload();
                    },
                    error: () => {
                        this.offProcess();
                    }
                });
            });
        }

        checkProductInStock() {
            let checkedProductInStock = false;
            const productDataJson = $('.product-info input[name=product_info_data]').val();
            const productData = JSON.parse(productDataJson);
            const currentQuantity = parseFloat($('#importExportModal [name=quantity]').val());
            const stockType = $('#importExportModal select[name=stock_type]').val();

            if (stockType == 'import' || (productData['quantity'] > 1 && currentQuantity <= productData['quantity'])) {
                checkedProductInStock = true;
            }

            return checkedProductInStock;
        }

        handleChangeProductFormEvent() {
            $('[name=product_id]').on('change',  (event) => {
                event.preventDefault();
                this.onProcess();
                $.ajax({
                    type: 'POST',
                    url: '/product_stock/getProductInfo',
                    data: {
                        product_id: $(event.currentTarget).val()
                    },
                    dataType: 'json',
                    success: ({ data, message }) => {
                        this.offProcess();
                        $('.product-info .product-name span').empty().html(data['product_name']);
                        $('.product-info .product-quantity span').empty().html(data['quantity_format']);
                        $('.product-info input[name=product_info_data]').val(JSON.stringify(data));
                        $('.product-info').removeClass('d-none');
                    },
                    error: ({ responseJSON }) => {
                        this.offProcess();
                        alert(responseJSON['message']);
                    }
                });
            })
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

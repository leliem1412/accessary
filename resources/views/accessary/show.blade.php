@extends('app')

@section('content')
    {{-- <h1 class="page-header text-center">Phần mềm quản lý phụ tùng</h1> --}}
    <div class="row">
        <div class="col-md-12 col-md-offset-1 d-flex justify-content-between align-items-center mb-4">
            <h2>Danh sách phụ tùng</h2>
            <div class="d-flex align-items-center" style="gap: 10px">
                <button type="button" id="btnExport" class="btn btn-primary pull-right">Xuất excel</button>
                <button type="button" id="add" data-bs-toggle="modal" data-bs-target="#addnew"
                    class="btn btn-primary pull-right">Thêm phụ tùng</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <table class="table table-bordered table-responsive table-striped">
                <thead>
                    <th>#</th>
                    <th>Tên phụ tùng</th>
                    <th>Giá</th>
                    <th>Số lượng nhập</th>
                    <th>Số lượng xuất</th>
                    <th>Số lượng tồn</th>
                    <th>Mức min</th>
                    <th>Nhà cung cấp</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </thead>
                <tbody id="memberBody">
                </tbody>

            </table>
        </div>
    </div>
@endsection

@include('accessary/modal')

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            showMember();

            // Sự kiện thêm phụ tùng
            $(document).on('click', '#add', function() {
                $.get("{{ URL::to('supplier/getList') }}", function(res) {
                    let optionOutput = '';
                    res.forEach(elm => {
                        optionOutput += `<option value="${elm?.id}">${elm?.name}</option>`
                    });
                    $("select[name='supplierId']").html(optionOutput);
                })
            })
            $('#addForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this).serialize();
                var url = $(this).attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form,
                    dataType: 'json',
                    success: function() {
                        Swal.fire(
                            'Tạo mới thành công!',
                            'Phụ tùng đã được tạo!',
                            'success',
                        )
                        showMember();
                        $('#addnew').modal('hide');
                        $('#addForm')[0].reset();
                    }
                });
            });

            // Sự kiện xuất kho
            $(document).on('click', '.editQuanityExport', async function(e) {
                e.preventDefault();
                const dataTable = $('table').rows().data();
                console.log('dataTable:', dataTable)
                const id = $(this).data('id');
                const data = await getDetail(id);

                $('#editExportQuantitymodal').modal('show');
                $('#editExportQuantitymodal #accessaryId').val(data?.accessary?.id)
                $('#editExportQuantitymodal input[name="name"]').val(data?.accessary?.name)
                $('#editExportQuantitymodal input[name="quantityStock"]').val(data?.accessary
                    ?.quantityStock)
            })
            $('#editExportForm').on("submit", function(e) {
                e.preventDefault();
                const form = $(this).serialize();
                var url = $(this).attr('action');
                $.post(url, form, function(data) {
                    console.log('data:', data);
                    !!data?.status ? Swal.fire({
                        icon: 'success',
                        title: data?.msg,
                    }) : Swal.fire({
                        icon: 'error',
                        title: data?.msg,
                    })
                    $('#editExportForm')[0].reset();
                    $('#editExportQuantitymodal').modal('hide');
                    showMember();
                })
            })

            // Sự kiện nhập kho
            $(document).on('click', '.editQuanityImport', async function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const data = await getDetail(id);

                $('#editImportQuantitymodal').modal('show');
                $('#editImportQuantitymodal #accessaryId').val(data?.accessary?.id)
                $('#editImportQuantitymodal input[name="name"]').val(data?.accessary?.name)
                $('#editImportQuantitymodal input[name="quantityStock"]').val(data?.accessary
                    ?.quantityStock)
            })
            $('#editImportForm').on("submit", function(e) {
                e.preventDefault();
                const form = $(this).serialize();
                var url = $(this).attr('action');
                $.post(url, form, function(data) {
                    console.log('data:', data);
                    !!data?.status ? Swal.fire({
                        icon: 'success',
                        title: data?.msg,
                    }) : Swal.fire({
                        icon: 'error',
                        title: data?.msg,
                    })
                    $('#editImportForm')[0].reset();
                    $('#editImportQuantitymodal').modal('hide');
                    showMember();
                })
            })

            // Sự kiện update phụ tùng
            $(document).on('click', '.edit', async function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                const data = await getDetail(id);

                $('#editmodal').modal('show');
                let optionOutput = '';
                data?.supplier?.forEach(elm => {
                    optionOutput += `<option value="${elm?.id}">${elm?.name}</option>`
                });
                $(`#supplierId`).html(optionOutput);
                $('#name').val(data?.accessary?.name);
                $('#price').val(data?.accessary?.price);
                $('#quantityImport').val(data?.accessary?.quantityImport);
                $('#quantityMin').val(data?.accessary?.quantityMin);
                $('#supplierId').val(data?.accessary?.supplier_id);
                $('#accessaryId').val(id);
            });
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this).serialize();
                var url = $(this).attr('action');
                $.post(url, form, function(data) {
                    $('#editmodal').modal('hide');
                    Swal.fire(
                        'Cập nhật thành công!',
                        'Phụ tùng đã được cập nhật!',
                        'success',
                    )
                    showMember();
                })
            });

            // Sự kiện xoá phụ tùng
            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                $('#deletemodal').modal('show');
                $('#deletemember').val(id);
            });

            $('#deletemember').click(function() {
                var id = $(this).val();
                $.post("{{ URL::to('delete') }}", {
                    id: id
                }, function() {
                    $('#deletemodal').modal('hide');
                    Swal.fire(
                        'Xoá thành công!',
                        'Phụ tùng đã được xoá!',
                        'success',
                    )
                    showMember();
                })
            });


            // Xuất file excel danh sách phụ tùng
            $('#btnExport').click(function() {
                var id = $(this).val();
                window.open('/export-excel');
            });

        });
        // Utility function
        function showMember() {
            $.get("{{ URL::to('show') }}", function(data) {
                let table = $('table').DataTable();
                table.destroy();
                $('#memberBody').empty().html(data);
                table = $('table').DataTable({
                    scrollY: 400,
                    columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: 0,
                    }, ],
                    order: [7, 'desc'],
                });
                table.on('order.dt search.dt', function() {
                    let i = 1;

                    table.cells(null, 0, {
                        search: 'applied',
                        order: 'applied'
                    }).every(function(cell) {
                        this.data(i++);
                    });
                }).draw();
            });
        }

        async function getDetail(accessoryId) {
            try {
                const response = await $.get("{{ URL::to('detail') }}", {
                    id: accessoryId
                })
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        }
    </script>
@endsection

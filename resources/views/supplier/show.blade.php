@extends('app')

@section('content')
    {{-- <h1 class="page-header text-center">Phần mềm quản lý phụ tùng</h1> --}}
    <div class="row">
        <div class="col-md-12 col-md-offset-1 d-flex justify-content-between align-items-center mb-4">
            <h2>Danh sách nhà cung cấp</h2>
            <button type="button" id="add" data-bs-toggle="modal" data-bs-target="#addnew"
                class="btn btn-primary pull-right">Thêm nhà cung cấp</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <table id="mainTable" class="table table-bordered table-responsive table-striped">
                <thead>
                    <th>#</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </thead>
                <tbody id="memberBody">
                </tbody>

            </table>
        </div>
    </div>
@endsection

@include('supplier/modal')

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            showMember();

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
                            'Nhà sản xuất đã được tạo!',
                            'success',
                        )
                        $('#addnew').modal('hide');
                        $('#addForm')[0].reset();
                        showMember();
                    }
                });
            });

            $(document).on('click', '.edit', async function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                const data = await getDetail(id);
                $('#editmodal').modal('show');
                $('#name').val(data?.name);
                $('#description').val(data?.description);
                $('#supplierId').val(id);
            });

            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                $('#deletemodal').modal('show');
                $('#deletemember').val(id);
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this).serialize();
                var url = $(this).attr('action');
                $.post(url, form, function(data) {
                    Swal.fire(
                        'Cập nhật thành công!',
                        'Nhà sản xuất đã được cập nhật!',
                        'success',
                    )
                    $('#editmodal').modal('hide');
                    showMember();
                })
            });

            $('#deletemember').click(function() {
                var id = $(this).val();
                $.post("{{ URL::to('supplier/delete') }}", {
                    id: id
                }, function() {
                    Swal.fire(
                        'Xoá thành công!',
                        'Nhà sản xuất đã được xoá!',
                        'success',
                    )
                    $('#deletemodal').modal('hide');
                    showMember();
                })
            });

        });

        function showMember() {
            $.get("{{ URL::to('supplier/show') }}", function(data) {
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
                    order: [2, 'desc'],
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
            })
        }

        async function getDetail(accessoryId) {
            try {
                const response = await $.get("{{ URL::to('supplier/detail') }}", {
                    id: accessoryId
                })
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        }
    </script>
@endsection

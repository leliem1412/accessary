<!-- Add Modal -->
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Thêm nhà cung cấp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('supplier/save') }}" id="addForm">
                    <div class="mb-3">
                        <label for="name">Tên nhà cung cấp</label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập tên nhà cung cấp"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" placeholder="Nhập mô tả" style="height: 100px"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Chỉnh sửa phụ tùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('supplier/update') }}" id="editForm">
                    <input type="hidden" id="supplierId" name="id">
                    <div class="mb-3">
                        <label for="name">Tên nhà cung cấp</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Nhập tên nhà cung cấp" required>
                    </div>
                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả" style="height: 100px"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-success">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Xoá phụ tùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-center">Bạn có chắc chắn muốn xoá thông tin phụ tùn này không?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button type="button" id="deletemember" class="btn btn-danger">Xoá</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Thêm phụ tùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('save') }}" id="addForm">
                    <div class="mb-3">
                        <label for="name">Tên phụ tùng</label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập tên phụ tùng"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="price">Giá</label>
                        <input type="number" name="price" class="form-control" placeholder="Nhập giá" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityImport">Số lượng</label>
                        <input type="number" name="quantityImport" class="form-control" placeholder="Nhập số lượng"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityMin">Mức min</label>
                        <input type="number" name="quantityMin" class="form-control" placeholder="Nhập mức min"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierId">Nhà cung cấp</label>
                        <select name="supplierId" data-dependent="supplier" class="form-control input-lg dynamic">
                            <option value="">Chọn nhà cung cấp</option>
                        </select>
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
                <form action="{{ URL::to('update') }}" id="editForm">
                    <input type="hidden" id="accessaryId" name="id">
                    <div class="mb-3">
                        <label for="name">Tên phụ tùng</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Nhập tên phụ tùng" required>
                    </div>
                    <div class="mb-3">
                        <label for="price">Giá</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="Nhập giá"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityImport">Số lượng</label>
                        <input disabled type="number" name="quantityImport" id="quantityImport" class="form-control"
                            placeholder="Nhập số lượng" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityMin">Mức min</label>
                        <input type="number" name="quantityMin" id="quantityMin" class="form-control"
                            placeholder="Nhập mức min" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierId">Nhà cung cấp</label>
                        <select name="supplierId" data-dependent="supplier" id="supplierId"
                            class="form-control input-lg dynamic">
                            <option value="">Chọn nhà cung cấp</option>
                        </select>
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
                <h4 class="text-center">Bạn có chắc chắn muốn xoá thông tin phụ tùng này không?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button type="button" id="deletemember" class="btn btn-danger">Xoá</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Export Quantity Modal -->
<div class="modal fade" id="editExportQuantitymodal" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Xuất kho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('updateQuantityExport') }}" id="editExportForm">
                    <input type="hidden" id="accessaryId" name="id">
                    <div class="mb-3">
                        <label for="name">Tên phụ tùng</label>
                        <input disabled type="text" name="name" class="form-control"
                            placeholder="Nhập tên phụ tùng" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityExport">Số lượng tồn</label>
                        <input disabled type="number" name="quantityStock" class="form-control"
                            placeholder="Nhập số lượng tồn" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityExport">Số lượng xuất</label>
                        <input type="number" name="quantityExport" class="form-control" placeholder="Nhập số lượng"
                            required>
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

<!-- Edit Import Quantity Modal -->
<div class="modal fade" id="editImportQuantitymodal" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Nhập kho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('updateQuantityImport') }}" id="editImportForm">
                    <input type="hidden" id="accessaryId" name="id">
                    <div class="mb-3">
                        <label for="name">Tên phụ tùng</label>
                        <input disabled type="text" name="name" class="form-control"
                            placeholder="Nhập tên phụ tùng" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityExport">Số lượng tồn</label>
                        <input disabled type="number" name="quantityStock" class="form-control"
                            placeholder="Nhập số lượng tồn" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantityImport">Số lượng nhập</label>
                        <input type="number" name="quantityImport" class="form-control" placeholder="Nhập số lượng"
                            required>
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

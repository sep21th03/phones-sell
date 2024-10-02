<div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addColorModalLabel">Thêm Màu Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addColorForm">
                    <input type="text" class="form-control" id="addproductID" value="{{ $product->id }}" hidden>
                    <input type="text" class="form-control" id="addromID" value="{{ isset($product->variants[0]) ? $product->variants[0]->rom_id : '' }}" hidden>
                    <div class="mb-3">
                        <label for="colorName" class="form-label">Tên Màu</label>
                        <input type="text" class="form-control" id="colorName" required>
                    </div>
                    <div class="mb-3">
                        <label for="colorPickerInput" class="form-label">Chọn Màu</label>
                        <input type="text" id="colorPickerInput" class="form-control mb-3" value="#000000">
                        <div id="colorPicker"></div>
                    </div>
                    <div class="mb-3">
                        <label for="pricePhone" class="form-label">Giá tiền</label>
                        <input type="text" class="form-control" id="pricePhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="stockPhone" class="form-label">Số lượng</label>
                        <input type="text" class="form-control" id="stockPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="imageUpload" class="form-label">Chọn Ảnh</label>
                        <input type="file" class="form-control" id="imageUpload" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="submitColor">Lưu</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#submitColor").click(function() {
            let color = $("#colorName").val();
            let color_code = $("#colorPickerInput").val();
            let price = parseInt(
                $("#pricePhone").val().replace(/\./g, "").replace(" ₫", "")
            );
            let stock = $("#stockPhone").val();
            let image_url = $("#imageUpload")[0].files[0];
            let product_id = $("#addproductID").val();
            let rom_id = $("#addromID").val();
            let availability = stock > 0 ? 1 : 0;

            if (!image_url) {
                swal("Cảnh báo!", "Vui lòng chọn ảnh!", "warning");
                return;
            }

            var formData = new FormData();
            formData.append("color", color);
            formData.append("color_code", color_code);
            formData.append("price", price);
            formData.append("stock", stock);
            formData.append("image_url", image_url);
            formData.append("product_id", product_id);
            formData.append("rom_id", rom_id);
            formData.append("availability", availability);

            $.ajax({
                url: "{{ route('product.addColor') }}",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "Thành công!",
                        text: "Thêm màu thành công!",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    $("#colorName").val("");
                    $("#colorPickerInput").val("#000000");
                    $("#pricePhone").val("");
                    $("#stockPhone").val("");
                    $("#imageUpload").val(null);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: error.message || "Có lỗi xảy ra, vui lòng thử lại!",
                    });
                },
            });
        });
    });
</script>
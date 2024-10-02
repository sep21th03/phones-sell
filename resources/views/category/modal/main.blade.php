<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm loại sản phẩm</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="addInputCategory" class="form-label">Tên loại</label>
                        <input type="text" name="name" class="form-control" id="addInputCategory" aria-describedby="emailHelp">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" name="submit_add_category" class="btn btn-primary">Thêm</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sửa loại sản phẩm</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editInputCategory" class="form-label">Tên loại</label>
                        <input type="text" name="name_edit" class="form-control" id="editInputCategory" aria-describedby="emailHelp">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" name="submit_edit_category" class="btn btn-primary">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<script>
    function open_modal_edit_category(id) {
        var table = $("#list_category").DataTable();
        var rowData = table.row(`[id="${id}"]`).data();
        document.getElementById("editInputCategory").value = rowData.name;
        document.getElementById("editCategory").setAttribute("data-id", id);

        const modal = new bootstrap.Modal(document.getElementById("editCategory"));
        modal.show();
    }

    document
        .querySelector('button[name="submit_add_category"]')
        .addEventListener("click", function() {
            let name = document.querySelector('input[name="name"]').value;
            let csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            this.innerHTML = "Vui lòng chờ...";
            this.disabled = true;

            fetch("{{ route('category.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        name: name,
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                    var table = $("#list_category").DataTable();
                    table.row
                        .add({
                            name: data.data.name,
                            created_at: data.data.created_at,
                            updated_at: data.data.updated_at,
                            id: data.data.id,
                        })
                        .draw();
                    document.getElementById('addInputCategory').value = "";
                    Swal.fire({
                        icon: "success",
                        title: "Thành công!",
                        text: "Danh mục đã được thêm thành công!",
                    });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Thất bại!",
                            text: data.message,
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: error.message || "Có lỗi xảy ra, vui lòng thử lại!",
                    });
                })
                .finally(() => {
                    this.innerHTML = "Thêm";
                    this.disabled = false;
                });
        });



    document.querySelector('button[name="submit_edit_category"]').addEventListener("click", function() {
        let updateName = document.querySelector('input[name="name_edit"]').value;
        let updateId = document.getElementById("editCategory").getAttribute("data-id");
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        this.innerHTML = "Vui lòng chờ...";
        this.disabled = true;

        fetch("{{ route('category.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    name: updateName,
                    id: updateId,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Thành công!",
                        text: "Cập nhật danh mục thành công!",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    var table = $("#list_category").DataTable();
                    var rowExists = table.row(`[id="${updateId}"]`).data();
                    if (rowExists) {
                        table.row(`[id="${updateId}"]`).data({
                            name: data.data.name,
                            created_at: data.data.created_at,
                            updated_at: data.data.updated_at,
                            id: data.data.id,
                        }).draw();
                        document.getElementById('editInputCategory').value = "";
                    } else {
                        console.error("Hàng không tồn tại để cập nhật");
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Thất bại!",
                        text: data.message || "Có lỗi xảy ra, vui lòng thử lại!",
                    })
                }
            })
            .catch(error => {
                console.error("Error:", error);
            })
            .finally(() => {
                this.innerHTML = "Sửa";
                this.disabled = false;
            });
    });
</script>
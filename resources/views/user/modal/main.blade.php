<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sửa thông tin người dùng</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editInputUser" class="form-label">Tên người dùng</label>
                        <input type="text" name="name_edit" class="form-control" id="editInputUserName" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="editInputUser" class="form-label">Email</label>
                        <input type="text" name="email_edit" class="form-control" id="editInputUserEmail" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="editInputUser" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone_edit" class="form-control" id="editInputUserPhone" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="editInputUser" class="form-label">Phân quyền</Q></label>
                        <input type="text" name="role_edit" class="form-control" id="editInputUserRole" aria-describedby="emailHelp">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" name="submit_edit_user" class="btn btn-primary">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
<script>
    function open_modal_edit_user(id) {
        var table = $("#list_user").DataTable();
        var rowData = table.row(`[id="${id}"]`).data();
        document.getElementById("editInputUserName").value = rowData.name;
        document.getElementById("editInputUserEmail").value = rowData.email;
        document.getElementById("editInputUserPhone").value = rowData.phone;
        document.getElementById("editInputUserRole").value = rowData.roles;
        document.getElementById("editUser").setAttribute("data-id", id);
        const modal = new bootstrap.Modal(document.getElementById("editUser"));
        modal.show();
    }

    document.querySelector('button[name="submit_edit_user"]').addEventListener("click", function() {
        let updateName = document.querySelector('input[name="name_edit"]').value;
        let updateEmail = document.querySelector('input[name="email_edit"]').value;
        let updatePhone = document.querySelector('input[name="phone_edit"]').value;
        let updateRole = document.querySelector('input[name="role_edit"]').value;
        let updateId = document.getElementById("editUser").getAttribute("data-id");
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        this.innerHTML = "Vui lòng chờ...";
        this.disabled = true;

        fetch("{{ route('user.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    name: updateName,
                    email: updateEmail,
                    phone: updatePhone,
                    role: updateRole,
                    id: updateId,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Thành công!",
                        text: "Cập nhật tài khoản người dùng thành công!",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    var table = $("#list_user").DataTable();
                    var rowExists = table.row(`[id="${updateId}"]`).data();
                    if (rowExists) {
                        table.row(`[id="${updateId}"]`).data({
                            name: data.data.name,
                            email: data.data.email,
                            phone: data.data.phone,
                            role: data.data.role,
                            created_at: data.data.created_at,
                            updated_at: data.data.updated_at,
                            id: data.data.id,
                        }).draw();
                    } else {
                        console.error("Tài khoản không tồn tại để cập nhật");
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
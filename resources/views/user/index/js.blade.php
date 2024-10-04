<script>
    $(document).ready(function() {
        if ($("#list_user").length) {
            $("#list_user").DataTable({
                ajax: {
                    url: "{{ route('user.index') }}",
                    type: "get",
                    dataSrc: "data",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Error get data from ajax");
                    },
                },
                columns: [{
                        data: "id",
                        render: function(data, type, row) {
                            return `<div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='${JSON.stringify(
                                        row
                                    )}' />
                                </div>`;
                        },
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "phone"
                    },
                    {
                        data: "role",
                        render: function(data, type, row) {
                            return row.role == 1? "Quản trị viên" : "Người dùng";
                        }
                    },
                    {
                        data: "created_at",
                        render: function(data, type, row) {
                            return convertToVietnamTime(data);
                        }
                    },
                    {
                        data: "updated_at",
                        render: function(data, type, row) {
                            return convertToVietnamTime(data);
                        }
                    },
                    {
                        data: "id"
                    },
                    {
                    data: "role", 
                    visible: false,
                    render: function(data, type, row) {
                        return row.role == 1 ? 1 : 0;
                    }
                }
                ],
                columnDefs: [{
                    targets: 7,
                    render: function(data, type, row) {
                        return (
                            '<button type="button" class="btn btn-primary" onclick="open_modal_edit_user(' +
                            data +
                            ')">Sửa</button> <button type="button" class="btn btn-danger" onclick="delete_user(' +
                            data +
                            ')">Xóa</button>'
                        );
                    },
                    className: "my-class",
                }, ],
                rowId: "id",
                language: {
                    lengthMenu: "Hiện thị _MENU_ loại sản phẩm mỗi trang",
                    zeroRecords: "Không tìm thấy dữ liệu phù hợp",
                    info: "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ nguồn dữ liệu",
                    infoEmpty: "Không hiển thị dữ liệu",
                    infoFiltered: "(được lọc từ tổng số _MAX_ nguồn dữ liệu)",
                    search: "Tìm kiếm:",
                    paginate: {
                        first: "Đầu",
                        last: "Cuối",
                        next: "Tiếp",
                        previous: "Trước",
                    },
                },
                order: [
                    [8, "desc"]
                ],
            });
        }
    });

    function convertToVietnamTime(dateString) {
        const date = new Date(dateString);
        const vietnamFormatter = new Intl.DateTimeFormat('vi-VN', {
            timeZone: 'Asia/Ho_Chi_Minh',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        return vietnamFormatter.format(date);
    }
</script>
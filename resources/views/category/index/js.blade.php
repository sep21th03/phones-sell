<script>
    $(document).ready(function() {
        if ($("#list_category").length) {
            $("#list_category").DataTable({
                dom: 'rtp',
                initComplete: function() {
                    var api = this.api();
                    $('#searchInput').on('input', function() {
                        api.search(this.value).draw();
                    });
                },
                ajax: {
                    url: "{{ route('category.index') }}",
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
                        data: "name"
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
                ],
                columnDefs: [{
                    targets: 3,
                    render: function(data, type, row) {
                        return (
                            '<button type="button" class="btn btn-primary" onclick="open_modal_edit_category(' +
                            data +
                            ')">Sửa</button> <button type="button" class="btn btn-danger" onclick="delete_category(' +
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
                // processing: true,
                order: [
                    [0, "asc"]
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

    function delete_category(categoryId) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: false,
        });

        swalWithBootstrapButtons
            .fire({
                title: "Bạn có chắc chắn xóa loại sản phẩm này?",
                text: "Bạn sẽ không thể khôi phục lại!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Có, xóa nó!",
                cancelButtonText: "Không, hủy!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire({
                        title: "Đang xóa...",
                        timer: 2000,
                        timerProgressBar: true,
                    });

                    fetch("{{ route('category.destroy') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            body: JSON.stringify({
                                id: categoryId,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.status === "success") {
                                var table = $("#list_category").DataTable();
                                table.row(`#${categoryId}`).remove().draw();
                                swalWithBootstrapButtons.fire({
                                    title: "Đã xóa!",
                                    text: "Loại sản phẩm của bạn đã được xóa.",
                                    icon: "success",
                                });
                            } else {
                                swalWithBootstrapButtons.fire({
                                    title: "Xóa thất bại!",
                                    text: "Không thể xóa loại sản phẩm!",
                                    icon: "error",
                                });
                            }
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Đã hủy",
                        text: "Loại sản phẩm của bạn vẫn an toàn :)",
                        icon: "error",
                    });
                }
            });
    }
</script>
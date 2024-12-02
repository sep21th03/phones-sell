<script>
    $(document).ready(function() {
        if ($("#list_user").length) {
            $("#list_user").DataTable({
                dom: 'rtp',
                initComplete: function() {
                    var api = this.api();
                    $('#searchInput').on('input', function() {
                        api.search(this.value).draw();
                    });
                },
                ajax: {
                    url: "{{ route('user.index') }}",
                    type: "get",
                    dataSrc: function(json) {
                        return json.data;
                    },
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Error getting data from ajax");
                    },
                },
                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="d-flex justify-content-start align-items-center">
                <img class="rounded-circle" src="${row.avt_url}" alt="${row.name}" style="width: 30px; height: 30px;" />
                <h6 class="mb-0 ms-3 text-body">${row.name}</h6>
            </div>`;
                        }
                    },

                    {
                        data: "email",
                        render: function(data, type, row) {
                            return `<span class="float-start">${data}</span>`;
                        }
                    },
                    {
                        data: "phone",
                        render: function(data, type, row) {
                            return `<span class="float-start">${data}</span>`;
                        }
                    },
                    {
                        data: "roles",
                        render: function(data, type, row) {
                            return data ? data : 'No role';
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
                        data: "id",
                        render: function(data) {
                            return `
                            <div class="btn-reveal-trigger position-relative">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window">
                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="#" onclick="open_modal_edit_user(${data})">Sửa</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#!" onclick="delete_user(${data})">Xóa</a>
                                </div>
                            </div>`;
                        },
                    }
                ],
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
                    [0, "desc"]
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

    function delete_user(userId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Bạn sẽ không thể hoàn tác hành động này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý, xóa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('user.destroy') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: userId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Đã xóa!',
                                response.message,
                                'success'
                            );
                            $('#list_user').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'Lỗi!',
                                'Có lỗi xảy ra khi xóa người dùng.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Lỗi!',
                            'Có lỗi xảy ra khi xóa người dùng.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>

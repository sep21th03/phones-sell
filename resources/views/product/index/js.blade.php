<script>
    $(document).ready(function() {
        let base_url = window.location.origin;
        if ($("#list_product").length) {
            $("#list_product").DataTable({
                dom: 'rtpl',
                initComplete: function() {
                    var api = this.api();
                    $('#searchInput').on('input', function() {
                        api.search(this.value).draw();
                    });
                    var lengthDiv = $('#list_product_length');
                    lengthDiv.html(`
                <label>Hiển thị
                    <select name="list_product_length" aria-controls="list_product" class="form-select form-select-sm w-25">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> 
                sản phẩm / trang</label>
            `);
                },
                ajax: {
                    url: " {{ route('product.index') }}",
                    type: "get",
                    dataSrc: "data",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
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
                        data: null,
                        render: function(data, type, row) {
                            let html = "";
                            if (row.variants && row.variants.length > 0) {
                                row.variants.forEach((variant) => {
                                    if (
                                        variant.images &&
                                        variant.images.length > 0
                                    ) {
                                        for (
                                            let i = 0; i < Math.min(3, variant.images.length); i++
                                        ) {
                                            html += `
                                            <td class="text-center">
                                                <img src="${base_url}/${variant.images[i].image_url}" alt="${row.title}" style="width: 50px; height: auto;">
                                            </td>
                                        `;
                                        }
                                    } else {
                                        html +=
                                            '<td class="text-center">Không có hình ảnh</td>';
                                    }
                                });
                            } else {
                                html +=
                                    '<td class="text-center">Không có hình ảnh</td>';
                            }
                            return html;
                        },
                    },
                    {
                            data: "title",
                            render: function(data, type, row) {
                                const productId = row.id; 
                                return `<a class="fw-semibold line-clamp-3 mb-0" href="{{ route('product.detail', '') }}/${productId}">${data}</a>`;
                            },
                    },
                    {
                        data: "category_name"
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let html = "";
                            if (row.variants && row.variants.length > 0) {
                                html += `<span class="badge bg-primary">${row.variants[0].rom.capacity}</span>`;
                            } else {
                                html +=
                                    '<span class="badge bg-secondary">Không có</span>';
                            }
                            return html;
                        },
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
                                    <a class="dropdown-item" href="/product/${data}">Xem chi tiết</a>
                                    <a class="dropdown-item" href="#!" onclick="exportProduct(${data})">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#!" onclick="removeProduct(${data})">Xóa</a>
                                </div>
                            </div>`;
                        },
                    },
                ],
                rowId: "id",
                language: {
                    lengthMenu: "Hiện thị _MENU_ sản phẩm mỗi trang",
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
            });
        }

        $("#addBtnProduct").click(function() {
            window.location.href = "{{ route('product.add') }}";
        });

        $("#checkbox-bulk-products-select").on("change", function() {
            let isChecked = $(this).is(":checked");

            $("#products-table-body input.form-check-input").prop(
                "checked",
                isChecked
            );
        });

        $('#category-filter').on('change', function() {
            table.ajax.reload();
        });

    });

    function removeProduct(productID) {
        Swal.fire({
            title: "Xác nhận xóa",
            text: "Bạn có chắc muốn xóa sản phẩm này?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('product.destroy') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: {
                        id: productID
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            icon: "success",
                            title: "Xóa thành công",
                            text: "Sản phẩm đã được xóa!",
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => {
                            $("#list_product tr").each(function() {
                                let trID = parseInt($(this).attr("id"));
                                if (trID === productID) {
                                    $(this).remove();
                                }
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi",
                            text: error.responseJSON?.message ||
                                "Có lỗi xảy ra, vui lòng thử lại!",
                        });
                    },
                });
            }
        });
    }

    function deleteSelectedProducts() {
        let selectedProductIds = [];

        $("input.form-check-input:checked").each(function() {
            let row = $(this).data("bulk-select-row");

            if (row && row.id) {
                selectedProductIds.push(row.id);
            }
        });

        if (selectedProductIds.length > 0) {
            Swal.fire({
                title: "Xác nhận xóa",
                text: "Bạn có chắc muốn xóa các sản phẩm này?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('product.deleteProducts') }}",
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: {
                            ids: selectedProductIds
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Xóa thành công",
                                text: "Các sản phẩm đã được xóa!",
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => {
                                selectedProductIds.forEach((id) => {
                                    $(`#list_product tr[id="${id}"]`).remove();
                                });
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            Swal.fire({
                                icon: "error",
                                title: "Lỗi",
                                text: xhr.responseJSON?.message ||
                                    "Có lỗi xảy ra, vui lòng thử lại!",
                            });
                        },
                    });
                }
            });
        } else {
            Swal.fire({
                icon: "warning",
                title: "Không có sản phẩm nào được chọn",
                text: "Vui lòng chọn ít nhất một sản phẩm để xóa.",
            });
        }
    }

    function exportToExcel() {
        const rows = [];
        const table = document.getElementById('list_product');

        const headers = ['Tên Sản Phẩm', 'Dung Lượng', 'Hãng'];
        rows.push(headers);

        const bodyRows = table.querySelectorAll('tbody tr');
        bodyRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                const name = cells[2].innerText;
                const capacity = cells[4].innerText;
                const category = cells[3].innerText;
                rows.push([name, capacity, category]);
            }
        });

        const ws = XLSX.utils.aoa_to_sheet(rows);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, ws, 'Products');

        const excelFileName = 'Products_Data.xlsx';

        XLSX.writeFile(workbook, excelFileName);

    }


    function exportProduct(productId) {
        const base_url = window.location.origin;
        fetch(`{{ route('product.show', '') }}/${productId}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const headers = [
                    'Tên Sản Phẩm', 'Dung Lượng', 'Hãng', 'Kích thước màn hình',
                    'Công nghệ màn hình', 'Độ phân giải màn hình', 'Dung lượng RAM',
                    'Khe cắm thẻ nhớ', 'Thẻ SIM', 'Hệ điều hành', 'Wi-Fi',
                    'Bluetooth', 'Camera trước', 'Camera sau', 'Pin',
                    'Công nghệ sạc', 'Chipset', 'Kích thước', 'Trọng lượng'
                ];

                const specifications = data.data.specifications || {};
                const variant = data.data.variants[0] || {};
                const rom = variant.rom || {};

                const rowData = [
                    data.data.title || '',
                    rom.capacity || '',
                    specifications.screen_size || '',
                    specifications.screen_type || '',
                    specifications.screen_resolution || '',
                    specifications.ram || '',
                    specifications.memory_card_slot || 'Không',
                    specifications.sim || '',
                    specifications.operating_system || '',
                    specifications.connectivity || '',
                    specifications.bluetooth || '',
                    specifications.camera_front || '',
                    specifications.camera_rear || '',
                    specifications.battery || '',
                    specifications.pin || '',
                    specifications.chip || '',
                    specifications.dimensions || '',
                    specifications.weight || ''
                ];

                const ws = XLSX.utils.aoa_to_sheet([headers, rowData]);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Product Data");

                const excelBuffer = XLSX.write(wb, {
                    bookType: 'xlsx',
                    type: 'array'
                });
                saveExcelFile(excelBuffer, `${data.data.title}.xlsx`);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while exporting the product data.');
            });
    }

    function saveExcelFile(buffer, fileName) {
        const data = new Blob([buffer], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(data);
        link.download = fileName;
        link.click();
    }
</script>
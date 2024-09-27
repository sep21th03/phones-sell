$(document).ready(function () {
    let base_url = window.location.origin;
    if ($("#list_product").length) {
        $("#list_product").DataTable({
            ajax: {
                url: "/api/product/get/product",
                type: "POST",
                dataSrc: "data",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                },
            },
            columns: [
                {
                    data: "id",
                    render: function (data, type, row) {
                        return `<div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='${JSON.stringify(
                                        row
                                    )}' />
                                </div>`;
                    },
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        let html = "";
                        if (row.variants && row.variants.length > 0) {
                            row.variants.forEach((variant) => {
                                if (variant.images && variant.images.length > 0) {
                                    for (let i = 0; i < Math.min(3, variant.images.length); i++) {
                                        html += `
                                            <td class="text-center">
                                                <img src="${base_url}/${variant.images[i].image_url}" alt="${row.title}" style="width: 50px; height: auto;">
                                            </td>
                                        `;
                                    }
                                } else {
                                    html += '<td class="text-center">Không có hình ảnh</td>';
                                }
                            });
                        } else {
                            html += '<td class="text-center">Không có hình ảnh</td>';
                        }
                        return html;
                    },
                },
                {
                    data: "title",
                    render: function (data) {
                        return `<a class="fw-semibold line-clamp-3 mb-0" href="">${data}</a>`;
                    },
                },
                { data: "category_name" },
                {
                    data: null,
                    render: function (data, type, row) {
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
                    render: function (data) {
                        return `
                            <div class="btn-reveal-trigger position-relative">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window">
                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="/admin/product/${data}">Xem chi tiết</a>
                                    <a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#!">Remove</a>
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
});

$(document).ready(function () {
    $("#submitColor").click(function () {
        let color = $("#colorName").val();
        let color_code = $("#colorPickerInput").val();
        let price = $("#pricePhone").val();
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
            url: "/api/product/add/color",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: "Thêm màu thành công!",
                    timer: 1500,
                    showConfirmButton: false,
                });
                $("#addColorModal").modal("hiden");
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: error.message || "Có lỗi xảy ra, vui lòng thử lại!",
                });
            },
        });
    });
});


$(document).ready(function () {
    $("#editBtnProduct").click(function () {
        let formValues = {
            id: $("input[name='edit_id']").val(),
            title: $("input[name='edit_title']").val(),
            info: $("textarea[name='edit_info']").val(),
            description: $("textarea[name='edit_description']").val(),
            category_id: $("select[name='edit_category']").val(),
            discount: $("input[name='edit_discount']").val(),
            specifications_id: $("input[name='edit_specifications_id']").val(),
            screen_size: $("input[name='edit_screen_size']").val(),
            screen_resolution: $("input[name='edit_screen_resolution']").val(),
            screen_type: $("input[name='edit_screen_type']").val(),
            ram: $("input[name='edit_ram']").val(),
            memory_card_slot: $("input[name='edit_memory_card_slot']").val(),
            camera_front: $("input[name='edit_camera_front']").val(),
            camera_rear: $("input[name='edit_camera_rear']").val(),
            sim: $("input[name='edit_sim']").val(),
            operating_system: $("input[name='edit_operating_system']").val(),
            connectivity: $("input[name='edit_connectivity']").val(),
            bluetooth: $("input[name='edit_bluetooth']").val(),
            pin: $("input[name='edit_pin']").val(),
            chip: $("input[name='edit_chip']").val(),
            dimensions: $("input[name='edit_dimensions']").val(),
            weight: $("input[name='edit_weight']").val(),
            rom: $("select[name='edit_rom']").val(),
            color: $("select[name='edit_color']").val(),
            stock: $("input[name='edit_stock']").val(),
            price: parseInt($("input[name='edit_price']").val().replace(/\./g, '').replace(' ₫', '')),
            variant_id: $("select[name='edit_color']").find("option:selected").data("variant_id"),
            rom_id: $("select[name='edit_color']").find("option:selected").data("rom_id"),
            availability: $("input[name='edit_stock']").val() > 0 ? 1 : 0,
            image: $("#file-input")[0].files[0]

        };

        var formData = new FormData();


        for (const key in formValues) {
            formData.append(key, formValues[key]);
        }
        $.ajax({
            url: '/api/product/edit/product',
            type: 'POST',
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: "Thêm danh mục thành công!",
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: error.message || "Có lỗi xảy ra, vui lòng thử lại!",
                });
            }
        });
    });
});


// $(document).ready(function () {
//     $("#editBtnProduct").click(function () {
//         let edit_id = $("input[name='edit_id']").val();
//         let edit_title = $("input[name='edit_title']").val();
//         let edit_info = $("textarea[name='edit_info']").val();
//         let edit_description = $("textarea[name='edit_description']").val();
//         let edit_category = $("select[name='edit_category']").val();
//         let edit_discount = $("input[name='edit_discount']").val();
//         let edit_screen_size = $("input[name='edit_screen_size']").val();
//         let edit_screen_resolution = $("input[name='edit_screen_resolution']").val();
//         let edit_screen_type = $("input[name='edit_screen_type']").val();
//         let edit_ram = $("input[name='edit_ram']").val();
//         let edit_memory_card_slot = $("input[name='edit_memory_card_slot']").val();
//         let edit_camera_front = $("input[name='edit_camera_front']").val();
//         let edit_camera_rear = $("input[name='edit_camera_rear']").val();
//         let edit_sim = $("input[name='edit_sim']").val();
//         let edit_operating_system = $("input[name='edit_operating_system']").val();
//         let edit_connectivity = $("input[name='edit_connectivity']").val();
//         let edit_bluetooth = $("input[name='edit_bluetooth']").val();
//         let edit_battery = $("input[name='edit_battery']").val();
//         let edit_pin = $("input[name='edit_pin']").val();
//         let edit_chip = $("input[name='edit_chip']").val();
//         let edit_dimensions = $("input[name='edit_dimensions']").val();
//         let edit_weight = $("input[name='edit_weight']").val(); 
//         let edit_rom = $("select[name='edit_pin']").val();
//         let edit_color = $("select[name='edit_color']").val();
//         let edit_stock = $("input[name='edit_stock']").val();
//         let edit_price = $("input[name='edit_price']").val();
//         let edit_availability = edit_stock > 0 ? 1 : 0;
//         let files = $("#file-input")[0].files[0];

//         var formData = new FormData();
//         if (files.length > 0) {
//             for (let i = 0; i < files.length; i++) {
//                 formData.append('images[]', files[i]);
//             }
//         }
//         formData.append('id', edit_id);
//         formData.append('title', edit_title);
//         formData.append('info', edit_info);
//         formData.append('description', edit_description);
//         formData.append('category_id', edit_category);
//         formData.append('discount', edit_discount);
//         formData.append('screen_size', edit_screen_size);
//         formData.append('screen_resolution', edit_screen_resolution);
//         formData.append('screen_type', edit_screen_type);
//         formData.append('ram', edit_ram);
//         formData.append('memory_card_slot', edit_memory_card_slot);
//         formData.append('camera_front', edit_camera_front);
//         formData.append('camera_rear', edit_camera_rear);
//         formData.append('sim', edit_sim);
//         formData.append('operating_system', edit_operating_system);
//         formData.append('connectivity', edit_connectivity);
//         formData.append('bluetooth', edit_bluetooth);
//         formData.append('pin', edit_pin);
//         formData.append('chip', edit_chip);
//         formData.append('dimensions', edit_dimensions);
//         formData.append('weight', edit_weight);
//         formData.append('rom', edit_rom);
//         formData.append('color', edit_color);
//         formData.append('price', edit_price);
//         formData.append('availability', edit_availability);
        
//     })
// })
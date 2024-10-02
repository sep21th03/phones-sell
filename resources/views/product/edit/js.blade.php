<script>
    $(document).ready(function() {
        $("#reloadDetalProduct").click(function() {
            location.reload();
        });
        
        $("#addProduct").click(function() {
            window.location.href = "{{ route('product.add') }}"
        });
        // update product

        $("#editBtnProduct").click(function() {
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
                price: parseInt(
                    $("input[name='edit_price']")
                    .val()
                    .replace(/\./g, "")
                    .replace(" ₫", "")
                ),
                variant_id: $("select[name='edit_color']")
                    .find("option:selected")
                    .data("variant_id"),
                rom_id: $("select[name='edit_color']")
                    .find("option:selected")
                    .data("rom_id"),
                availability: $("input[name='edit_stock']").val() > 0 ? 1 : 0,
                image: $("#file-input")[0].files[0],
            };

            var formData = new FormData();

            for (const key in formValues) {
                formData.append(key, formValues[key]);
            }
            $.ajax({
                url: "{{ route('product.update') }}",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Thành công!",
                        text: "Sửa sản phẩm thành công!",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: error.message || "Có lỗi xảy ra, vui lòng thử lại!",
                    });
                },
            });
        });
    })


    function deleteColor($id) {
        Swal.fire({
            title: "Xác nhận xóa",
            text: "Bạn có chắc muốn xóa màu này?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('product.deleteProductColor') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: {
                        id: $id
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Xóa thành công",
                            text: "Màu này đã được xóa!",
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        })
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
    }


    CKEDITOR.replace('editor1', {
        extraPlugins: 'uploadimage',
        filebrowserUploadUrl: "{{ route('ckeditor.upload') }}",
        filebrowserUploadMethod: 'form',
        width: '100%',
        height: 400
    });
    CKEDITOR.replace('editor2', {
        extraPlugins: 'uploadimage',
        filebrowserUploadUrl: "{{ route('ckeditor.upload') }}",
        filebrowserUploadMethod: 'form',
        width: '100%',
        height: 200
    });

    document.addEventListener('DOMContentLoaded', () => {
        const pickr = Pickr.create({
            el: '#colorPicker',
            theme: 'classic',
            swatches: [
                '#FF0000',
                '#00FF00',
                '#0000FF',
                // Bạn có thể thêm nhiều màu ở đây
            ],
            components: {
                preview: true,
                opacity: true,
                hue: true,
                interaction: {
                    hex: true,
                    rgba: true,
                    input: true,
                    clear: true,
                    save: true,
                    close: true,
                }
            }
        });

        // Cập nhật giá trị input khi chọn màu
        pickr.on('change', (color, instance) => {
            const rgbaColor = color.toRGBA().toString();
            const hexColor = color.toHEXA().toString();
            document.getElementById('colorPickerInput').value = hexColor;
        });

        const eyeDropper = new EyeDropper();

        const pickFromScreenButton = document.createElement('button');
        pickFromScreenButton.innerText = 'Pick Color From Screen';
        pickFromScreenButton.onclick = () => {
            eyeDropper.open().then(result => {
                const rgbaColor = `rgba(${result.sRGB[0]}, ${result.sRGB[1]}, ${result.sRGB[2]}, ${result.sRGB[3]})`;
                const hexColor = `#${result.sRGB[0].toString(16).padStart(2, '0')}${result.sRGB[1].toString(16).padStart(2, '0')}${result.sRGB[2].toString(16).padStart(2, '0')}`;
                pickr.setColor(hexColor);
                document.getElementById('colorPickerInput').value = hexColor;
                console.log('Màu đã chọn từ màn hình:', rgbaColor);
            }).catch(err => {
                console.error('Lỗi khi chọn màu:', err);
            });
        };
        document.getElementById('colorPicker').appendChild(pickFromScreenButton);
    });



    const baseURL = "{{ asset('') }}";
    const selectedRomId = parseInt(document.getElementById('rom').value);
    const variants = @json($product -> variants);

    const filteredVariants = variants.filter(variant => variant.rom.id == selectedRomId);

    const colorSelect = document.getElementById('color');
    colorSelect.innerHTML = '';

    filteredVariants.forEach(variant => {
        const option = document.createElement('option');
        option.value = variant.color;
        option.textContent = variant.color;
        option.dataset.price = variant.price;
        option.dataset.image = variant.images[0].image_url;
        option.dataset.stock = variant.stock;
        option.dataset.variant_id = variant.id;
        option.dataset.rom_id = variant.rom_id;
        colorSelect.appendChild(option);
    });
    document.getElementById('price').value = filteredVariants[0].price;
    document.getElementById('stock').value = filteredVariants[0].stock;
    document.getElementById('deleteColor').setAttribute('data-variant', filteredVariants[0].id);

    if (filteredVariants.length > 0) {
        const firstVariant = filteredVariants[0];
        document.getElementById('price').value = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(firstVariant.price);
        document.getElementById('stock').value = firstVariant.stock;
        document.getElementById('product-image').src = baseURL + firstVariant.images[0].image_url;
    }

    document.getElementById('color').addEventListener('change', function() {
        const selectedColor = this.options[this.selectedIndex];
        const selectedImage = selectedColor.dataset.image;
        const selectedID = selectedColor.dataset.variant_id
        document.getElementById('price').value = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(selectedColor.dataset.price);
        document.getElementById('stock').value = selectedColor.dataset.stock;
        document.getElementById('product-image').src = baseURL + selectedImage;
        document.getElementById('deleteColor').setAttribute('data-variant', selectedID);
    });

    let dropZone = document.getElementById('drop-zone');
    let fileInput = document.getElementById('file-input');
    let productImage = document.getElementById('product-image');

    // Ngăn chặn hành vi mặc định khi kéo file vào
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop zone khi kéo file vào
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    // Xử lý sự kiện thả file
    dropZone.addEventListener('drop', handleDrop, false);

    // Xử lý sự kiện click vào drop zone
    dropZone.addEventListener('click', () => fileInput.click());

    // Xử lý sự kiện chọn file từ input
    fileInput.addEventListener('change', handleFiles);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dropZone.classList.add('highlight');
    }

    function unhighlight(e) {
        dropZone.classList.remove('highlight');
    }

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        if (files instanceof FileList) {
            ([...files]).forEach(uploadFile);
        } else if (files.target && files.target.files) {
            ([...files.target.files]).forEach(uploadFile);
        }
    }

    function uploadFile(file) {
        if (file.type.startsWith('image/')) {
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function() {
                productImage.src = reader.result;
            }
        } else {
            console.log('Vui lòng chọn file ảnh');
        }
    }
</script>
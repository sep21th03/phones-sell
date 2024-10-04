<script>
    $(document).ready(function() {

        $("#addProduct").click(function() {
            let formValues = {
                id: $("input[name='add_id']").val(),
                title: $("input[name='add_title']").val(),
                info: CKEDITOR.instances.editor4.getData(),
                description: CKEDITOR.instances.editor3.getData(),
                category_id: $("select[name='add_category']").val(),
                discount: $("input[name='add_discount']").val(),
                specifications_id: $("input[name='add_specifications_id']").val(),
                screen_size: $("input[name='add_screen_size']").val(),
                screen_resolution: $("input[name='add_screen_resolution']").val(),
                screen_type: $("input[name='add_screen_type']").val(),
                ram: $("input[name='add_ram']").val(),
                memory_card_slot: $("input[name='add_memory_card_slot']").val(),
                camera_front: $("input[name='add_camera_front']").val(),
                camera_rear: $("input[name='add_camera_rear']").val(),
                sim: $("input[name='add_sim']").val(),
                operating_system: $("input[name='add_operating_system']").val(),
                connectivity: $("input[name='add_connectivity']").val(),
                bluetooth: $("input[name='add_bluetooth']").val(),
                battery: $("input[name='add_battery']").val(),
                pin: $("input[name='add_pin']").val(),
                chip: $("input[name='add_chip']").val(),
                dimensions: $("input[name='add_dimensions']").val(),
                weight: $("input[name='add_weight']").val(),
                rom_id: parseInt($("select[name='add_rom_id']").val()),
                color: $("input[name='add_color_name']").val(),
                color_code: $("input[name='add_color_code']").val(),
                stock: $("input[name='add_stock']").val(),
                price: parseInt(
                    $("input[name='add_price']")
                    .val()
                    .replace(/\./g, "")
                    .replace(" ₫", "")
                ),
                variant_id: $("select[name='add_color']")
                    .find("option:selected")
                    .data("variant_id"),
                availability: $("input[name='add_stock']").val() > 0 ? 1 : 0,
                image: $("#file-add-product")[0].files[0],
            };
            var formData = new FormData();
            for (const key in formValues) {
                formData.append(key, formValues[key]);
            }

            $.ajax({
                url: "{{ route('product.store') }}",
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
                        text: "Thêm sản phẩm thành công!",
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload();
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


    CKEDITOR.replace('editor3', {
        extraPlugins: 'uploadimage',
        filebrowserUploadUrl: "{{ route('ckeditor.upload') }}",
        filebrowserUploadMethod: 'form',
        width: '100%',
        height: 400
    });
    CKEDITOR.replace('editor4', {
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

        // Tính năng chọn màu từ màn hình
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

    let dropZone = document.getElementById('drop-zone');
    let fileInput = document.getElementById('file-add-product');
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
@extends('layouts.app')
@section('title')
Thêm sản phẩm
@endsection
@section('content')
<style>
    #cke_description {
        width: 100%;
    }

    #drop-zone {
        border: 2px dashed #ccc;
        border-radius: 20px;
        font-family: sans-serif;
        margin: 100px auto;
        padding: 20px;
        text-align: center;
    }

    #drop-zone.highlight {
        border-color: purple;
    }

    p {
        margin-top: 0;
    }

    .button {
        display: inline-block;
        padding: 10px;
        background: #ccc;
        cursor: pointer;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .button:hover {
        background: #ddd;
    }

    #file-add-product {
        display: none;
    }
</style>
<div class="content">
    <nav class="mb-3" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#!">Page 1</a></li>
            <li class="breadcrumb-item"><a href="#!">Page 2</a></li>
            <li class="breadcrumb-item active">Default</li>
        </ol>
    </nav>
    <form class="mb-9">
        <input class="form-control mb-5" type="text" name="add_id" hidden />
        <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
                <h2 class="mb-2">Chi tiết sản phẩm</h2>
            </div>
            <div class="col-auto">
                <button class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</button>
                <button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0" type="button">Save draft</button>
                <button id="addProduct" class="btn btn-primary mb-2 mb-sm-0" type="button">Thêm</button>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-12 col-xl-8">
                <h4 class="mb-3">Tên sản phẩm</h4><input class="form-control mb-5" type="text" name="add_title" />
                <div class="mb-6">
                    <h4 class="mb-3">Giới thiệu sản phẩm</h4>
                    <textarea id="editor4" class="tinymce" name="add_info"></textarea>
                </div>
                <h4 class="mb-3">Thông số</h4>
                <div class="row g-0 border-top border-bottom mb-5">
                    <div class="col-sm-4">
                        <div class="nav flex-sm-column border-bottom border-bottom-sm-0 border-end-sm fs-9 vertical-tab h-100 justify-content-between" role="tablist" aria-orientation="vertical">
                            <a class="nav-link border-end border-end-sm-0 border-bottom-sm text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center active" id="screenTab" data-bs-toggle="tab" data-bs-target="#screenTabContent" role="tab" aria-controls="screenTabContent" aria-selected="true">
                                <span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>
                                <span class="d-none d-sm-inline">Kích thước màn hình</span>
                            </a>
                            <a class="nav-link border-end border-end-sm-0 border-bottom-sm text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="restockTab" data-bs-toggle="tab" data-bs-target="#restockTabContent" role="tab" aria-controls="restockTabContent" aria-selected="false">
                                <span class="me-sm-2 fs-4 nav-icons" data-feather="package"></span>
                                <span class="d-none d-sm-inline">RAM</span>
                            </a>
                            <a class="nav-link border-end border-end-sm-0 border-bottom-sm text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="shippingTab" data-bs-toggle="tab" data-bs-target="#shippingTabContent" role="tab" aria-controls="shippingTabContent" aria-selected="false">
                                <span class="me-sm-2 fs-4 nav-icons" data-feather="truck"></span>
                                <span class="d-none d-sm-inline">Giao tiếp & kết nối</span>
                            </a>
                            <a class="nav-link border-end border-end-sm-0 border-bottom-sm text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="cameraTab" data-bs-toggle="tab" data-bs-target="#cameraTabContent" role="tab" aria-controls="cameraTabContent" aria-selected="false">
                                <span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>
                                <span class="d-none d-sm-inline">Camera</span>
                            </a>
                            <a class="nav-link border-end border-end-sm-0 border-bottom-sm text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="productsTab" data-bs-toggle="tab" data-bs-target="#productsTabContent" role="tab" aria-controls="productsTabContent" aria-selected="false">
                                <span class="me-sm-2 fs-4 nav-icons" data-feather="globe"></span>
                                <span class="d-none d-sm-inline">Pin & công nghệ sạc</span>
                            </a>
                            <a class="nav-link border-end border-end-sm-0 border-bottom-sm text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="attributesTab" data-bs-toggle="tab" data-bs-target="#attributesTabContent" role="tab" aria-controls="attributesTabContent" aria-selected="false">
                                <span class="me-sm-2 fs-4 nav-icons" data-feather="sliders"></span>
                                <span class="d-none d-sm-inline">Vi xử lý & đồ họa</span>
                            </a>
                            <a class="nav-link text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="advancedTab" data-bs-toggle="tab" data-bs-target="#advancedTabContent" role="tab" aria-controls="advancedTabContent" aria-selected="false">
                                <span class="me-sm-2 fs-4 nav-icons" data-feather="lock"></span>
                                <span class="d-none d-sm-inline">Thiết kế & Trọng lượng</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-content py-3 ps-sm-4 h-100">
                            <input class="form-control mb-5" type="text" name="add_specifications_id" hidden />
                            <div class="tab-pane fade show active" id="screenTabContent" role="tabpanel" aria-labelledby="screenTab">
                                <h4 class="mb-3 d-sm-none">Kích thước màn hình</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Kích thước màn hình</h5><input class="form-control" name="add_screen_size" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Công nghệ màn hình</h5><input class="form-control" name="add_screen_type" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Độ phân giải màn hình</h5><input class="form-control" name="add_screen_resolution" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="restockTabContent" role="tabpanel" aria-labelledby="restockTab">
                                <h4 class="mb-3 d-sm-none">RAM & lưu trữ</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Dung lượng RAM</h5><input class="form-control" name="add_ram" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Khe cắm thẻ nhớ</h5><input class="form-control" name="add_memory_card_slot" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="cameraTabContent" role="tabpanel" aria-labelledby="cameraTab">
                                <h4 class="mb-3 d-sm-none">Thông số camera</h4>
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Camera trước</em></h5><input class="form-control" name="add_camera_front" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Camera sau</h5><input class="form-control" name="add_camera_rear" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="shippingTabContent" role="tabpanel" aria-labelledby="shippingTab">
                                <h4 class="mb-3 d-sm-none">Giao tiếp & kết nối</h4>
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Thẻ SIM</em></h5><input class="form-control" name="add_sim" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Hệ điều hành</h5><input class="form-control" name="add_operating_system" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Wi-Fi</em></h5><input class="form-control" name="add_connectivity" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Bluetooth</h5><input class="form-control" name="add_bluetooth" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="productsTabContent" role="tabpanel" aria-labelledby="productsTab">
                                <h4 class="mb-3 d-sm-none">Pin & công nghệ sạc</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Pin</h5><input class="form-control" name="add_battery" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Công nghệ sạc</h5><input class="form-control" name="add_pin" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="attributesTabContent" role="tabpanel" aria-labelledby="attributesTab">
                                <h4 class="mb-3 d-sm-none">Vi xử lý & đồ họa</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Chipset</h5><input class="form-control" name="add_chip" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="advancedTabContent" role="tabpanel" aria-labelledby="advancedTab">
                                <h4 class="mb-3 d-sm-none">Thiết kế & Trọng lượng</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Kích thước</h5><input class="form-control" name="add_dimensions" type="text" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Trọng lượng</h5><input class="form-control" name="add_weight" type="text" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">Mô tả sản phẩm</h4>
                <div class="row g-0 border-top border-bottom">
                    <textarea id="editor3" name="add_description"></textarea>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="row g-2">
                    <div class="col-12 col-xl-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Nguồn gốc</h4>
                                <div class="row gx-3">
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                                <h5 class="mb-0 text-body-highlight me-2">Hãng</h5><a class="fw-bold fs-9" href="{{ route('admin.category.list') }}">Thêm hãng mới</a>
                                            </div>
                                            <select class="form-select mb-3" aria-label="category" name="add_category">
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <h5 class="mb-2 text-body-highlight">Giảm giá %</h5><input class="form-control mb-xl-3" name="add_discount" type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <label for="rom" class="mb-2 text-body-highlight">Chọn ROM:</label>
                                <select id="rom" name="add_rom_id" class="form-select mb-3">
                                    @foreach ($roms as $rom)
                                    <option value="{{ $rom->id }}">{{ $rom->capacity }}</option>
                                    @endforeach
                                </select>


                                <div class="mb-3">
                                    <label for="colorName" class="form-label">Tên Màu</label>
                                    <input type="text" class="form-control" id="colorName" name="add_color_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="colorPickerInput" class="form-label">Chọn Màu</label>
                                    <input type="text" id="colorPickerInput" class="form-control mb-3" name="add_color_code" value="#000000" readonly>
                                    <div id="colorPicker"></div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <label for="stock" class="mb-2 text-body-highlight">Số lượng:</label>
                                    <input id="stock" class="form-control mb-xl-3" name="add_stock" type="text" />
                                </div>
                                <div class="mt-3 mb-3">
                                    <label for="price" class="mb-2 text-body-highlight">Giá:</label>
                                    <input id="price" class="form-control mb-xl-3" name="add_price" type="text" />
                                    <h4 class="mb-3">Ảnh sản phẩm</h4>
                                    <img id="product-image" src="" alt="" class="img-fluid mt-3" />
                                    <div id="drop-zone">
                                        <p>Kéo và thả nhiều ảnh vào đây hoặc click để chọn files</p>
                                        <input type="file" id="file-add-product" accept="image/*" multiple>
                                    </div>
                                </div>
                            </div><button class="btn btn-phoenix-primary w-100" type="button">Add another option</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
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
</script>
<script>
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


<script src="{{ url("assets/js/admin/product.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>
@endsection
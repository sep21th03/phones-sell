@extends('layouts.app')
@section('title')
Chi tiết sản phẩm
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

    #file-input {
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
        <input class="form-control mb-5" type="text" value="{{ $product->id }}" name="edit_id" hidden />
        <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
                <h2 class="mb-2">Chi tiết sản phẩm</h2>
            </div>
            <div class="col-auto">
                <button id="addProduct" class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Thêm sản phẩm</button>
                <button id="reloadDetalProduct" class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0" type="button">Reload</button>
                <button id="editBtnProduct" class="btn btn-primary mb-2 mb-sm-0" type="button">Lưu</button>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-12 col-xl-8">
                <h4 class="mb-3">Tên sản phẩm</h4><input class="form-control mb-5" type="text" value="{{ $product->title }}" name="edit_title" />
                <div class="mb-6">
                    <h4 class="mb-3">Giới thiệu sản phẩm</h4>
                    <div id="editor2" class="tinymce" name="edit_info">{{ $product->info }}</div>
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
                            <input class="form-control mb-5" type="text" value="{{ $product->specifications->id }}" name="edit_specifications_id" hidden />
                            <div class="tab-pane fade show active" id="screenTabContent" role="tabpanel" aria-labelledby="screenTab">
                                <h4 class="mb-3 d-sm-none">Kích thước màn hình</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Kích thước màn hình</h5><input class="form-control" name="edit_screen_size" type="text" value="{{ $product->specifications->screen_size }}" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Công nghệ màn hình</h5><input class="form-control" name="edit_screen_type" type="text" value="{{ $product->specifications->screen_type }}" />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Độ phân giải màn hình</h5><input class="form-control" name="edit_screen_resolution" type="text" value="{{ $product->specifications->screen_resolution }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="restockTabContent" role="tabpanel" aria-labelledby="restockTab">
                                <h4 class="mb-3 d-sm-none">RAM & lưu trữ</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Dung lượng RAM</h5><input class="form-control" name="edit_ram" type="text" value="{{ $product->specifications->ram }}" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Khe cắm thẻ nhớ</h5><input class="form-control" name="edit_memory_card_slot" type="text" value="{{ $product->specifications->memory_card_slot }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="cameraTabContent" role="tabpanel" aria-labelledby="cameraTab">
                                <h4 class="mb-3 d-sm-none">Thông số camera</h4>
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Camera trước</em></h5><input class="form-control" name="edit_camera_front" type="text" value="{{ $product->specifications->camera_front }}" />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Camera sau</h5><input class="form-control" name="edit_camera_rear" type="text" value="{{ $product->specifications->camera_rear }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="shippingTabContent" role="tabpanel" aria-labelledby="shippingTab">
                                <h4 class="mb-3 d-sm-none">Giao tiếp & kết nối</h4>
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Thẻ SIM</em></h5><input class="form-control" name="edit_sim" type="text" value="{{ $product->specifications->sim }}" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Hệ điều hành</h5><input class="form-control" name="edit_operating_system" type="text" value="{{ $product->specifications->operating_system }}" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Wi-Fi</em></h5><input class="form-control" name="edit_connectivity" type="text" value="{{ $product->specifications->connectivity }}" />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <h5 class="mb-2 text-body-highlight">Bluetooth</h5><input class="form-control" name="edit_bluetooth" type="text" value="{{ $product->specifications->bluetooth }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="productsTabContent" role="tabpanel" aria-labelledby="productsTab">
                                <h4 class="mb-3 d-sm-none">Pin & công nghệ sạc</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Pin</h5><input class="form-control" name="edit_battery" type="text" value="{{ $product->specifications->battery }}" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Công nghệ sạc</h5><input class="form-control" name="edit_pin" type="text" value="{{ $product->specifications->pin }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="attributesTabContent" role="tabpanel" aria-labelledby="attributesTab">
                                <h4 class="mb-3 d-sm-none">Vi xử lý & đồ họa</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Chipset</h5><input class="form-control" name="edit_chip" type="text" value="{{ $product->specifications->chip }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="advancedTabContent" role="tabpanel" aria-labelledby="advancedTab">
                                <h4 class="mb-3 d-sm-none">Thiết kế & Trọng lượng</h4>
                                <div class="col g-3">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Kích thước</h5><input class="form-control" name="edit_dimensions" type="text" value="{{ $product->specifications->dimensions }}" />
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <h5 class="mb-2 text-body-highlight">Trọng lượng</h5><input class="form-control" name="edit_weight" type="text" value="{{ $product->specifications->weight }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">Mô tả sản phẩm</h4>
                    <div id="editor1" name="edit_description">{{ $product->description }}</div>
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
                                                <h5 class="mb-0 text-body-highlight me-2">Hãng</h5><a class="fw-bold fs-9" href="{{ route('category.list') }}">Thêm hãng mới</a>
                                            </div>
                                            <select class="form-select mb-3" aria-label="category" name="edit_category">
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $product->category->id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <h5 class="mb-2 text-body-highlight">Giảm giá %</h5><input class="form-control mb-xl-3" name="edit_discount" type="text" value="{{ $product->discount }}" />
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
                                <select id="rom" name="edit_rom" class="form-select mb-3">
                                    @foreach ($roms as $rom)
                                    <option value="{{ $rom->id }}"
                                        data-capacity="{{ $rom->capacity }}"
                                        @if ($product->variants->contains('rom.id', $rom->id)) selected @endif>
                                        {{ $rom->capacity }}
                                    </option>
                                    @endforeach
                                </select>


                                <label for="color" class="mb-2 text-body-highlight">Chọn Màu:</label><a class="fw-bold fs-9 ms-5" href="#!" data-bs-toggle="modal" data-bs-target="#addColorModal">Thêm Màu Mới</a><a id="deleteColor" class="fw-bold fs-9 ms-5" href="#!" data-variant="" onclick="deleteColor(this.dataset.variant)"> Xóa Màu</a>
                                <select id="color" name="edit_color" class="form-select mb-3">
                                    <!-- Color -->
                                </select>
                                <div class="mt-3 mb-3">
                                    <label for="stock" class="mb-2 text-body-highlight">Số lượng:</label>
                                    <input id="stock" class="form-control mb-xl-3" name="edit_stock" type="text" />
                                </div>
                                <div class="mt-3 mb-3">
                                    <label for="price" class="mb-2 text-body-highlight">Giá:</label>
                                    <input id="price" class="form-control mb-xl-3" name="edit_price" type="text" />
                                    <h4 class="mb-3">Ảnh sản phẩm</h4>
                                    <img id="product-image" src="" alt="{{ $product->title }}" class="img-fluid mt-3" />
                                    <div id="drop-zone">
                                        <p>Kéo và thả ảnh vào đây hoặc click để chọn file</p>
                                        <input type="file" id="file-input" accept="image/*" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



@endsection
@section('modal')
    @include('product.edit.modal')
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>
    @include('product.edit.js')
@endsection
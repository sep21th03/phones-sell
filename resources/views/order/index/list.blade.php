@extends('layouts.app')
@section('title')
Danh sách đơn hàng
@endsection
@section('content')
<div class="content">
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Đơn hàng</h2>
            </div>
        </div>
        <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>All </span><span class="text-body-tertiary fw-semibold">(68817)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Pending payment </span><span class="text-body-tertiary fw-semibold">(6)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Unfulfilled </span><span class="text-body-tertiary fw-semibold">(17)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Completed</span><span class="text-body-tertiary fw-semibold">(6,810)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Refunded</span><span class="text-body-tertiary fw-semibold">(8)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Failed</span><span class="text-body-tertiary fw-semibold">(2)</span></a></li>
        </ul>
        <div id="orderTable" data-list='{"valueNames":["order","total","customer","payment_status","fulfilment_status","delivery_type","date"],"page":10,"pagination":true}'>
            <div class="mb-4">
                <div class="row g-3">
                    <div class="col-auto">
                        <div class="search-box">
                            <form class="position-relative"><input class="form-control search-input search" type="search" placeholder="Search orders" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                    <div class="col-auto scrollbar overflow-hidden-y flex-grow-1">
                        <div class="btn-group position-static" role="group">
                            <div class="btn-group position-static text-nowrap" role="group"><button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> Payment status<span class="fas fa-angle-down ms-2"></span></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                            </div>
                            <div class="btn-group position-static text-nowrap" role="group"><button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> Fulfilment status<span class="fas fa-angle-down ms-2"></span></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                            </div><button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">More filters </button>
                        </div>
                    </div>
                    <div class="col-auto"><button class="btn btn-link text-body me-4 px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Export</button><button class="btn btn-primary"><span class="fas fa-plus me-2"></span>Add order</button></div>
                </div>
            </div>
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                <div class="table-responsive scrollbar mx-n1 px-1">
                    <table class="table table-sm fs-9 mb-0">
                        <thead>
                            <tr>
                                <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">STT</th>
                                <th class="sort white-space-nowrap align-middle text-center pe-3" scope="col" data-sort="order" style="width:10%;">Mã đơn hàng</th>
                                <th class="sort align-middle text-center" scope="col" data-sort="total" style="width:10%;">Tổng số tiền</th>
                                <th class="sort align-middle text-center ps-8" scope="col" data-sort="customer" style="width:25%; min-width: 250px;">Người dùng</th>
                                <th class="sort align-middle text-center" scope="col" data-sort="delivery_type" style="width:15%;">Số điện thoại</th>
                                <th class="sort align-middle text-center pe-3" scope="col" data-sort="payment_status" style="width:10%;">Trạng thái</th>
                                <th class="sort align-middle text-center pe-0" scope="col" data-sort="date" style="width:20%;">Thời gian đặt hàng</th>
                                <th class="sort align-middle text-center" scope="col" data-sort="delivery_type" style="width:10%;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="order-table-body">
                            @foreach ($orders as $order)
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                <td class="fs-9 align-middle text-center px-0 py-3">{{ $loop->iteration }}</td>
                                <td class="order align-middle text-center white-space-nowrap py-0"><a class="fw-semibold" href="#!">{{ $order['code'] }}</a></td>
                                <td class="total align-middle text-center fw-semibold text-body-highlight">{{ number_format($order['total_price']) }} VNĐ</td>
                                <td class="customer align-middle text-center white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../landing/profile.html">
                                        <div class="avatar avatar-m"><img class="rounded-circle" src="{{ $order->user->avt_url }}" alt="" /></div>
                                        <h6 class="mb-0 ms-3 text-body">{{ $order->user->name }}</h6>
                                    </a></td>
                                <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-center">{{ $order['phone'] }}</td>
                                <td class="payment_status align-middle white-space-nowrap text-center fw-bold text-body-tertiary">
                                    @php
                                    $status = $order['status'];
                                    $statusLabels = [
                                    0 => ['label' => 'Đang chờ', 'color' => 'primary', 'icon' => 'clock'],
                                    1 => ['label' => 'Thành công', 'color' => 'success', 'icon' => 'check'],
                                    2 => ['label' => 'Đã huỷ', 'color' => 'danger', 'icon' => 'x'],
                                    3 => ['label' => 'Đã xác nhận', 'color' => 'info', 'icon' => 'info'],
                                    4 => ['label' => 'Đang giao hàng', 'color' => 'warning', 'icon' => 'truck'],
                                    5 => ['label' => 'Đang chờ thanh toán', 'color' => 'secondary', 'icon' => 'credit-card'],
                                    ];
                                    $currentStatus = $statusLabels[$status];
                                    @endphp
                                    <span class="badge badge-phoenix fs-10 badge-phoenix-{{ $currentStatus['color'] }}">
                                        <span class="badge-label">{{ $currentStatus['label'] }}</span>
                                        <span class="ms-1" data-feather="{{ $currentStatus['icon'] }}" style="height:12.8px;width:12.8px;"></span>
                                    </span>
                                </td>
                                <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-center">{{ $order['created_at'] }}</td>
                                <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-center">
                                    <div class="btn-reveal-trigger position-relative">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="{{ route('order.detail', ['id' => $order['id']]) }}">Xem chi tiết</a>
                                            <a class="dropdown-item" href="#!">Export</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#!">Xóa</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </div>
                <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                    <div class="col-auto d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    </div>
                    <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                        <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
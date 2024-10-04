@extends('layouts.app')
@section('title')
Danh sách người dùng
@endsection
@section('content')
<style>
    #list_user th,
    #list_user td {
        font-size: 1rem;
    }

    #customers-table-body tr {
        background-color: transparent !important;
        text-align: center;
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
    <div class="mb-9">
        <div class="row g-2 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Người dùng</h2>
            </div>
        </div>
        <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>Tất cả </span><span class="text-body-tertiary fw-semibold">({{ $total_users }})</span></a></li>
        </ul>
        <div id="users" data-list='{"valueNames":["customer","email","total-orders","total-spent","city","last-seen","last-order"],"page":10,"pagination":true}'>
            <div class="mb-4">
                <div class="row g-3 justify-content-between">
                    <div class="col-auto">
                        <div class="search-box">
                            <form class="position-relative" id="searchForm"><input id="searchInput" class="form-control search-input search" type="search" placeholder="Search customers" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                    <div class="col-auto"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser"><span class="fas fa-plus me-2"></span>Thêm</button></div>
                </div>
            </div>
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                <div class="table-responsive scrollbar-overlay mx-n1 px-1">
                    <table id="list_user" class="table table-sm fs-9 mb-0">
                        <thead>
                            <tr>
                                <th class="white-space-nowrap fs-9 align-middle ps-0" data-orderable="false" style="width: 5%;">
                                    <div class="form-check mb-0 fs-8"><input class="form-check-input" id="checkbox-bulk-products-select" type="checkbox" data-bulk-select='{"body":"products-table-body"}' /></div>
                                </th>
                                <th class="fs-9 align-middle text-center ps-0" style="width: 10%;">Tên người dùng</th>
                                <th class="fs-9 align-middle text-center" style="width: 15%;">Email</th>
                                <th class="fs-9 align-middle text-center pe-0" style="width: 15%;">Số điện thoại</th>
                                <th class="fs-9 align-middle text-center pe-0" style="width: 10%;">Role</th>
                                <th class="fs-9 align-middle text-center pe-0" style="width: 15%;">Created_at</th>
                                <th class="fs-9 align-middle text-center pe-0" style="width: 15%;">Updated_at</th>
                                <th class="fs-9 align-middle text-center pe-0" style="width: 10%;"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="customers-table-body">
                            <!-- User -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
@section('modal')
@include('user.modal.main')
@endsection
@section('script')
@include('user.index.js')
@endsection
@extends('layouts.app')
@section('title')
Danh sách hãng
@endsection
@section('content')
<style>
        #list_category th, 
        #list_category td {
            font-size: 1rem; 
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #111;
    background: #fff;
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
          <h2 class="mb-0">Category</h2>
        </div>
      </div>
      <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>Tất cả </span><span class="text-body-tertiary fw-semibold">({{ $total_categories }})</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" onclick="getCategoryNew()"><span>Mới </span><span class="text-body-tertiary fw-semibold">({{ $total_new_categories }})</span></a></li>
      </ul>
      <div id="products" data-list='{"valueNames":["customer","email","total-orders","total-spent","city","last-seen","last-order"],"page":10,"pagination":true}'>
        <div class="mb-4">
          <div class="row g-3 justify-content-between">
            <div class="col-auto">
              <div class="search-box">
                <form class="position-relative" id="searchForm"><input id="searchInput" class="form-control search-input search" type="search" placeholder="Search customers" aria-label="Search" />
                  <span class="fas fa-search search-box-icon"></span>
                </form>
              </div>
            </div>
            <div class="col-auto"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory"><span class="fas fa-plus me-2"></span>Thêm</button></div>
          </div>
        </div>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
          <div class="table-responsive scrollbar-overlay mx-n1 px-1">
            <table id="list_category" class="table table-sm fs-9 mb-0">
              <thead>
                <tr>
                  <th class="fs-9 align-middle ps-0" style="width: 25%;">Tên loại sản phẩm</th>
                  <th class="fs-9 align-middle text-end" style="width: 25%;">Ngày tạo</th>
                  <th class="fs-9 align-middle text-end pe-0" style="width: 25%;">Ngày cập nhật</th>
                  <th class="fs-9 align-middle text-end pe-0" style="width: 25%;"></th>
                </tr>
              </thead>
              <tbody class="list" id="customers-table-body">
                  <!-- Hãng -->
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
        @include('category.modal.main')
@endsection
@section('script')
        @include('category.index.js')
@endsection
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

  #list_category th.sorting:before,
  #list_category th.sorting:after {
    display: none;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #111;
    background: #fff;
  }

  #list_category,
  #list_category th,
  #list_category td {
    border: none !important;
  }

  #list_category tbody tr {
    border-bottom: 1px solid #ccc !important;
  }

  #list_category tbody tr:last-child {
    border-bottom: none !important;
  }

  table.dataTable {
    border-collapse: collapse !important;
  }

  #customers-table-body tr {
    background-color: transparent !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #ffffff;
    background: #fff;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:active {
    outline: none;
    background: #ffffff;
    box-shadow: inset 0 0 3px #ffffff;
  }
</style>
<div class="content">
  <div class="mb-9">
    <div class="row g-2 mb-4">
      <div class="col-auto">
        <h2 class="mb-0">Hãng sản phẩm</h2>
      </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
      <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>Tất cả</span><span class="text-body-tertiary fw-semibold">({{ $total_categories }})</span></a></li>
    </ul>
    <div id="categories" data-list='{"valueNames":["customer","email","total-orders","total-spent","city","last-seen","last-order"],"page":10,"pagination":true}'>
      <div class="mb-4">
        <div class="row g-3 justify-content-between">
          <div class="col-auto">
            <div class="search-box">
              <form class="position-relative" id="searchForm"><input id="searchInput" class="form-control search-input search" type="search" placeholder="Tìm kiếm" aria-label="Search" />
                <span class="fas fa-search search-box-icon"></span>
              </form>
            </div>
          </div>
          <div class="col-auto"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory"><span class="fas fa-plus me-2"></span>Thêm</button></div>
        </div>
      </div>
      <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative py-4">
        <div class="table-responsive mx-n1 px-1">
          <table id="list_category" class="table table-sm fs-9 mb-0">
            <thead>
              <tr>
                <th class="fs-8 text-center ps-0" style="width: 25%;">Tên loại sản phẩm</th>
                <th class="fs-8 text-center ps-0" style="width: 25%;">Ngày tạo</th>
                <th class="fs-8 text-center pe-0" style="width: 25%;">Ngày cập nhật</th>
                <th class="fs-8 text-center pe-0" style="width: 25%;"></th>
              </tr>
            </thead>
            <tbody class="list text-center" id="customers-table-body">
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
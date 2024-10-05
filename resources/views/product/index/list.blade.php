@extends('layouts.app')
@section('title')
Danh sách sản phẩm
@endsection
@section('content')
<style>
    
    #list_product th,
  #list_product td {
    font-size: 1rem;
  }

  #list_product th.sorting:before,
  #list_product th.sorting:after {
    display: none;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #111;
    background: #fff;
  }

  #list_product,
  #list_product th,
  #list_product td {
    border: none !important;
  }

  #list_product tbody tr {
    border-bottom: 1px solid #ccc !important;
  }

  #list_product tbody tr:last-child {
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

  .form-check {
    padding-left: 2.5em !important;
  }
</style>
<div class="content">
  <div class="mb-9">
    <div class="row g-3 mb-4">
      <div class="col-auto">
        <h2 class="mb-0">Sản phẩm</h2>
      </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
      <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>Tất cả</span><span class="text-body-tertiary fw-semibold">({{ $total_products }})</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span>Published </span><span class="text-body-tertiary fw-semibold">(70348)</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span>Drafts </span><span class="text-body-tertiary fw-semibold">(17)</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span>On discount </span><span class="text-body-tertiary fw-semibold">(810)</span></a></li>
    </ul>
    <div id="products">
      <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
          <div class="search-box">
            <form class="position-relative"><input class="form-control search-input search" type="search" placeholder="Tìm kiếm" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
          <div class="ms-xxl-auto"><button class="btn btn-link text-body me-4 px-0" onclick="exportToExcel()"><span class="fa-solid fa-file-export fs-9 me-2"></span>Export</button><button class="btn btn-primary" id="addBtnProduct"><span class="fas fa-plus me-2"></span>Thêm sản phẩm</button></div>
        </div>
      </div>
      <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
        <div class="table-responsive scrollbar mx-n1 px-1">
          <table id="list_product" class="table fs-9 mb-0">
            <thead>
              <tr>
                <th class="white-space-nowrap fs-9 align-middle ps-0" data-orderable="false" style="width: 5%;">
                  <div class="form-check mb-0 fs-8"><input class="form-check-input" id="checkbox-bulk-products-select" type="checkbox" data-bulk-select='{"body":"products-table-body"}' /></div>
                </th>
                <th class="sort white-space-nowrap align-middle fs-10" scope="col" style="width: 20%;">ẢNH</th>
                <th class="sort white-space-nowrap align-middle text-center ps-4" scope="col" style="width:350px;" data-sort="product">TÊN SẢN PHẨM</th>
                <th class="sort align-middle  text-center ps-4" scope="col" data-sort="category" style="width:150px;">HÃNG</th>
                <th class="sort align-middle  text-center ps-4" scope="col" data-sort="category" style="width:150px;">DUNG LƯỢNG</th>
                <th class="sort  text-center align-middle pe-0 ps-4" scope="col" style="width: 7%;">
                  <button class="btn btn-danger btn-sm" onclick="deleteSelectedProducts()">Xóa</button>
                </th>
              </tr>
            </thead>
            <tbody class="list text-center fs-8" id="products-table-body">
              <!-- Products -->
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
@include('product.modal.main')
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
@include('product.index.js')
@endsection
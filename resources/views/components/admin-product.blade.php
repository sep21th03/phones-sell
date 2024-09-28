<style>
  table.dataTable tbody tr {
    background-color: transparent !important;
  }

  .table>tbody {
    vertical-align: middle !important;
  }

/* Thiết lập kiểu cho bảng */
.table {
    width: 100%;
    border-collapse: collapse; /* Gộp các đường biên */
    margin: 20px 0; /* Khoảng cách phía trên và dưới */
}

/* Định dạng hàng của bảng */
.table tr {
    background-color: #f9f9f9; /* Màu nền cho hàng */
    transition: background-color 0.3s; /* Hiệu ứng chuyển tiếp khi di chuột */
}

/* Định dạng ô của bảng */
.table td {
    padding: 12px; /* Khoảng cách bên trong ô */
    border: 1px solid #ddd; /* Đường biên cho ô */
    text-align: center; /* Căn giữa nội dung */
}

/* Đổi màu hàng khi di chuột qua */
.table tr:hover {
    background-color: #f1f1f1; /* Màu nền khi di chuột */
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
    <div class="row g-3 mb-4">
      <div class="col-auto">
        <h2 class="mb-0">Products</h2>
      </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
      <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>All </span><span class="text-body-tertiary fw-semibold">(68817)</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span>Published </span><span class="text-body-tertiary fw-semibold">(70348)</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span>Drafts </span><span class="text-body-tertiary fw-semibold">(17)</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span>On discount </span><span class="text-body-tertiary fw-semibold">(810)</span></a></li>
    </ul>
    <div id="products">
      <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
          <div class="search-box">
            <form class="position-relative"><input class="form-control search-input search" type="search" placeholder="Search products" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
          <div class="ms-xxl-auto"><button class="btn btn-link text-body me-4 px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Export</button><button class="btn btn-primary" id="addBtnProduct"><span class="fas fa-plus me-2"></span>Thêm sản phẩm</button></div>
        </div>
      </div>
      <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
        <div class="table-responsive scrollbar mx-n1 px-1">
          <table id="list_product" class="table fs-9 mb-0">
            <thead>
              <tr>
                <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                  <div class="form-check mb-0 fs-8"><input class="form-check-input" id="checkbox-bulk-products-select" type="checkbox" data-bulk-select='{"body":"products-table-body"}' /></div>
                </th>
                <th class="sort white-space-nowrap align-middle fs-10" scope="col" style="width: 20%;">ẢNH</th>
                <th class="sort white-space-nowrap align-middle text-center ps-4" scope="col" style="width:350px;" data-sort="product">TÊN SẢN PHẨM</th>
                <th class="sort align-middle  text-center ps-4" scope="col" data-sort="category" style="width:150px;">HÃNG</th>
                <th class="sort align-middle  text-center ps-4" scope="col" data-sort="category" style="width:150px;">DUNG LƯỢNG</th>
                <th class="sort  text-center align-middle pe-0 ps-4" scope="col" style="width: 5%;"></th>
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

<script src="{{ url("assets/js/admin/product.js")}}"></script>
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
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>All </span><span class="text-body-tertiary fw-semibold">(68817)</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>New </span><span class="text-body-tertiary fw-semibold">(6)</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Abandoned checkouts </span><span class="text-body-tertiary fw-semibold">(17)</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Locals </span><span class="text-body-tertiary fw-semibold">(6,810)</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Email subscribers </span><span class="text-body-tertiary fw-semibold">(8)</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Top reviews </span><span class="text-body-tertiary fw-semibold">(2)</span></a></li>
      </ul>
      <div id="products" data-list='{"valueNames":["customer","email","total-orders","total-spent","city","last-seen","last-order"],"page":10,"pagination":true}'>
        <div class="mb-4">
          <div class="row g-3">
            <div class="col-auto">
              <div class="search-box">
                <form class="position-relative" id="searchForm"><input id="searchInput" class="form-control search-input search" type="search" placeholder="Search customers" aria-label="Search" />
                  <span class="fas fa-search search-box-icon"></span>
                </form>
              </div>
            </div>
            <div class="col-auto scrollbar overflow-hidden-y flex-grow-1">
              <div class="btn-group position-static" role="group">
                <div class="btn-group position-static text-nowrap"><button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> Country<span class="fas fa-angle-down ms-2"></span></button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">US</a></li>
                    <li><a class="dropdown-item" href="#">Uk</a></li>
                    <li><a class="dropdown-item" href="#">Australia</a></li>
                  </ul>
                </div>
                <div class="btn-group position-static text-nowrap"><button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> VIP<span class="fas fa-angle-down ms-2"></span></button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">VIP 1</a></li>
                    <li><a class="dropdown-item" href="#">VIP 2</a></li>
                    <li><a class="dropdown-item" href="#">VIP 3</a></li>
                    <li></li>
                  </ul>
                </div><button class="btn btn-phoenix-secondary px-7 flex-shrink-0">More filters</button>
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
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm loại sản phẩm</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="addInputCategory" class="form-label">Tên loại</label>
            <input type="text" name="name" class="form-control" id="addInputCategory" aria-describedby="emailHelp">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="button" name="submit_add_category" class="btn btn-primary">Thêm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Sửa loại sản phẩm</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="editInputCategory" class="form-label">Tên loại</label>
            <input type="text" name="name_edit" class="form-control" id="editInputCategory" aria-describedby="emailHelp">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="button" name="submit_edit_category" class="btn btn-primary">Cập nhật</button>
      </div>
    </div>
  </div>
</div>

<script src="{{ url("assets/js/admin/category.js")}}"></script>
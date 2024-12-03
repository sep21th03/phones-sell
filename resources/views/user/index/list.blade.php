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

  #list_user th.sorting:before,
  #list_user th.sorting:after {
    display: none;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #111;
    background: #fff;
  }

  #list_user,
  #list_user th,
  #list_user td {
    border: none !important;
  }

  #list_user tbody tr {
    border-bottom: 1px solid #ccc !important;
  }

  #list_user tbody tr:last-child {
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
                <h2 class="mb-0">Users</h2>
            </div>
        </div>
        <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>Number of users: </span><span class="text-body-tertiary fw-semibold">{{ $total_users }}</span></a></li>
        </ul>
        <div id="users" data-list='{"valueNames":["customer","email","total-orders","total-spent","city","last-seen","last-order"],"page":10,"pagination":true}'>
            <div class="mb-4">
                <div class="row g-3 justify-content-between">
                    <div class="col-auto">
                        <div class="search-box">
                            <form class="position-relative" id="searchForm"><input id="searchInput" class="form-control search-input search" type="search" placeholder="Tìm kiếm" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                <div class="table-responsive scrollbar-overlay mx-n1 px-1">
                    <table id="list_user" class="table fs-9 mb-0">
                        <thead>
                            <tr>
                                <th class="fs-8 align-middle text-start ps-0" style="width: 15%;">User name</th>
                                <th class="fs-8 align-middle text-start" style="width: 15%;">Email</th>
                                <th class="fs-8 align-middle text-start pe-0" style="width: 15%;">Phone number</th>
                                <th class="fs-8 align-middle text-center pe-0" style="width: 10%;">Role</th>
                                <th class="fs-8 align-middle text-center pe-0" style="width: 15%;">Created at</th>
                                <th class="fs-8 align-middle text-center pe-0" style="width: 15%;">Updated at</th>
                                <th class="fs-8 align-middle text-center pe-0" style="width: 5%;"></th>
                            </tr>
                        </thead>
                        <tbody class="list text-center" id="customers-table-body">
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

<main class="main" id="top">
  <nav class="navbar navbar-vertical navbar-expand-lg" style="display:none;">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
      <!-- scrollbar removed-->
      <div class="navbar-vertical-content">
        <ul class="navbar-nav flex-column" id="navbarVerticalNav">
          <div class="parent-wrapper">
            <ul class="nav collapse parent show" data-bs-parent="#e-commerce" id="nv-admin">
              <li class="nav-item"><a class="nav-link" href="{{ route("product.add") }}">
                  <div class="d-flex align-items-center"><span class="nav-link-text">Thêm sản phẩm</span></div>
                </a><!-- more inner pages-->
              </li>
              <li class="nav-item"><a class="nav-link" href="{{ route("product.list") }}">
                  <div class="d-flex align-items-center"><span class="nav-link-text">Sản phẩm</span></div>
                </a><!-- more inner pages-->
              </li>
              <li class="nav-item"><a class="nav-link" href="{{ route("category.list") }}">
                  <div class="d-flex align-items-center"><span class="nav-link-text">Hãng</span></div>
                </a><!-- more inner pages-->
              </li>
              <li class="nav-item"><a class="nav-link" href="{{ route("user.list") }}">
                  <div class="d-flex align-items-center"><span class="nav-link-text">Người dùng</span></div>
                </a><!-- more inner pages-->
              </li>
              <li class="nav-item"><a class="nav-link" href="{{ route("order.list") }}">
                  <div class="d-flex align-items-center"><span class="nav-link-text">Đơn hàng</span></div>
                </a><!-- more inner pages-->
              </li>
              <li class="nav-item"><a class="nav-link" href="{{ route("review.list") }}">
                  <div class="d-flex align-items-center"><span class="nav-link-text">Phản hồi</span></div>
                </a><!-- more inner pages-->
              </li>
            </ul>
          </div>
        </ul>
      </div>
    </div>
    <div class="navbar-vertical-footer"><button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button></div>
  </nav>
  <nav class="navbar navbar-top fixed-top navbar-expand" id="navbarDefault" style="display:none;">
    <div class="collapse navbar-collapse justify-content-between">
      <div class="navbar-logo">
        <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
        <a class="navbar-brand me-1 me-sm-3" href="{{ route('dashboard') }}">
          <div class="d-flex align-items-center">
            <div class="d-flex align-items-center"><img src=" {{ url("assets/img/icons/logo.png") }}" alt="phoenix" width="27" />
              <h5 class="logo-text ms-2 d-none d-sm-block">Admin</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="search-box navbar-top-search-box d-none d-lg-block" data-list='{"valueNames":["title"]}' style="width:25rem;">
        <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input fuzzy-search rounded-pill form-control-sm" type="search" placeholder="Search..." aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
      <ul class="navbar-nav navbar-nav-icons flex-row">
        <li class="nav-item">
          <div class="theme-control-toggle fa-icon-wait px-2"><input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox" data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme" style="height:32px;width:32px;"><span class="icon" data-feather="moon"></span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme" style="height:32px;width:32px;"><span class="icon" data-feather="sun"></span></label></div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" style="min-width: 2.25rem" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside"><span class="d-block" style="height:20px;width:20px;"><span data-feather="bell" style="height:20px;width:20px;"></span></span></a>
          <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
            <div class="card position-relative border-0">
              <div class="card-header p-2">
                <div class="d-flex justify-content-between">
                  <h5 class="text-body-emphasis mb-0">Notifications</h5><button class="btn btn-link p-0 fs-9 fw-normal" type="button">Mark all as read</button>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="scrollbar-overlay" style="height: 27rem;">
                  <div class="px-2 px-sm-3 py-3 notification-card position-relative read border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                      <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src=" {{ url("assets/img/team/40x40/30.webp") }}" alt="" /></div>
                        <div class="flex-1 me-sm-3">
                          <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                          <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span class='me-1 fs-10'>💬</span>Mentioned you in a comment.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">10m</span></p>
                          <p class="text-body-secondary fs-9 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:41 AM </span>August 7,2021</p>
                        </div>
                      </div>
                      <div class="dropdown notification-dropdown"><button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                        <div class="dropdown-menu py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                      <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3">
                          <div class="avatar-name rounded-circle"><span>J</span></div>
                        </div>
                        <div class="flex-1 me-sm-3">
                          <h4 class="fs-9 text-body-emphasis">Jane Foster</h4>
                          <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span class='me-1 fs-10'>📅</span>Created an event.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">20m</span></p>
                          <p class="text-body-secondary fs-9 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:20 AM </span>August 7,2021</p>
                        </div>
                      </div>
                      <div class="dropdown notification-dropdown"><button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                        <div class="dropdown-menu py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                      <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle avatar-placeholder" src=" {{ url("assets/img/team/40x40/avatar.webp") }}" alt="" /></div>
                        <div class="flex-1 me-sm-3">
                          <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                          <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span class='me-1 fs-10'>👍</span>Liked your comment.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">1h</span></p>
                          <p class="text-body-secondary fs-9 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:30 AM </span>August 7,2021</p>
                        </div>
                      </div>
                      <div class="dropdown notification-dropdown"><button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                        <div class="dropdown-menu py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                      <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src=" {{ url("assets/img/team/40x40/57.webp") }}" alt="" /></div>
                        <div class="flex-1 me-sm-3">
                          <h4 class="fs-9 text-body-emphasis">Kiera Anderson</h4>
                          <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span class='me-1 fs-10'>💬</span>Mentioned you in a comment.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10"></span></p>
                          <p class="text-body-secondary fs-9 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:11 AM </span>August 7,2021</p>
                        </div>
                      </div>
                      <div class="dropdown notification-dropdown"><button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                        <div class="dropdown-menu py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                      <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src=" {{ url("assets/img/team/40x40/59.webp") }}" alt="" /></div>
                        <div class="flex-1 me-sm-3">
                          <h4 class="fs-9 text-body-emphasis">Herman Carter</h4>
                          <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span class='me-1 fs-10'>👤</span>Tagged you in a comment.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10"></span></p>
                          <p class="text-body-secondary fs-9 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:58 PM </span>August 7,2021</p>
                        </div>
                      </div>
                      <div class="dropdown notification-dropdown"><button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                        <div class="dropdown-menu py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="px-2 px-sm-3 py-3 notification-card position-relative read ">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                      <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src=" {{ url("assets/img/team/40x40/58.webp") }}" alt="" /></div>
                        <div class="flex-1 me-sm-3">
                          <h4 class="fs-9 text-body-emphasis">Benjamin Button</h4>
                          <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span class='me-1 fs-10'>👍</span>Liked your comment.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10"></span></p>
                          <p class="text-body-secondary fs-9 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:18 AM </span>August 7,2021</p>
                        </div>
                      </div>
                      <div class="dropdown notification-dropdown"><button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                        <div class="dropdown-menu py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer p-0 border-top border-translucent border-0">
                <div class="my-2 text-center fw-bold fs-10 text-body-tertiary text-opactity-85"><a class="fw-bolder" href="pages/notifications.html">Notification history</a></div>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" data-bs-auto-close="outside" aria-expanded="false"><svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="../../../www.w3.org/2000/svg.html">
              <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
              <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
              <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
              <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
              <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
              <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
              <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
              <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
              <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
            </svg></a>
          <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nine-dots shadow border" aria-labelledby="navbarDropdownNindeDots">
            <div class="card bg-body-emphasis position-relative border-0">
              <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 20rem;">
                <div class="row text-center align-items-center gx-0 gy-0">
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/behance.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Behance</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/google-cloud.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Cloud</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/slack.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Slack</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/gitlab.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Gitlab</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/bitbucket.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">BitBucket</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/google-drive.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Drive</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/trello.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Trello</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/figma.webp") }}" alt="" width="20" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Figma</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/twitter.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Twitter</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/pinterest.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Pinterest</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/ln.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Linkedin</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/google-maps.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Maps</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/google-photos.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Photos</p>
                    </a></div>
                  <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src=" {{ url("assets/img/nav-icons/spotify.webp") }}" alt="" width="30" />
                      <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Spotify</p>
                    </a></div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-l">
              <img class="rounded-circle" src="@if (Auth::check())
                                        {{ Auth::user()->avt_url }}
                                    @endif" alt="" />
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border" aria-labelledby="navbarDropdownUser" style="left: auto; top: 4rem; height: 210px;">
            <div class="card position-relative border-0">
              <div class="card-body p-0">
                <div class="text-center pt-4 pb-3">
                  <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="@if (Auth::check())
                                        {{ Auth::user()->avt_url }}
                                    @endif" alt="" />
                  </div>
                  <h6 class="mt-2 text-body-emphasis"> @if (Auth::check())
                    {{ Auth::user()->name }}
                    @endif
                  </h6>
                </div>
              </div>
              <div class="overflow-auto scrollbar">
                <ul class="nav d-flex flex-column mb-2 pb-1">
                  <li class="nav-item"><a class="nav-link px-3 d-block" href="{{ route('dashboard') }}"><span class="me-2 text-body align-bottom" data-feather="pie-chart"></span>Dashboard</a></li>
                </ul>
              </div>
              <div class="p-0">
                <div class="px-3">
                  <a id="logoutButton" class="btn btn-phoenix-secondary d-flex flex-center w-100" href="#">
                    <span class="me-2" data-feather="log-out"></span>Đăng xuất
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <script>
    var navbarTopShape = window.config.config.phoenixNavbarTopShape;
    var navbarPosition = window.config.config.phoenixNavbarPosition;
    var body = document.querySelector('body');
    var navbarDefault = document.querySelector('#navbarDefault');
    var navbarTop = document.querySelector('#navbarTop');
    var topNavSlim = document.querySelector('#topNavSlim');
    var navbarTopSlim = document.querySelector('#navbarTopSlim');
    var navbarCombo = document.querySelector('#navbarCombo');
    var navbarComboSlim = document.querySelector('#navbarComboSlim');
    var dualNav = document.querySelector('#dualNav');

    var documentElement = document.documentElement;
    var navbarVertical = document.querySelector('.navbar-vertical');

    if (navbarPosition === 'dual-nav') {
      topNavSlim?.remove();
      navbarTop?.remove();
      navbarTopSlim?.remove();
      navbarCombo?.remove();
      navbarComboSlim?.remove();
      navbarDefault?.remove();
      navbarVertical?.remove();
      dualNav.removeAttribute('style');
      document.documentElement.setAttribute('data-navigation-type', 'dual');

    } else if (navbarTopShape === 'slim' && navbarPosition === 'vertical') {
      navbarDefault?.remove();
      navbarTop?.remove();
      navbarTopSlim?.remove();
      navbarCombo?.remove();
      navbarComboSlim?.remove();
      topNavSlim.style.display = 'block';
      navbarVertical.style.display = 'inline-block';
      document.documentElement.setAttribute('data-navbar-horizontal-shape', 'slim');

    } else if (navbarTopShape === 'slim' && navbarPosition === 'horizontal') {
      navbarDefault?.remove();
      navbarVertical?.remove();
      navbarTop?.remove();
      topNavSlim?.remove();
      navbarCombo?.remove();
      navbarComboSlim?.remove();
      dualNav?.remove();
      navbarTopSlim.removeAttribute('style');
      document.documentElement.setAttribute('data-navbar-horizontal-shape', 'slim');
    } else if (navbarTopShape === 'slim' && navbarPosition === 'combo') {
      navbarDefault?.remove();
      navbarTop?.remove();
      topNavSlim?.remove();
      navbarCombo?.remove();
      navbarTopSlim?.remove();
      dualNav?.remove();
      navbarComboSlim.removeAttribute('style');
      navbarVertical.removeAttribute('style');
      document.documentElement.setAttribute('data-navbar-horizontal-shape', 'slim');
    } else if (navbarTopShape === 'default' && navbarPosition === 'horizontal') {
      navbarDefault?.remove();
      topNavSlim?.remove();
      navbarVertical?.remove();
      navbarTopSlim?.remove();
      navbarCombo?.remove();
      navbarComboSlim?.remove();
      dualNav?.remove();
      navbarTop.removeAttribute('style');
      document.documentElement.setAttribute('data-navigation-type', 'horizontal');
    } else if (navbarTopShape === 'default' && navbarPosition === 'combo') {
      topNavSlim?.remove();
      navbarTop?.remove();
      navbarTopSlim?.remove();
      navbarDefault?.remove();
      navbarComboSlim?.remove();
      dualNav?.remove();
      navbarCombo.removeAttribute('style');
      navbarVertical.removeAttribute('style');
      document.documentElement.setAttribute('data-navigation-type', 'combo');
    } else {
      topNavSlim?.remove();
      navbarTop?.remove();
      navbarTopSlim?.remove();
      navbarCombo?.remove();
      navbarComboSlim?.remove();
      dualNav?.remove();
      navbarDefault.removeAttribute('style');
      navbarVertical.removeAttribute('style');
    }

    var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
    var navbarTop = document.querySelector('.navbar-top');
    if (navbarTopStyle === 'darker') {
      navbarTop.setAttribute('data-navbar-appearance', 'darker');
    }

    var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
    var navbarVertical = document.querySelector('.navbar-vertical');
    if (navbarVerticalStyle === 'darker') {
      navbarVertical.setAttribute('data-navbar-appearance', 'darker');
    }
    document.getElementById('navbarDropdownUser').addEventListener('click', function(event) {
      event.preventDefault();
      const dropdownMenu = this.nextElementSibling;
      dropdownMenu.classList.toggle('show');
    });


    document.addEventListener('click', function(event) {
      const dropdown = document.querySelector('.dropdown-menu');
      if (!dropdown.contains(event.target) && !event.target.matches('#navbarDropdownUser')) {
        dropdown.classList.remove('show');
      }
    });

    document.getElementById('logoutButton').addEventListener('click', function() {
      logout();
    })

    async function logout() {
      try {
        const response = await fetch('/api/logout', { 
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
        });

        const data = await response.json();

        if (response.ok) {
          await localStorage.removeItem('token');
          window.location.href = data.redirect; 
        } else {
          console.error('Logout failed:', data.error);
        }
      } catch (error) {
        console.error('Error during logout:', error);
      }
    }
  </script>
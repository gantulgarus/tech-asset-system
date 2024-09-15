@extends('layouts.admin')

@section('content')
<div class="container-lg px-4">
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white bg-primary">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $stationCount }}</div>
                        <div>Дэд станц</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button"
                            data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                href="#">Action</a><a class="dropdown-item" href="#">Another
                                action</a><a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $equipmentCount }}</div>
                        <div>Тоноглол</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button"
                            data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                href="#">Action</a><a class="dropdown-item" href="#">Another
                                action</a><a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white bg-warning">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $powerlineCount }}</div>
                        <div>ЦДАШ</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button"
                            data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                href="#">Action</a><a class="dropdown-item" href="#">Another
                                action</a><a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3" style="height:70px;">
                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white bg-danger">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $userCount }}</div>
                        <div>Хэрэглэгч</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button"
                            data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                href="#">Action</a><a class="dropdown-item" href="#">Another
                                action</a><a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

    <div class="row row-cols-2">
        <div class="col">
          <div class="card mb-4">
            <div class="card-header"><strong>Тасралт</strong><span class="small ms-1"></span></div>
            <div class="card-body">
              <div class="example">
                <div class="c-chart-wrapper">
                    <canvas id="canvas-1"></canvas>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4">
            <div class="card-header"><strong>Насжилт</strong><span class="small ms-1">Тоноглол</span></div>
            <div class="card-body">
              <div class="example">
                <div class="c-chart-wrapper">
                    <canvas id="canvas-2"></canvas>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4">
            <div class="card-header"><strong>Таслалт</strong><span class="small ms-1">Doughnut</span></div>
            <div class="card-body">
              <div class="example">
                <div class="c-chart-wrapper">
                    <canvas id="canvas-3"></canvas>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4">
            <div class="card-header"><strong>Гэмтэл</strong><span class="small ms-1">Radar</span></div>
            <div class="card-body">
              <div class="example">
                <div class="c-chart-wrapper">
                    <canvas id="canvas-4"></canvas>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4">
            <div class="card-header"><strong>Chart</strong><span class="small ms-1">Pie</span></div>
            <div class="card-body">
              <div class="example">
                <div class="c-chart-wrapper">
                    <canvas id="canvas-5"></canvas>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4">
            <div class="card-header"><strong>Гэмтэл</strong><span class="small ms-1">Polar Area</span></div>
            <div class="card-body">
              <div class="example">
                <div class="c-chart-wrapper">
                    <canvas id="canvas-6"></canvas>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- /.row-->
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Traffic &amp; Sales</div>
                <div class="card-body">
                    <!-- /.row--><br>
                    <div class="table-responsive">
                        <table class="table border mb-0">
                            <thead class="fw-semibold text-nowrap">
                                <tr class="align-middle">
                                    <th class="bg-body-secondary text-center">
                                        <svg class="icon">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people">
                                            </use>
                                        </svg>
                                    </th>
                                    <th class="bg-body-secondary">User</th>
                                    <th class="bg-body-secondary text-center">Country</th>
                                    <th class="bg-body-secondary">Usage</th>
                                    <th class="bg-body-secondary text-center">Payment Method</th>
                                    <th class="bg-body-secondary">Activity</th>
                                    <th class="bg-body-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                src="assets/img/avatars/1.jpg" alt="user@email.com"><span
                                                class="avatar-status bg-success"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Yiorgos Avraamu</div>
                                        <div class="small text-body-secondary text-nowrap"><span>New</span>
                                            | Registered: Jan 1, 2023</div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-us">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <div class="fw-semibold">50%</div>
                                            <div class="text-nowrap small text-body-secondary ms-3">Jun 11,
                                                2023 - Jul 10, 2023</div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-mastercard">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="small text-body-secondary">Last login</div>
                                        <div class="fw-semibold text-nowrap">10 sec ago</div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-transparent p-0" type="button"
                                                data-coreui-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options">
                                                    </use>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"><a
                                                    class="dropdown-item" href="#">Info</a><a
                                                    class="dropdown-item" href="#">Edit</a><a
                                                    class="dropdown-item text-danger"
                                                    href="#">Delete</a></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                src="assets/img/avatars/2.jpg"
                                                alt="user@email.com"><span
                                                class="avatar-status bg-danger"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Avram Tarasios</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>Recurring</span> | Registered: Jan 1, 2023</div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-br">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <div class="fw-semibold">10%</div>
                                            <div class="text-nowrap small text-body-secondary ms-3">Jun
                                                11, 2023 - Jul 10, 2023</div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: 10%" aria-valuenow="10"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-visa">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="small text-body-secondary">Last login</div>
                                        <div class="fw-semibold text-nowrap">5 minutes ago</div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-transparent p-0" type="button"
                                                data-coreui-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options">
                                                    </use>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"><a
                                                    class="dropdown-item" href="#">Info</a><a
                                                    class="dropdown-item" href="#">Edit</a><a
                                                    class="dropdown-item text-danger"
                                                    href="#">Delete</a></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                src="assets/img/avatars/3.jpg"
                                                alt="user@email.com"><span
                                                class="avatar-status bg-warning"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Quintin Ed</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>New</span> | Registered: Jan 1, 2023</div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-in">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <div class="fw-semibold">74%</div>
                                            <div class="text-nowrap small text-body-secondary ms-3">Jun
                                                11, 2023 - Jul 10, 2023</div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: 74%" aria-valuenow="74"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-stripe">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="small text-body-secondary">Last login</div>
                                        <div class="fw-semibold text-nowrap">1 hour ago</div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-transparent p-0" type="button"
                                                data-coreui-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options">
                                                    </use>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"><a
                                                    class="dropdown-item" href="#">Info</a><a
                                                    class="dropdown-item" href="#">Edit</a><a
                                                    class="dropdown-item text-danger"
                                                    href="#">Delete</a></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                src="assets/img/avatars/4.jpg"
                                                alt="user@email.com"><span
                                                class="avatar-status bg-secondary"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Enéas Kwadwo</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>New</span> | Registered: Jan 1, 2023</div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-fr">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <div class="fw-semibold">98%</div>
                                            <div class="text-nowrap small text-body-secondary ms-3">Jun
                                                11, 2023 - Jul 10, 2023</div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: 98%" aria-valuenow="98"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-paypal">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="small text-body-secondary">Last login</div>
                                        <div class="fw-semibold text-nowrap">Last month</div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-transparent p-0" type="button"
                                                data-coreui-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options">
                                                    </use>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"><a
                                                    class="dropdown-item" href="#">Info</a><a
                                                    class="dropdown-item" href="#">Edit</a><a
                                                    class="dropdown-item text-danger"
                                                    href="#">Delete</a></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                src="assets/img/avatars/5.jpg"
                                                alt="user@email.com"><span
                                                class="avatar-status bg-success"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Agapetus Tadeáš</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>New</span> | Registered: Jan 1, 2023</div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-es">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <div class="fw-semibold">22%</div>
                                            <div class="text-nowrap small text-body-secondary ms-3">Jun
                                                11, 2023 - Jul 10, 2023</div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: 22%" aria-valuenow="22"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-apple-pay">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="small text-body-secondary">Last login</div>
                                        <div class="fw-semibold text-nowrap">Last week</div>
                                    </td>
                                    <td>
                                        <div class="dropdown dropup">
                                            <button class="btn btn-transparent p-0" type="button"
                                                data-coreui-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options">
                                                    </use>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"><a
                                                    class="dropdown-item" href="#">Info</a><a
                                                    class="dropdown-item" href="#">Edit</a><a
                                                    class="dropdown-item text-danger"
                                                    href="#">Delete</a></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                src="assets/img/avatars/6.jpg"
                                                alt="user@email.com"><span
                                                class="avatar-status bg-danger"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Friderik Dávid</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>New</span> | Registered: Jan 1, 2023</div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-pl">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <div class="fw-semibold">43%</div>
                                            <div class="text-nowrap small text-body-secondary ms-3">Jun
                                                11, 2023 - Jul 10, 2023</div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 43%" aria-valuenow="43"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-amex">
                                            </use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="small text-body-secondary">Last login</div>
                                        <div class="fw-semibold text-nowrap">Yesterday</div>
                                    </td>
                                    <td>
                                        <div class="dropdown dropup">
                                            <button class="btn btn-transparent p-0" type="button"
                                                data-coreui-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options">
                                                    </use>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"><a
                                                    class="dropdown-item" href="#">Info</a><a
                                                    class="dropdown-item" href="#">Edit</a><a
                                                    class="dropdown-item text-danger"
                                                    href="#">Delete</a></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div> --}}
    <!-- /.row-->
</div>
@endsection

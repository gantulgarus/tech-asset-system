<style>
    .card {
        min-height: 200px; /* Adjust based on your design */
    }
</style>
@extends('layouts.admin')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-md-4">
                <form method="GET" action="{{ route('home') }}">
                    <select id="branch_id" name="branch_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Бүх салбар</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $branchId == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            {{-- <div class="row d-flex mt-4">
                <div class="col-sm-6 col-xl-3 d-flex">
                    <div class="card text-white bg-primary w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $stationCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $stationCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Дэд станцын тоо</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 d-flex">
                    <div class="card text-white bg-info w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ number_format($totalCapacityUser) }} kBA</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ number_format($totalCapacityOwn) }} kBA</div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            <div>Суурьлагдсан хүчин чадал</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 d-flex">
                    <div class="card text-white bg-warning w-100">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-6 fw-semibold">ЦДАШ - {{ number_format($powerlineLength, 2) }} км</div>
                                <div class="fs-6 fw-semibold">ЦДКШ - {{ number_format($powercableLength, 2) }} км</div>
                            </div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            <div>ЦДАШ, ЦДКШ-ын урт</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 d-flex">
                    <div class="card text-white bg-danger w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $baiguulamjCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $baiguulamjCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Дэд өртөөний тоо</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 d-flex">
                    <div class="card text-white bg-danger w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $baiguulamjCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $baiguulamjCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Хуваарилах байгууламжийн тоо</div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="row d-flex mt-4">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="card text-white bg-primary" style="width: 19%;">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $stationCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $stationCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Дэд станцын тоо</div>
                        </div>
                    </div>
                    <div class="card text-white bg-danger" style="width: 19%;">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $ortooCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $ortooCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Дэд өртөөний тоо</div>
                        </div>
                    </div>
                    <div class="card text-white bg-success" style="width: 19%;">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $baiguulamjCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $baiguulamjCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Хуваарилах байгууламжийн тоо</div>
                        </div>
                    </div>
                    <div class="card text-white bg-info" style="width: 19%;">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ number_format($totalCapacityUser) }} kBA</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ number_format($totalCapacityOwn) }} kBA</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div>Суурьлагдсан хүчин чадал</div>
                        </div>
                    </div>
                    <div class="card text-white bg-warning" style="width: 19%;">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">ЦДАШ - {{ number_format($powerlineLength, 2) }} км</div>
                            <div class="fs-6 fw-semibold">ЦДКШ - {{ number_format($powercableLength, 2) }} км</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div>ЦДАШ, ЦДКШ-ын урт</div>
                        </div>
                    </div>
                    
                </div>
            </div> --}}
            <div class="row g-3">
                <div class="col-12 col-md-6 col-xl-2">
                    <div class="card text-white bg-primary w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $stationCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $stationCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Дэд станцын тоо</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-2">
                    <div class="card text-white bg-danger w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $baiguulamjCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $baiguulamjCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Дэд өртөөний тоо</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-2">
                    <div class="card text-white bg-success w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ $ortooCountUser }}</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ $ortooCountOwn }}</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div class="">Хуваарилах байгууламжийн тоо</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-2">
                    <div class="card text-white bg-info w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">Хэрэглэгчийн - {{ number_format($totalCapacityUser) }} kBA</div>
                            <div class="fs-6 fw-semibold">Өөрийн - {{ number_format($totalCapacityOwn) }} kBA</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div>Суурьлагдсан хүчин чадал</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-2">
                    <div class="card text-white bg-warning w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">{{ number_format($powerlineLength, 2) }} км</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div>ЦДАШ урт</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-2">
                    <div class="card text-white bg-secondary w-100">
                        <div class="card-body">
                            <div class="fs-6 fw-semibold">{{ number_format($powercableLength, 2) }} км</div>
                        </div>
                        <div class="mt-3 mx-3" style="height:70px;">
                            <div>ЦДКШ урт</div>
                        </div>
                    </div>
                </div>
            </div>
            
            
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
                    <div class="card-header"><strong>Тоноглолын насжилт</strong></div>
                    <div class="card-body">
                        <div class="example">
                            <div class="c-chart-wrapper">
                                <canvas id="canvas-2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Захиалгын мэдээ</div>
                    <div class="card-body">
                        <!-- /.row--><br>
                        <div class="table-responsive">
                            <table class="table border mb-0" style="font-size: 12px;">
                                <thead class="fw-semibold">
                                    <tr class="align-middle">
                                        <th class="bg-body-secondary">Д/д</th>
                                        <th class="bg-body-secondary">Салбар</th>
                                        <th class="bg-body-secondary">Төрөл</th>
                                        <th class="bg-body-secondary">Дугаар</th>
                                        <th class="bg-body-secondary">Төлөв</th>
                                        <th class="bg-body-secondary">Огноо</th>
                                        <th class="bg-body-secondary">Дэд станц, шугам тоноглолын нэр</th>
                                        <th class="bg-body-secondary">Захиалгын агуулга</th>
                                        <th class="bg-body-secondary">Таслах өдөр, цаг</th>
                                        <th class="bg-body-secondary">Залгах өдөр, цаг</th>
                                        <th class="bg-body-secondary">Хүлээн авсан</th>
                                        <th class="bg-body-secondary">Захиалга баталсан</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderJournals as $orderJournal)
                                        <tr class="align-middle">
                                            <td>{{ $orderJournal->id }}</td>
                                            <td>{{ $orderJournal->branch->name }}</td>
                                            <td>{{ $orderJournal->orderType->name }}</td>
                                            <td>{{ $orderJournal->order_number }}</td>
                                            <td>
                                                @php
                                                    // Set the badge class based on order_status_id
                                                    switch ($orderJournal->order_status_id) {
                                                        case 1: // Example status for 'primary'
                                                            $badgeClass = 'text-bg-primary text-white';
                                                            break;
                                                        case 2: // Example status for 'info'
                                                            $badgeClass = 'text-bg-info text-white';
                                                            break;
                                                        case 3: // Example status for 'success'
                                                            $badgeClass = 'text-bg-success text-white';
                                                            break;
                                                        case 4: // Example status for 'success'
                                                            $badgeClass = 'text-bg-danger text-white';
                                                            break;
                                                        default:
                                                            // Default status
                                                            $badgeClass = 'text-bg-secondary text-white';
                                                            break;
                                                    }
                                                @endphp
                                                <span
                                                    class="badge {{ $badgeClass }}">{{ $orderJournal->orderStatus->name }}</span>
                                            </td>
                                            <td>{{ $orderJournal->created_at }}</td>
                                            <td>{{ $orderJournal->station?->name . ', ' . $orderJournal->equipment?->name }}
                                            </td>
                                            <td>{{ $orderJournal->content }}</td>
                                            <td>{{ $orderJournal->start_date }}</td>
                                            <td>{{ $orderJournal->end_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('canvas-1').getContext('2d');

            // Labels for the months (coming from the controller)
            const labels = @json($labels);

            // Data (outage counts) coming from the controller
            const dataOutages = @json($dataOutages);
            const dataCuts = @json($dataCuts);
            const dataFailures = @json($dataFailures);

            // Initialize Chart.js
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Тасралт',
                            data: dataOutages,
                            fill: false,
                            borderWidth: 2
                        },
                        {
                            label: 'Таслалт',
                            data: dataCuts,
                            fill: false,
                            borderWidth: 2
                        },
                        {
                            label: 'Гэмтэл',
                            data: dataFailures,
                            fill: false,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            /* ================ Tonogloliin nasjiltiin chart ====================== */


            const ctx2 = document.getElementById('canvas-2').getContext('2d');

            // Define the labels (decades)
            const labelBars = ['2020-2029', '2010-2019', '2000-2009', '1990-1999', '1980-1989', '1970-1979'];

            // Prepare datasets for each branch
            const datasets = [];
            const branches = @json($branches); // Assume you have a collection of branches

            branches.forEach(function(branch) {
                const data = labelBars.map(decade => {
                    return @json($equipmentsByBranch)[branch.id]?.[decade] || 0; // Get count or 0
                });

                datasets.push({
                    label: branch.name, // Branch name
                    data: data, // Equipment counts per decade
                    // backgroundColor: getRandomColor(), // Random color for each branch
                });
            });

            // Create the chart
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: labelBars,
                    datasets: datasets,
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            stacked: true, // Enable stacking
                        },
                        x: {
                            stacked: true // Enable stacking
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                        },
                    },
                }
            });

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

        });
    </script>
@endsection

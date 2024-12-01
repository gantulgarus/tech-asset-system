@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        @if (session('success'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                Таслалтын график
            </div>
            <div class="card-body">
                <a href="{{ route('outage_schedules.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
                <a href="{{ route('export-outage', request()->all()) }}" class="btn btn-primary btn-sm mb-2">Экспорт</a>
                <a href="#" id="print-table" class="btn btn-secondary btn-sm mb-2">Хэвлэх</a>

                <div class="mb-2">
                    <form method="GET" action="{{ route('outage_schedules.index') }}" id="filter-form">
                        <div class="row g-2">
                            <div class="col-md-2">
                                <select name="branch_id" class="form-select form-select-sm">
                                    <option value="">Салбар</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="substation_line_equipment" name="substation_line_equipment"
                                    class="form-control form-control-sm" placeholder="Дэд станц, шугам, тоноглол"
                                    value="{{ request('substation_line_equipment') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="starttime" name="starttime" class="form-control form-control-sm"
                                    placeholder="Эхлэх" value="{{ request('starttime') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="endtime" name="endtime" class="form-control form-control-sm"
                                    placeholder="Дуусах" value="{{ request('endtime') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm">Хайх</button>
                                <button type="button" class="btn btn-secondary btn-sm" id="reset-filters">Цэвэрлэх</button>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table border mb-0" style="font-size: 12px;" id="schedule-table">
                    <thead class="fw-semibold">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">Д/д</th>
                            <th class="bg-body-secondary">Салбар</th>
                            <th class="bg-body-secondary">Дэд станц, шугам, тоноглол</th>
                            <th class="bg-body-secondary">Хийх ажлын даалгавар</th>
                            <th class="bg-body-secondary">Эхлэх огноо</th>
                            <th class="bg-body-secondary">Дуусах огноо</th>
                            <th class="bg-body-secondary">Төрөл</th>
                            <th class="bg-body-secondary">Тасрах хэрэглэгчид</th>
                            <th class="bg-body-secondary">Хариуцах албан тушаалтан</th>
                            {{-- <th class="bg-body-secondary">Боловсруулсан</th>
                            <th class="bg-body-secondary">Хянасан</th>
                            <th class="bg-body-secondary">Баталсан</th> --}}
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outageSchedules as $schedule)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $schedule->branch->name }}</td>
                                <td>{{ $schedule->substation_line_equipment }}</td>
                                <td>{{ $schedule->task }}</td>
                                <td>{{ $schedule->customDateFormat . ' ' . $schedule->startTime }}</td>
                                <td>{{ $schedule->customDateFormat . ' ' . $schedule->endTime }}</td>
                                <td>{{ $schedule->type }}</td>
                                <td>{{ $schedule->affected_users }}</td>
                                <td>{{ $schedule->responsible_officer }}</td>
                                {{-- <td>{{ $schedule->created_user }}</td>
                                <td>{{ $schedule->controlled_user }}</td>
                                <td>{{ $schedule->approved_user }}</td> --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <svg class="icon">
                                                <use
                                                    xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-options') }}">
                                                </use>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="{{ route('outage_schedules.edit', $schedule) }}">Засах</a>
                                            <form action="{{ route('outage_schedules.destroy', $schedule) }}"
                                                method="Post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn dropdown-item text-danger">
                                                    Устгах
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $outageSchedules->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#starttime').flatpickr();
            $('#endtime').flatpickr();

            $('#reset-filters').on('click', function() {
                // Clear all the input fields
                $('#filter-form').find('input[type="text"], select').val('');
                // Submit the form to reload without filters
                $('#filter-form').submit();
            });

            // Print functionality
            $('#print-table').on('click', function(e) {
                e.preventDefault();

                // Clone the table and remove the last column (action buttons)
                const table = document.querySelector('table');
                const tableClone = table.cloneNode(true); // Clone the table
                const rows = tableClone.querySelectorAll('tr'); // Get all rows

                // Iterate over each row and remove the last column
                rows.forEach(row => {
                    const lastCell = row.querySelector('td:last-child, th:last-child');
                    if (lastCell) {
                        row.removeChild(lastCell);
                    }
                });

                const currentDate = new Date().toISOString().slice(0, 10);


                // Prepare custom content for the print
                const printContent = `
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                        <img src="/images/logo.png" alt="Logo" style="width: 100px; height: auto;">
                        <div style="text-align: right; font-size: 12px;">
                            <p>БАТЛАВ</p>
                            <p>"БАГАНУУР ЗҮҮН ӨМНӨД БҮСИЙН ЦАХИЛГААН</p>
                            <p>ТҮГЭЭХ СҮЛЖЭЭ" ТӨХК-ИЙН ЕРӨНХИЙ ИНЖЕНЕР </p>
                            <p>А.АЗБАЯР </p>
                            <br>
                            <p>...... оны ..... дугаар сарын .....</p>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center;">
                        <h3>Таслалтын график</h3>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                        <div style="text-align: left; font-size: 12px;">
                            <p>${currentDate}</p>
                        </div>
                        <div style="text-align: right; font-size: 12px;">
                            <p>Багануур дүүрэг</p>
                        </div>
                    </div>
                    ${tableClone.outerHTML}
                `;

                // Get the original content and prepare the print layout
                const originalContent = document.body.innerHTML;

                // Open a new window for printing
                const printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Таслалтын график - Print</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 1rem;
                            }
                            th, td {
                                border: 1px solid #ddd;
                                padding: 8px;
                                text-align: left;
                            }
                            th {
                                background-color: #f4f4f4;
                            }
                            h2 {
                                margin-bottom: 0;
                            }
                            p {
                                margin: 4px 0;
                            }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                    </html>
                `);
                printWindow.document
            .close(); // Close the document to ensure styles and content are ready for print

                // Trigger the print dialog for the new window
                printWindow.print();
            });
        });
    </script>
@endsection

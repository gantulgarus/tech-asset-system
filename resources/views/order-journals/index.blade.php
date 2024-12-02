@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h3>Захиалгын бүртгэл</h3>


        @if (session('success'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <a href="{{ route('order-journals.create') }}" class="btn btn-dark btn-sm mb-2">Захиалга бүртгэх</a>
                <a href="{{ route('export-order-journal') }}" class="btn btn-primary btn-sm mb-2">Экспорт</a>
                <div class="mb-2">
                    <form method="GET" action="{{ route('order-journals.index') }}" id="filter-form">
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
                                <select name="order_type_id" class="form-select form-select-sm">
                                    <option value="">Төрөл</option>
                                    @foreach ($orderTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('order_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                <table class="table border mb-0" style="font-size: 12px;">
                    <thead class="fw-semibold">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">Д/д</th>
                            <th class="bg-body-secondary">Салбар</th>
                            <th class="bg-body-secondary">Төрөл</th>
                            <th class="bg-body-secondary">Захиалгын дугаар</th>
                            <th class="bg-body-secondary">Төлөв</th>
                            <th class="bg-body-secondary">Огноо</th>
                            <th class="bg-body-secondary">Дэд станц, шугам тоноглолын нэр</th>
                            <th class="bg-body-secondary">Захиалгын агуулга</th>
                            <th class="bg-body-secondary">Таслах өдөр, цаг</th>
                            <th class="bg-body-secondary">Залгах өдөр, цаг</th>
                            <th class="bg-body-secondary">Захиалга дамжуулсан ажилтны нэр</th>
                            {{-- <th class="bg-body-secondary">Хүлээн авсан</th>
                            <th class="bg-body-secondary">Захиалга баталсан</th> --}}
                            <th class="bg-body-secondary">Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderJournals as $orderJournal)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
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
                                    <span class="badge {{ $badgeClass }}">{{ $orderJournal->orderStatus->name }}</span>
                                </td>
                                <td>{{ $orderJournal->created_at }}</td>
                                <td>{{ $orderJournal->station?->name . ', ' . $orderJournal->equipment?->name }}</td>
                                <td>{{ $orderJournal->content }}</td>
                                <td>{{ $orderJournal->start_date }}</td>
                                <td>{{ $orderJournal->end_date }}</td>
                                <td>{{ $orderJournal->transferred_by }}</td>
                                {{-- <td>{{ $orderJournal->received_at . ': ' . $orderJournal->receivedUser?->name }}</td>
                                <td>{{ $orderJournal->approved_at . ': ' . $orderJournal->approvedUser?->name }}</td> --}}
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
                                            <button class="dropdown-item"
                                                onclick="openStatusModal({{ $orderJournal->id }}, 2)"
                                                {{ in_array($orderJournal->order_status_id, [2, 3]) ? 'disabled' : '' }}>
                                                Хүлээн авах</button>
                                            <button class="dropdown-item"
                                                onclick="openStatusModal({{ $orderJournal->id }}, 3)"
                                                {{ $orderJournal->order_status_id == 3 ? 'disabled' : '' }}
                                                >Батлах</button>
                                            <button class="dropdown-item"
                                                onclick="loadStatusChanges({{ $orderJournal->id }}, 3)">Төлөв
                                                харах</button>
                                            @if (!in_array($orderJournal->order_status_id, [2, 3]))    
                                            <a class="dropdown-item"
                                                href="{{ route('order-journals.edit', $orderJournal) }}">Засах</a>
                                            <form action="{{ route('order-journals.destroy', $orderJournal) }}"
                                                method="Post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn dropdown-item text-danger">
                                                    Устгах
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Төлөв солих цонх --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="status-form" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Статус өөрчлөх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="order_status_id" id="order_status_id">
                        <input type="hidden" name="order_journal_id" id="order_journal_id">
                        <div class="mb-3">
                            <label for="comment" class="form-label">Тайлбар</label>
                            <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Тайлбараа оруулна уу"
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Болих</button>
                        <button type="submit" class="btn btn-primary">Хадгалах</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Төлөв харах цонх --}}
    <div class="modal fade" id="statusChangesModal" tabindex="-1" aria-labelledby="statusChangesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusChangesModalLabel">Явцын тэмдэглэл</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Огноо</th>
                                <th>Төлөв</th>
                                <th>Тайлбар</th>
                                <th>Нэр</th>
                            </tr>
                        </thead>
                        <tbody id="statusChangesTableBody">
                            <!-- Data will be dynamically populated -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Хаах</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openStatusModal(orderJournalId, statusId) {
            // Set values in the modal
            $('#order_status_id').val(statusId);
            $('#order_journal_id').val(orderJournalId);
            $('#comment').val('');
            // Show the modal
            $('#statusModal').modal('show');
        }

        $('#status-form').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = '{{ route('order-update-status') }}'; // Adjust to your route
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Handle success
                    $('#statusModal').modal('hide');
                    alert(response.message);
                    location.reload(); // Reload the page to reflect changes
                },
                error: function(xhr) {
                    // Handle error
                    alert('Алдаа гарлаа. Дахин оролдоно уу.');
                }
            });
        });

        function loadStatusChanges(orderJournalId) {
            const tableBody = document.getElementById('statusChangesTableBody');
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';

            $('#statusChangesModal').modal('show');

            fetch(`/order-journals/${orderJournalId}/status-changes`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(change => {
                            const row = `
                        <tr>
                            <td>${new Date(change.created_at).toISOString().slice(0, 16).replace('T', ' ')}</td>
                            <td>${change.status.name}</td>
                            <td>${change.comment}</td>
                            <td>${change.changed_by.division} ${change.changed_by.name}</td>
                        </tr>`;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML =
                            '<tr><td colspan="4" class="text-center">Хоосон байна.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error loading status changes:', error);
                    tableBody.innerHTML =
                        '<tr><td colspan="4" class="text-center text-danger">Өгөгдөл татахад алдаа гарлаа.</td></tr>';
                });
        }

        $(document).ready(function() {
            $('#starttime').flatpickr();
            $('#endtime').flatpickr();

            $('#reset-filters').on('click', function() {
                // Clear all the input fields
                $('#filter-form').find('input[type="text"], select').val('');
                // Submit the form to reload without filters
                $('#filter-form').submit();
            });
        });

    </script>
@endsection

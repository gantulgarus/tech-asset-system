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

            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">№</th>
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
                        <th class="bg-body-secondary">Үйлдэл</th>
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
                                    case 1:  // Example status for 'primary'
                                        $badgeClass = 'text-bg-primary text-white';
                                        break;
                                    case 2:  // Example status for 'info'
                                        $badgeClass = 'text-bg-info text-white';
                                        break;
                                    case 3:  // Example status for 'success'
                                        $badgeClass = 'text-bg-success text-white';
                                        break;
                                    case 4:  // Example status for 'success'
                                        $badgeClass = 'text-bg-danger text-white';
                                        break;
                                    default: // Default status
                                        $badgeClass = 'text-bg-secondary text-white';
                                        break;
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $orderJournal->orderStatus->name }}</span>
                        </td>
                        <td>{{ $orderJournal->created_at }}</td>
                        <td>{{ $orderJournal->station->name . ", " . $orderJournal->equipment->name }}</td>
                        <td>{{ $orderJournal->content }}</td>
                        <td>{{ $orderJournal->start_date }}</td>
                        <td>{{ $orderJournal->end_date }}</td>
                        <td>{{ $orderJournal->received_at . ": " . $orderJournal->receivedUser?->name }}</td>
                        <td>{{ $orderJournal->approved_at . ": " . $orderJournal->approvedUser?->name }}</td>
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
                                    
                                    <!-- Receive Button with Confirmation -->
                                    <button class="dropdown-item" onclick="confirmReceive({{ $orderJournal->id }})">Хүлээн авах</button>
                                    <!-- Approve Button with Confirmation -->
                                    <button class="dropdown-item" onclick="confirmApprove({{ $orderJournal->id }})">Батлах</button>
                                    <!-- Cancel Button with Confirmation -->
                                    <button class="dropdown-item" onclick="confirmCancel({{ $orderJournal->id }})">Цуцлах</button>


                                    <form id="receive-form-{{ $orderJournal->id }}" action="{{ route('order-journals.receive', $orderJournal) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <!-- Hidden field to set the status to 2 -->
                                        <input type="hidden" name="order_status_id" value="2">
                                    </form>

                                    <form id="approve-form-{{ $orderJournal->id }}" action="{{ route('order-journals.approve', $orderJournal) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <!-- Hidden field to set the status to 3 (Approve) -->
                                        <input type="hidden" name="order_status_id" value="3">
                                    </form>

                                    <form id="cancel-form-{{ $orderJournal->id }}" action="{{ route('order-journals.cancel', $orderJournal) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <!-- Hidden field to set the status to 4 (Cancel) -->
                                        <input type="hidden" name="order_status_id" value="4">
                                    </form>

                                    <a class="dropdown-item" href="{{ route('order-journals.edit', $orderJournal) }}">Засах</a>
                                    <form action="{{ route('order-journals.destroy', $orderJournal) }}" method="Post">
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    function confirmReceive(orderJournalId) {
        // Show confirmation dialog
        if (confirm('Are you sure you want to receive this order?')) {
            // If user clicks "Yes", submit the form to update order_status_id to 2
            document.getElementById('receive-form-' + orderJournalId).submit();
        }
    }

    function confirmApprove(orderJournalId) {
        // Show confirmation dialog for "Approve"
        if (confirm('Are you sure you want to approve this order?')) {
            // If user clicks "Yes", submit the form to update order_status_id to 3
            document.getElementById('approve-form-' + orderJournalId).submit();
        }
    }

    function confirmCancel(orderJournalId) {
        // Show confirmation dialog for "Cancel"
        if (confirm('Are you sure you want to cancel this order?')) {
            document.getElementById('cancel-form-' + orderJournalId).submit();
        }
    }

</script>
@endsection

<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('equipment-history.create', $equipment->id) }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
    <div class="row">
        <div class="col">
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">№</th>
                        <th class="bg-body-secondary">Тоноглол</th>
                        <th class="bg-body-secondary">Ажлын төрөл</th>
                        <th class="bg-body-secondary">Огноо</th>
                        <th class="bg-body-secondary">Хийгдсэн ажил</th>
                        <th class="bg-body-secondary">Бригад</th>
                        <th class="bg-body-secondary">Бүртгэсэн</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipmentHistories as $history)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $history->equipment->name }}</td>
                            <td>{{ $history->work_type }}</td>
                            <td>{{ $history->task_date }}</td>
                            <td>{{ $history->completed_task }}</td>
                            <td>{{ $history->team_members }}</td>
                            <td>{{ $history->user->name }}</td>
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
                                        <a class="dropdown-item" href="{{ route('equipment-histories.edit', $history) }}">Засах</a>
                                        <form action="{{ route('equipment-histories.destroy', $history) }}" method="Post">
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
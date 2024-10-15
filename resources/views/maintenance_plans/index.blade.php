<div>
    <h5>Их ба Урсгал засварын ажлын олон жилийн график</h5>
    <a href="{{ route('maintenance-plans.create', $equipment->id) }}" class="btn btn-primary btn-sm">Нэмэх</a>
    <table class="table table-border">
        <thead>
            <tr>
                <th>Тоноглол</th>
                <th>Жил</th>
                <th>Төрөл</th>
                <th>Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($maintenancePlans as $plan)
            <tr>
                <td>{{ $plan->equipment->name }}</td>
                <td>{{ $plan->year }}</td>
                <td>{{ $plan->workType->name }}</td>
                <td>
                    <a href="{{ route('maintenance-plans.edit', $plan) }}" class="btn btn-warning btn-sm">Засах</a>
                    <form action="{{ route('maintenance-plans.destroy', $plan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-sm">Устгах</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

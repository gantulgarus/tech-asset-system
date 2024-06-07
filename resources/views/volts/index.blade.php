<div class="mt-4">
    <button class="btn btn-dark mb-2" data-coreui-toggle="modal" data-coreui-target="#voltsModal" onclick="openCreateModal()">Нэмэх</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 50px;">№</th>
                <th>Нэр</th>
                <th width="280px">Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($volts as $volt)
                <tr>
                    <td>{{ $volt->id }}</td>
                    <td>{{ $volt->name }}кВ</td>
                    <td>
                        {{-- <a class="btn btn-primary" href="{{ route('volts.edit', $volt->id) }}">Засах</a> --}}
                        <div class="d-inline-flex">
                            <button class="btn btn-sm btn-warning me-2" data-coreui-toggle="modal" data-coreui-target="#voltsModal" onclick="openEditModal({{ $volt }})">Засах</button>
                            <form action="{{ route('volts.destroy', $volt) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger text-white">Устгах</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- CoreUI Modal -->
<div class="modal fade" id="voltsModal" tabindex="-1" aria-labelledby="voltsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="voltsForm" method="POST" action="{{ route('volts.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="voltsModalLabel">Хүчдлийн түвшин /кВ/</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="voltId" name="id">
                    <div class="mb-3">
                        <label for="voltLevel" class="form-label">Нэр</label>
                        <input type="text" class="form-control" id="voltLevel" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Хаах</button>
                    <button type="submit" class="btn btn-primary">Хадгалах</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('voltsForm').action = '{{ route('volts.store') }}';
        document.getElementById('voltId').value = '';
        document.getElementById('voltLevel').value = '';
        document.getElementById('voltsModalLabel').innerText = 'Хүчдлийн түвшин нэмэх';
    }

    function openEditModal(voltage) {
        document.getElementById('voltsForm').action = '{{ route('volts.update', '') }}/' + voltage.id;
        document.getElementById('voltId').value = voltage.id;
        document.getElementById('voltLevel').value = voltage.name;
        document.getElementById('voltsModalLabel').innerText = 'Хүчдлийн түвшин засах';
        form.querySelector('input[name="_method"]').value = 'PUT';
    }
</script>
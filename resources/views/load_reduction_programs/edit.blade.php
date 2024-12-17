@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>ААН-үүдийг ачаалал хөнгөлөх хөтөлбөр - Засвар</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('load-reduction-programs.update', $loadReductionProgram) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- This is important for updating the resource -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client_organization_id" class="form-label">Хэрэглэгч ААН-ийн нэр</label>
                                <div class="form-group mb-3">
                                    <select id="client-dropdown" name="client_organization_id" class="form-select">
                                        <option></option>
                                        @foreach ($clientOrgs as $org)
                                        <option value="{{$org->id}}" {{ $org->id == $loadReductionProgram->client_organization_id ? 'selected' : '' }}>
                                            {{$org->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('client_organization_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pre_reduction_capacity" class="form-label">Ачаалал хөнгөлөхийн өмнөх чадал, (МВт)</label>
                                <input type="number" step="any" name="pre_reduction_capacity" class="form-control" id="pre_reduction_capacity" value="{{ old('pre_reduction_capacity', $loadReductionProgram->pre_reduction_capacity) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reduction_time" class="form-label">Ачаалал хөнгөлсөн цаг</label>
                                <input type="datetime-local" name="reduction_time" class="form-control" id="reduction_time" value="{{ old('reduction_time', $loadReductionProgram->reduction_time) }}" onchange="calculateEnergyNotSupplied()">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reduced_capacity" class="form-label">Хөнгөлсөн чадал, (МВт)</label>
                                <input type="number" step="any" name="reduced_capacity" class="form-control" id="reduced_capacity" value="{{ old('reduced_capacity', $loadReductionProgram->reduced_capacity) }}" onchange="calculateEnergyNotSupplied()">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post_reduction_capacity" class="form-label">Ачаалал хөнгөлсний дараах чадал, (МВт)</label>
                                <input type="number" step="any" name="post_reduction_capacity" class="form-control" id="post_reduction_capacity" value="{{ old('post_reduction_capacity', $loadReductionProgram->post_reduction_capacity) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="restoration_time" class="form-label">Ачаалал авсан цаг</label>
                                <input type="datetime-local" name="restoration_time" class="form-control" value="{{ old('restoration_time', $loadReductionProgram->restoration_time) }}" id="restoration_time" onchange="calculateEnergyNotSupplied()">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="energy_not_supplied" class="form-label">Дутуу түгээсэн ЦЭХ (кВт.ц)</label>
                                <input type="number" step="any" name="energy_not_supplied" class="form-control" value="{{ old('energy_not_supplied', $loadReductionProgram->energy_not_supplied) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Тайлбар</label>
                                <textarea name="remarks" class="form-control" id="remarks">{{ old('remarks', $loadReductionProgram->remarks) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary ml-3">Засварлах</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function calculateEnergyNotSupplied() {
        const reductionTime = document.getElementById('reduction_time').value;
        const restorationTime = document.getElementById('restoration_time').value;
        const reducedCapacity = parseFloat(document.getElementById('reduced_capacity').value || 0);

        if (reductionTime && restorationTime && reducedCapacity) {
            const reductionDate = new Date(reductionTime);
            const restorationDate = new Date(restorationTime);

            // Calculate the difference in minutes
            const diffInMinutes = (restorationDate - reductionDate) / (1000 * 60); // Milliseconds to minutes

            if (diffInMinutes > 0) {
                // Calculate energy not supplied
                const energyNotSupplied = (diffInMinutes / 60) * reducedCapacity * 1000; // Convert minutes to hours
                document.getElementById('energy_not_supplied').value = energyNotSupplied.toFixed(2);
            } else {
                // If restoration time is earlier than reduction time
                document.getElementById('energy_not_supplied').value = '';
                alert("Restoration time must be later than reduction time.");
            }
        } else {
            // Clear the field if any value is missing
            document.getElementById('energy_not_supplied').value = '';
        }
    }

</script>
@endsection
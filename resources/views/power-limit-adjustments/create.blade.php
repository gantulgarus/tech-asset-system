@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3>Өвлийн их ачааллын онцгой үеийн хөнгөлөлт, хязгаарлалтын мэдээ нэмэх</h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('power-limit-adjustments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client_restriction_id" class="form-label">Гаргалгааны нэр</label>
                                <div class="form-group mb-3">
                                    <select id="output-dropdown" name="client_restriction_id" class="form-select">
                                        @foreach ($clients as $client)
                                        <option value="{{$client->id}}">
                                            {{$client->output_name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('client_restriction_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Тасарсан хугацаа</label>
                                <input id="start_time" type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') }}">
                                @error('start_time')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">Залгасан хугацаа</label>
                                <input id="end_time" type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time') }}">
                                @error('end_time')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_minutes" class="form-label">Тасарсан хугацаа, мин</label></label>
                                <div class="input-group mb-3">
                                    <input id="duration_minutes" type="number" step="any" name="duration_minutes" class="form-control" value="{{ old('duration_minutes') }}">
                                    <span class="input-group-text">мин</span>
                                </div>
                                @error('duration_minutes')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_hours" class="form-label">Тасарсан хугацаа, цаг</label></label>
                                <div class="input-group mb-3">
                                    <input id="duration_hours" type="number" step="any" name="duration_hours" class="form-control" value="{{ old('duration_hours') }}">
                                    <span class="input-group-text">цаг</span>
                                </div>
                                @error('duration_hours')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="voltage" class="form-label">Хүчдэл, кВ</label>
                                <div class="input-group mb-3">
                                <input type="number" step="any" name="voltage" class="form-control" value="{{ old('voltage') }}">
                                <span class="input-group-text">кВ</span>
                                </div>
                                @error('voltage')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amper" class="form-label">Гүйдэл, А</label>
                                <input type="number" step="any" name="amper" class="form-control" value="{{ old('amper') }}">
                                @error('amper')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="power" class="form-label">Чадал, МВт</label>
                                <input type="number" step="any" name="power" class="form-control" value="{{ old('power') }}">
                                @error('power')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cosf" class="form-label">Cosf</label></label>
                                <input type="number" step="any" name="cosf" class="form-control" value="{{ old('cosf') }}">
                                @error('cosf')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="energy_not_supplied" class="form-label">Дутуу түгээсэн ЦЭХ, кВт.ц</label>
                                <input type="number" step="any" name="energy_not_supplied" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_count" class="form-label">Хэрэглэгчийн тоо</label>
                                <input type="number" name="user_count" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary ml-3">Хадгалах</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const startTimeInput = document.getElementById("start_time");
        const endTimeInput = document.getElementById("end_time");
        const durationMinutesInput = document.getElementById("duration_minutes");
        const durationHoursInput = document.getElementById("duration_hours");

        function calculateDurations() {
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (startTime && endTime) {
                // Parse times into Date objects
                const start = new Date(startTime);
                const end = new Date(endTime);

                // Calculate difference in milliseconds and convert to minutes
                const diffInMilliseconds = end - start;
                const diffInMinutes = diffInMilliseconds / (1000 * 60);

                if (diffInMinutes >= 0) {
                    durationMinutesInput.value = diffInMinutes; // Keep 2 decimal places
                    durationHoursInput.value = (diffInMinutes / 60).toFixed(2); // Convert to hours
                } else {
                    alert("End time cannot be earlier than start time.");
                    durationMinutesInput.value = "";
                    durationHoursInput.value = "";
                }
            } else {
                // Clear values if times are invalid
                durationMinutesInput.value = "";
                durationHoursInput.value = "";
            }
        }

        function calculateUDE() {
            const voltage = parseFloat($('input[name="voltage"]').val()); // U
            const amperage = parseFloat($('input[name="amper"]').val());  // I
            const cosf = parseFloat($('input[name="cosf"]').val());              // cos(f)
            const duration = parseFloat($('input[name="duration_minutes"]').val());      // t in minutes

            if (!isNaN(voltage) && !isNaN(amperage) && !isNaN(cosf) && !isNaN(duration)) {
                // Convert duration from minutes to hours
                const timeInHours = duration / 60;

                // UDE Formula: U * I * cos(f) * 1.73 * t
                const udeValue = voltage * amperage * cosf * 1.73 * timeInHours;

                // Update the UDE field
                $('input[name="energy_not_supplied"]').val(udeValue.toFixed(2)); // Round to 2 decimal places
            } else {
                $('input[name="energy_not_supplied"]').val(''); // Clear the field if any value is missing
            }
        }

        // Attach event listeners to start_time and end_time inputs
        startTimeInput.addEventListener("change", () => {
            calculateDurations();
            calculateUDE();
        });
        endTimeInput.addEventListener("change", () => {
            calculateDurations();
            calculateUDE();
        });

        $(document).ready(function() {
            $('#station-dropdown').select2();

            // Attach change event handlers to the relevant fields
            $('input[name="voltage"], input[name="amper"], input[name="cosf"], input[name="duration_minutes"]').on('input', calculateUDE);

            // Recalculate UDE whenever the duration is recalculated
            $('#start_time, #end_time').on('change', function() {
                calculateDurations();
                calculateUDE();
            });

        });
    </script>
@endsection

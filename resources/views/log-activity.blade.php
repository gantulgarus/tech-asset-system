@extends('layouts.admin')

@section('content')
<div class="container-lg px-4">
    <div class="row g-4 mb-4">
        <table class="table table-bordered table-sm">
            <tr>
                <th>No</th>
                <th>Subject</th>
                <th>URL</th>
                <th>Method</th>
                <th>Ip</th>
                <th width="300px">User Agent</th>
                <th>User Id</th>
                <th>Date</th>
                {{-- <th>Action</th> --}}
            </tr>
    
            @if($logs->count())
    
                @foreach($logs as $key => $log)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $log->subject }}</td>
                    <td class="text-success">{{ $log->url }}</td>
                    <td><label class="label label-info">{{ $log->method }}</label></td>
                    <td class="text-warning">{{ $log->ip }}</td>
                    <td class="text-danger">{{ $log->agent }}</td>
                    <td>{{ $log->user_id }}</td>
                    <td>{{ $log->created_at }}</td>
                    {{-- <td><button class="btn btn-danger btn-sm">Delete</button></td> --}}
                </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
@endsection
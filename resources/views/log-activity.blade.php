@extends('layouts.admin')

@section('content')
<div class="container-lg px-4">
    <div class="row g-4 mb-4">
        <table class="table table-bordered table-sm" style="font-size: 12px;">
            <tr>
                <th>№</th>
                <th>Тайлбар</th>
                <th>URL</th>
                <th>Method</th>
                <th>IP хаяг</th>
                <th width="300px">User Agent</th>
                <th>Хэрэглэгчийн Id</th>
                <th>Хэрэглэгчийн нэр</th>
                <th>Огноо</th>
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
                    <td>{{ $log->user?->name }}</td>
                    <td>{{ $log->created_at }}</td>
                    {{-- <td><button class="btn btn-danger btn-sm">Delete</button></td> --}}
                </tr>
                @endforeach
            @endif
        </table>
        {{ $logs->links() }}
    </div>
</div>
@endsection
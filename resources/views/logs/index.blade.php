@extends('layouts.app')

@section('content')
<div class="container">
<div class="card pr-3 pl-3 pt-3">

    @if(auth()->user()->isAdmin())

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Utförare</th>
                <th scope="col">Funktion</th>
                <th scope="col">Meddelande</th>
                <th scope="col">Utfört</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($logs as $log)

                <tr>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{!! $log->message !!}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>

    {{ $logs->links() }}

    @endif
</div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">

    @if(auth()->user()->isAdmin())

    <table class="table table-striped ">
        <thead>
            <tr>
                <th scope="col">Utförare</th>
                <th scope="col">Funktion</th>
                <th scope="col">Meddelande</th>
                <th scope="col">Utförd</th>
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

    @endif

</div>
@endsection

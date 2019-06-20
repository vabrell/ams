@extends('layouts.app')

@section('content')
<div class="container">
<div class="card pr-3 pl-3 pt-3">

    <form method="POST" action="{{ route('logs.search') }}">
        @csrf

        <div class="form-group row justify-content-center">

            <div class="col-md-4">
                <input id="start" type="date" class="form-control @error('start') is-invalid @enderror" name="start" value="{{ old('start') }}">

                @error('start')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-1">
                <i class="fas fa-calendar-minus h2"></i>
            </div>

            <div class="col-4">
                <input id="end" type="date" class="form-control @error('end') is-invalid @enderror" name="end" value="{{ old('end') }}">

                @error('end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

    </form>

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

</div>
</div>
@endsection

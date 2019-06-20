@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Uppgifter</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reports.tasks.search') }}">
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
                                <th scope="col">Konsult</th>
                                <th scope="col">Uppgift</th>
                                <th scope="col">Kund</th>
                                <th scope="col">Beskrivning</th>
                                <th scope="col">Startdatum</th>
                                <th scope="col">Slutdatum</th>
                            </tr>
                        </thead>
                        <tbody>

                        @if (!empty($tasks))
                            @foreach ($tasks as $task)

                                <tr>
                                    <td>
                                        <a href="{{ route('accounts.consultants.show', $task->account->id) }}">
                                            {{ $task->account->fullname }} ({{ $task->account->company }})
                                        </a>
                                    </td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->customer->name }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->startDate }}</td>
                                    <td>{{ $task->endDate }}</td>
                                </tr>

                            @endforeach
                        @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection



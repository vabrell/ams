@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Pågående uppgifter</div>

                <div class="card-body">

                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Användarnamn</th>
                                <th scope="col">Namn</th>
                                <th scope="col">Konsultbolag</th>
                                <th scope="col">Uppgift</th>
                                <th scope="col">Kund</th>
                                <th scope="col">Beskrivning</th>
                            </tr>
                        </thead>
                        <tbody>

                        @if (!empty($tasks))
                            @foreach ($tasks as $task)

                                <tr>
                                    <td>
                                        <a href="{{ route('accounts.consultants.show', $task->account->id) }}">
                                            {{ $task->account->accountname }}
                                        </a>
                                    </td>
                                    <td>{{ $task->account->fullname }}</td>
                                    <td>{{ $task->account->company }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->customer->name }}</td>
                                    <td>{{ $task->description }}</td>
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



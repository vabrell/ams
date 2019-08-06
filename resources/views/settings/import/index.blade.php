@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Kontonamn</th>
                    <th scope="col">Namn</th>
                    <th scope="col">Beskrivning</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($ldap as $user)
                <tr>
                    <td><a href="{{ route('settings.import.show', ['account' => $user->samaccountname[0]]) }}">{{ $user->samaccountname[0] }}</a></td>
                    <td>{{ $user->displayname[0] }}</td>
                    <td>{{ $user->description[0] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection

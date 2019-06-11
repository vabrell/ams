@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Hantera konton</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('accounts.ad.search') }}">
                        @csrf

                        <div class="form-group row justify-content-center">

                            <div class="col-md-6">
                                <input id="search" type="search" class="form-control @error('search') is-invalid @enderror" name="search" value="{{ old('search') }}" autofocus>

                                @error('search')
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
                                <th scope="col">Användarnamn</th>
                                <th scope="col">Namn</th>
                                <th scope="col">Befattning</th>
                                <th scope="col">Företag</th>
                                <th scope="col">Anställningstyp</th>
                            </tr>
                        </thead>
                        <tbody>

                        @if (!empty($ldap))
                            @foreach ($ldap as $user)

                                <tr>
                                    <td>
                                        <a href="{{ route('accounts.ad.show', $user->samaccountname['0']) }}">
                                            {{ $user->samaccountname['0'] }}
                                        </a>
                                    </td>
                                    <td>{{ $user->displayname['0'] }}</td>
                                    <td>{{ $user->title['0'] }}</td>
                                    <td>{{ $user->company['0'] }}</td>
                                    <td>{{ $user->employeetype['0'] }}</td>
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



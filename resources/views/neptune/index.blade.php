@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Neptune</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">

                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <span class="h4">Avtal</span>
                                <a href="{{ route('neptune.contracts.create') }}" class="btn btn-sm btn-primary ml-3 mb-2"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="mt-3">
                                @foreach ($contracts as $contract)
                                    <p>
                                    <a href="{{ $contract->path() }}" class="text-decoration-none" >{{ $contract->code }} - {{ $contract->name }}</a>
                                    </p>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <span class="h4">Roller</span>
                            <a href="{{ route('neptune.roles.create') }}" class="btn btn-sm btn-primary ml-3 mb-2"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="mt-3">
                                    @foreach ($roles as $role)
                                        <p>
                                        <a href="{{ $role->path() }}" class="text-decoration-none" >{{ $role->name }}</a>
                                        </p>
                                    @endforeach
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

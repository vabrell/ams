@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-baseline">
                    <div class="col-lg-10">
                        <a href="{{ route('neptune.index') }}" class="btn btn-sm btn-outline-secondary border-0"><i class="fas fa-arrow-circle-left"></i></a>
                        Roll: {{ $role->name }}
                    </div>
                    <div class="col-lg-1">
                    <a href="{{ route('neptune.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary border-0 ml-3"><i class="fas fa-edit"></i></a>
                    </div>
                    <div class="col-lg-1">
                    <form action="{{ route('neptune.roles.destroy', $role->id) }}" method="POST">
                        @csrf
                        @method('delete')

                        <button class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash"></i></button>
                    </form>
                    </div>
                </div>
            </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Avtal</h3>
                    @foreach ($role->contracts as $contract)
                        <p><a href="{{ $contract->path() }}" >{{ $contract->code }} - {{ $contract->name }}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

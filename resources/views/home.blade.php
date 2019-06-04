@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(auth()->user()->isHR())
                        <h3 class="d-flex justify-items-baseline">
                            Avtal utan roll
                            <small>
                            <span class="badge {{ $contractsNoRole->count() > 0 ? 'badge-danger' : 'badge-success' }} ml-2">
                                {{ $contractsNoRole->count() }}
                             </span>
                            </small>
                        </h3>
                        @if ($contractsNoRole->count() > 0)
                            @foreach ($contractsNoRole as $contract)
                                <p>
                                    <a href="{{ $contract->path() }}">{{ $contract->code }} - {{ $contract->name }}</a>
                                </p>
                            @endforeach
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hantera konton</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('accounts.ad.index') }}" class="btn btn-primary"><i class="fas fa-search"></i> Active Directory</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

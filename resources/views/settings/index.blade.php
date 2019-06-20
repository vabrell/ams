@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inställningar</div>

                <div class="card-body">

                    <a href="{{ route('settings.customer.index') }}" class="btn btn-primary">Kunder</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


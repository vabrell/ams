@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inställningar</div>

                <div class="card-body d-flex justify-content-around pl-5 pr-5">

                    <a href="{{ route('settings.customer.index') }}" class="btn btn-primary col-4">Kunder</a>
                    <a href="{{ route('settings.import.index') }}" class="btn btn-primary col-4">Importera A2-konton</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


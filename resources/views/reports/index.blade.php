@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Rapporter</div>

                <div class="card-body">

                    <a href="{{ route('reports.tasks.index') }}" class="btn btn-primary"><i class="fas fa-briefcase"></i> Uppgifter</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


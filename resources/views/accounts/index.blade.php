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

                    @if (auth()->user()->isServicedesk())
                        <h3>Active directory</h3>
                        <div class="row">
                            <div class="col-4">
                                <a href="{{ route('accounts.employee.index') }}" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Anställd</a>
                            </div>
                            <div class="col-4">
                                <a href="" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Elever</a>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->isSystemAdmin())
                        <h3 class="mt-4">Konsult</h3>
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('accounts.consultants.create') }}" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Beställ konsult</a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('accounts.consultants.index') }}" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Konsulter</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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

                    @if (auth()->user()->isSchoolAdmin())
                        <h3>Active directory</h3>
                        <div class="row">
                            @if (auth()->user()->isServiceDesk())
                                <div class="col-4">
                                    <a href="{{ route('accounts.employee.index') }}" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Anställd</a>
                                </div>
                            @endif
                            @if (auth()->user()->isSchoolAdminKK())
                                <div class="col-4">
                                    <a href="{{ route('accounts.students.kk.index') }}" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Kungälv elever</a>
                                </div>
                            @endif
                            @if (auth()->user()->isSchoolAdminLE())
                                <div class="col-4">
                                    <a href="{{ route('accounts.students.le.index') }}" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Lilla Edet elever</a>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if (auth()->user()->isSystemAdmin())
                        <h3 class="mt-4">Externa konsulter</h3>
                        <div class="row">
                            <div class="col-4">
                                <a href="{{ route('accounts.consultants.create') }}" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Beställ konsult</a>
                            </div>
                            <div class="col-4">
                                <a href="{{ route('accounts.consultants.index') }}" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Sök</a>
                            </div>
                            <div class="col-4">
                                <a href="{{ route('accounts.consultants.active') }}" class="btn btn-primary btn-block"><i class="fas fa-briefcase"></i> Pågående uppgifter</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

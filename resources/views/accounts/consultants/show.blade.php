@extends('layouts.app')

@section('scripts')
@if(count($errors) > 0 || session('error'))
    <script>
        $("#showPwd").click();
    </script>
@endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><b>Konto:</b> {{ !empty($account) ? $account->firstname . " " . $account->lastname : 'N/A' }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!empty($account))

                        <p>{{ $account->startDate }}</p>
                        <p>{{ $account->endDate }}</p>

                    @else

                        <div class="alert alert-danger">
                            Konsulten du letar efter finns inte!
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

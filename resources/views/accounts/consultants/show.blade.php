@extends('layouts.app')

@section('scripts')

@error('password')
<script>
    $("#showPwd").click();
</script>
@enderror
@error('password_confirmation')
<script>
    $("#showPwd").click();
</script>
@enderror
@if(session('error'))
    <script>
        $("#showPwd").click();
    </script>
@endif

@error('servername')
    <script>
        $("#showServer").click();
    </script>
@enderror
@if(session('servername'))
    <script>
        $("#showServer").click();
    </script>
@endif

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><b>Konto:</b> {{ !empty($account) ? $account->accountname : 'N/A' }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('exists'))
                        <div class="alert alert-success" role="alert">
                            {{ session('exists') }}
                        </div>
                    @endif
                    @if (session('failed'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('failed') }}
                        </div>
                    @endif

                    @if (!empty($account))

                    @if ($adAccount)
                        <div class="modal fade" id="pwd" tabindex="-1" role="dialog" aria-labelledby="pwdLabel" aria-hidden="true">
                            <form method="POST" action="{{ route("accounts.resetpwd", [
                                                            'account' => $adAccount->samaccountname[0],
                                                            'type' => 'consultant'
                                                        ]) }}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pwdLabel">Nollställ lösenord</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Lösenord') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror @if(session('error')) is-invalid @endif" name="password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            @if(session('error'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ session('error') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Upprepa lösenord') }}</label>

                                        <div class="col-md-6">
                                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">

                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Avbryt</button>
                                    <button type="submit" class="btn btn-primary">Nollställ lösenord</button>
                                </div>
                                </div>
                            </div>
                            </form>
                        </div>

                        <div class="modal fade" id="server" tabindex="-1" role="dialog" aria-labelledby="serverLabel" aria-hidden="true">
                                <form method="POST" action="{{ route("accounts.server.add", $adAccount->samaccountname[0]) }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="serverLabel">Lägg till server rättigheter</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="servername" class="col-md-4 col-form-label text-md-right">{{ __('Servernamn') }}</label>

                                            <div class="col-md-6">
                                                <input id="servername" type="text" class="form-control @error('servername') is-invalid @enderror @if(session('servername')) is-invalid @endif" name="servername">

                                                <small class="form-text text-muted">
                                                    Du kan lägga till flera serverar genom att separera servernamnen med ;
                                                </small>

                                                @error('servername')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Avbryt</button>
                                        <button type="submit" class="btn btn-primary">Lägg till rättigheter</button>
                                    </div>
                                    </div>
                                </div>
                                </form>
                            </div>

                        <div class="row">

                            <div class="col-1 offset-lg-10">
                                <button type="button" id="showPwd" class="btn btn-primary" data-toggle="modal" data-target="#pwd">
                                    <i class="fas fa-key"></i>
                                </button>
                            </div>

                            <div class="col-1">
                                <form method="POST" action="{{ route("accounts.unlock", [
                                                                'account' => $adAccount->samaccountname[0],
                                                                'type' => 'consultant'
                                                            ]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success" @if($adAccount->getLockoutTime() < 1) disabled @endif>
                                        <i class="fas fa-lock-open"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endif


                    <div class="row mt-3">
                            <div class="col-lg-4 col-md-6">

                                <div class="card-header rounded border-secondary">
                                    <div class="pt-1">Konsultuppgifter</div>
                                </div>
                                <div class="card-body">

                                    <p><b>Namn:</b> {{ $account->firstname . ' ' . $account->lastname }}</p>
                                    <p><b>Mobil:</b> {{ $account->mobile }}</p>
                                    <p><b>Företag:</b> {{ $account->company }}</p>

                                </div>

                            </div>
                            <div class="col-lg-4 col-md-6">

                                <div class="card-header rounded border-secondary">
                                    <div class="pt-1">
                                        Kontouppgifter
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($adAccount)
                                        <p><b>Skapat av:</b> <a href="{{ route('accounts.employee.show', $account->user->username) }}">{{ $account->user->name }}</a></p>
                                        <p><b>Befattning:</b> {{ $account->title }}</a></p>
                                        <p><b>Status:</b>
                                            @if($adAccount->getLockoutTime() > 1)
                                                Låst
                                            @else
                                                {{ $adAccount->isActive() ? 'Aktiv' : 'Inaktiv' }}</p>
                                            @endif
                                        <p><b>Lösenord ändrat:</b> {{ $adAccount->getPasswordLastSetDate() }}</p>
                                        <p><b>Lösenord går ut:</b> {{ $adAccount->getPasswordExpires() == 'Never' ? 'Aldrig' : $adAccount->getPasswordExpires() }}</p>
                                    @endif
                                </div>

                            </div>
                            <div class="col-lg-4 col-md-6">

                                <div class="card-header rounded border-secondary d-flex align-items-baseline">
                                    <div class="col-10">
                                        Aktiv uppgift
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('accounts.consultants.task', $account->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    @if ($lastTask)
                                        <p><b>Aktivitetsnamn:</b> {{ $lastTask->name }}</p>
                                        <p><b>Startdatum:</b> {{ $lastTask->startDate }}</p>
                                        <p><b>Slutdatum:</b> {{ $lastTask->endDate }}</p>
                                        <p><b>Beskrivning:</b> {{ $lastTask->description }}</p>
                                    @endif


                                </div>

                            </div>
                        </div>

                        <div id="accordion" class="accordion">

                            <div class="card">
                                <button class="btn p-0"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#tasks"
                                        aria-controls="tasks">
                                    <div class="card-header">
                                        Uppgifter
                                    </div>
                                </button>
                                <div id="tasks" class="collapse" aria-labelledby="tasks" data-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Aktivitetsnamn</th>
                                                    <th scope="col">Startdatum</th>
                                                    <th scope="col">Slutdatum</th>
                                                    <th scope="col">Beskrivning</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($account->tasks as $task)
                                                <tr>
                                                    <td>{{ $task->name }}</td>
                                                    <td>{{ $task->startDate }}</td>
                                                    <td>{{ $task->endDate }}</td>
                                                    <td>{{ $task->description }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                    <button class="btn p-0"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#serverRights"
                                            aria-controls="serverRights">
                                        <div class="card-header">
                                            Server rättigheter
                                        </div>
                                    </button>
                                    <div id="serverRights" class="collapse" aria-labelledby="serverRights" data-parent="#accordion">
                                        <div class="card-body">
                                                <div class="col-1 offset-lg-11">
                                                    <button type="button" id="showServer" class="btn btn-primary" data-toggle="modal" data-target="#server">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>

                                                @foreach ($servergroups as $servergroup)
                                                    <p>{{ str_replace(substr($servergroup, 21),'' , str_replace('CN=CS-DS-LSA-', '', $servergroup)) }}</p>
                                                @endforeach
                                        </div>
                                    </div>
                                </div>

                        </div>

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

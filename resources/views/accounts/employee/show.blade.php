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
                <div class="card-header"><b>Konto:</b> {{ !empty($user) ? $user->samaccountname['0'] . " (" . $user->employeetype['0'] . ")" : 'N/A' }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!empty($user))

                        <div class="modal fade" id="pwd" tabindex="-1" role="dialog" aria-labelledby="pwdLabel" aria-hidden="true">
                            <form method="POST" action="{{ route('accounts.employee.resetpwd', $user->samaccountname[0]) }}">
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

                        <div class="row">

                            <div class="col-1 offset-lg-10">
                                <button type="button" id="showPwd" class="btn btn-primary" data-toggle="modal" data-target="#pwd">
                                    <i class="fas fa-key"></i>
                                </button>
                            </div>

                            <div class="col-1">
                                <form method="POST" action="{{ route('accounts.employee.unlock', $user->samaccountname[0]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success" @if($user->getLockoutTime() < 1) disabled @endif>
                                        <i class="fas fa-lock-open"></i>
                                    </button>
                                </form>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6">

                                <div class="card-header rounded border-secondary">Användaruppgifter</div>
                                <div class="card-body">

                                    <p><b>Namn:</b> {{ $user->displayname['0'] }}</p>
                                    <p><b>Telefon:</b> {{ $user->telephonenumber['0'] }}</p>
                                    <p><b>Mobil:</b> {{ $user->mobile['0'] }}</p>
                                    <p><b>SMS verifikation:</b> {{ $user->extensionattribute7['0'] }}</p>
                                    <p><b>E-post:</b> {{ $user->mail['0'] }}</p>

                                </div>

                            </div>
                            <div class="col-lg-4 col-md-6">

                                <div class="card-header rounded border-secondary">Jobbuppgifter</div>
                                <div class="card-body">

                                    <p><b>Befattning:</b> {{ $user->title['0'] }}</p>
                                    <p><b>Företag:</b> {{ $user->company['0'] }}</p>
                                    <p><b>Chef:</b> <a href="{{ $manager->samaccountname[0] }}">{{ $manager->displayname['0'] }}</a></p>

                                </div>

                            </div>
                            <div class="col-lg-4 col-md-6">

                                <div class="card-header rounded border-secondary">Kontouppgifter</div>
                                <div class="card-body">

                                    <p><b>Status:</b>
                                        @if($user->getLockoutTime() > 1)
                                            Låst
                                        @else
                                            {{ $user->isActive() ? 'Aktiv' : 'Inaktiv' }}</p>
                                        @endif
                                    <p><b>Lösenord ändrat:</b> {{ $user->getPasswordLastSetDate() }}</p>
                                    <p><b>Lösenord går ut:</b> {{ $user->getPasswordExpires() == 'Never' ? 'Aldrig' : $user->getPasswordExpires() }}</p>

                                </div>

                            </div>
                        </div>

                        <div id="accordion" class="accordion">

                            <div class="card">
                                <button class="btn p-0"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#groups"
                                        aria-controls="groups">
                                    <div class="card-header">
                                        Behörigheter
                                    </div>
                                </button>
                                <div id="groups" class="collapse" aria-labelledby="groups" data-parent="#accordion">
                                    <div class="card-body">
                                        @foreach ($groups as $group)
                                            <p>{{ $group->samaccountname[0] }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                    <button class="btn p-0"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#applications"
                                            aria-controls="applications">
                                        <div class="card-header">
                                            Applikationer
                                        </div>
                                    </button>
                                    <div id="applications" class="collapse" aria-labelledby="applications" data-parent="#accordion">
                                        <div class="card-body">
                                            @foreach ($applications as $application)
                                                <p>{{   str_replace("CS-SYS-SCCM-APP-", "",
                                                        str_replace("_", " ",
                                                        str_replace("User", "",
                                                        str_replace("Install", "",
                                                        str_replace("Uninstall", "",
                                                        $application->samaccountname[0]
                                                        ))))) }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            @if (!empty($directreports))
                            <div class="card">
                                <button class="btn p-0"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#employees"
                                            aria-controls="employees">
                                    <div class="card-header">
                                        Anställda
                                    </div>
                                </button>
                                <div id="employees" class="collapse" aria-labelledby="employees" data-parent="#accordion">
                                    <div class="card-body">
                                        @foreach ($directreports as $directreport)
                                            @if ($directreport->employeetype[0] == "Anställd")
                                                <p><a href="{{ route('accounts.employee.show', $directreport->samaccountname[0])}}">{{ $directreport->displayname[0] }}</a></p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>

                    @else

                        <div class="alert alert-danger">
                            Kontot du letar efter finns inte!
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

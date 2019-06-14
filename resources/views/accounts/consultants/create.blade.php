@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Beställ nytt konsultkonto') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('accounts.consultants.store') }}">
                        @csrf
                        <input id="uuid" type="hidden" name="uuid" value="{{ Str::uuid() }}">
                        <input id="createdBy" type="hidden" name="createdBy" value="{{ auth()->user()->id }}">

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right required">{{ __('Förnamn') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right required">{{ __('Efternamn') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" >

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Befattning') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" >

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right required">{{ __('Mobil') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" >

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vht" class="col-md-4 col-form-label text-md-right required">{{ __('VHT') }}</label>

                            <div class="col-md-6">
                                <input id="vht" type="text" class="form-control @error('vht') is-invalid @enderror" name="vht" value="{{ old('vht') }}" >

                                @error('vht')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ansvar" class="col-md-4 col-form-label text-md-right required">{{ __('Ansvar') }}</label>

                            <div class="col-md-6">
                                <input id="ansvar" type="text" class="form-control @error('ansvar') is-invalid @enderror" name="ansvar" value="{{ old('ansvar') }}" >

                                @error('ansvar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company" class="col-md-4 col-form-label text-md-right required">{{ __('Bolag') }}</label>

                            <div class="col-md-6">
                                <select id="company" class="form-control @error('company') is-invalid @enderror" name="company">
                                    <option disabled selected>Välj företag</option>
                                    <option value="Soltak AB" @if (old('company') == "Soltak AB") selected @endif>Soltak AB</option>
                                </select>

                                @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="consultantCompany" class="col-md-4 col-form-label text-md-right required">{{ __('Konsultbolag') }}</label>

                            <div class="col-md-6">
                                <input id="consultantCompany" type="text" class="form-control @error('consultantCompany') is-invalid @enderror" name="consultantCompany" value="{{ old('consultantCompany') }}" >

                                @error('consultantCompany')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department" class="col-md-4 col-form-label text-md-right">{{ __('Avdelning') }}</label>

                            <div class="col-md-6">
                                <input id="department" type="text" class="form-control @error('department') is-invalid @enderror" name="department" value="{{ old('department') }}" >

                                @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="managerUuid" class="col-md-4 col-form-label text-md-right required">{{ __('Ansvarig/Chef') }}</label>

                            <div class="col-md-6">
                                <input id="managerUuid" type="text" class="form-control @error('managerUuid') is-invalid @enderror" name="managerUuid" value="{{ old('managerUuid') }}" >

                                @error('managerUuid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="startDate" class="col-md-4 col-form-label text-md-right required">{{ __('Startdatum') }}</label>

                            <div class="col-md-6">
                                <input id="startDate" type="date" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' + 6 months')) }}" class="form-control @error('startDate') is-invalid @enderror" name="startDate" value="{{ old('startDate') }}" >

                                @error('startDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="endDate" class="col-md-4 col-form-label text-md-right required">{{ __('Slutdatum') }}</label>

                            <div class="col-md-6">
                                <input id="endDate" type="date" class="form-control @error('endDate') is-invalid @enderror" name="endDate" value="{{ old('endDate') }}" disabled>

                                @error('endDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="localAccount" class="col-md-4 col-form-label text-md-right">{{ __('Legacy konto') }}</label>

                            <div class="col-md-1">
                                <input id="localAccount" type="checkbox" class="form-control @error('localAccount') is-invalid @enderror" name="localAccount" value="{{ old('localAccount') }}" >

                                @error('localAccount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="isEdu" class="col-md-4 col-form-label text-md-right">{{ __('Skolpersonal') }}</label>

                            <div class="col-md-1">
                                <input id="isEdu" type="checkbox" class="form-control @error('isEdu') is-invalid @enderror" name="isEdu" value="{{ old('isEdu') }}" >

                                @error('isEdu')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Lägg beställning') }}
                                </button>

                                <a href="{{ route('accounts.index') }}" class="btn btn-danger">Avbryt</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

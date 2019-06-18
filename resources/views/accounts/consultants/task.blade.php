@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lägg till aktivitet för <b>{{ $account->firstname }} {{ $account->lastname }} ( {{ $account->accountname }} )</b></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('accounts.consultants.storeTask', $account->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Aktivitetsnamn') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customer_id" class="col-md-4 col-form-label text-md-right required">{{ __('Kund') }}</label>

                            <div class="col-md-6">
                                <select name="customer_id" id="customer_id" class="form-control @error('customer') is-invalid @enderror">
                                    <option selected disabled>Välj en kund</option>
                                    <option disabled>---</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @if(old('customer_id') == 1) selected @endif>{{ $customer->name }}</option>
                                    @endforeach
                                </select>

                                @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="startDate" class="col-md-4 col-form-label text-md-right required">{{ __('Startdatum') }}</label>

                            <div class="col-md-6">
                                <input id="startDate" type="date" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 months')) }}" class="form-control @error('startDate') is-invalid @enderror" name="startDate" value="{{ old('startDate') }}" >

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
                                <label for="description" class="col-md-4 col-form-label text-md-right required">{{ __('Beskrivning') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="date" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">
                                        {{ old('description') }}
                                    </textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Lägg till') }}
                                </button>

                                <a href="{{ route('accounts.consultants.show', $account->id) }}" class="btn btn-danger">Avbryt</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

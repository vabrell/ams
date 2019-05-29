@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ändra avtal: ') . $contract->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('neptune.contracts.update', $contract->id) }}">
                        @csrf
                        @method('patch')

                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Avtals kod') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" disabled value="{{ $contract->code }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Avtals namn') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $contract->name ?? old('name') }}" >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('Roll') }}</label>

                                <div class="col-md-6">
                                    <select id="role_id" class="form-control @error('role_id') is-invalid @enderror" name="role_id">
                                        <option disabled selected>Välj roll</option>
                                        {{ $selected = $contract->role()->exists()
                                                    ? $contract->role()->id == $role->id ? selected : ''
                                                    : '' }}
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ $selected }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Spara') }}
                                </button>

                                <a href="{{ route('neptune.contracts.show', $contract->id) }}" class="btn btn-danger">
                                        {{ __('Avbryt') }}
                                </a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

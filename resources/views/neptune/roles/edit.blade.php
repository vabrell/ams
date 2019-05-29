@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ändra roll: ') . $role->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('neptune.roles.update', $role->id) }}">
                        @csrf
                        @method('patch')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Avtals namn') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $role->name ?? old('name') }}" >
                                <span class="small text-muted">Måste stämma <u>EXAKT</u> med rollen har i Neptune</span>

                                @error('name')
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

                                <a href="{{ route('neptune.roles.show', $role->id) }}" class="btn btn-danger">
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

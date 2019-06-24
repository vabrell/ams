@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ändra roll: ') . $role->name }}</div>

                <div class="card-body ">
                    <form id="updateRole" method="POST" action="{{ route('neptune.roles.update', $role->id) }}">
                        @csrf
                        @method('patch')

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Roll namn') }}</label>

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

                        <div class="form-group row">
                                <label for="contract" class="col-md-2 col-form-label text-md-right">{{ __('Avtal') }}</label>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select multiple class="form-control" id="noRole" name="noRole[]">
                                                @foreach ($contractsNoRole as $noRole)
                                                    <option value="{{ $noRole->id }}">{{ $noRole->code . " - " . $noRole->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 mr-3">
                                            <button type="button" id="btnAdd" class="btn btn-sm btn-secondary mt-3"><i class="fas fa-arrow-alt-circle-right"></i></button>
                                            <button type="button" id="btnRemove" class="btn btn-sm btn-secondary mt-2"><i class="fas fa-arrow-alt-circle-left"></i></button>
                                        </div>
                                        <div class="col-md-5">
                                            <select multiple class="form-control" id="contract" name="contract[]">
                                                @foreach ($role->contracts as $contract)
                                                    <option value="{{ $contract->id }}">{{ $contract->code . " - " . $contract->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    @error('contract')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button id="roleSave" type="submit" class="btn btn-primary">
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

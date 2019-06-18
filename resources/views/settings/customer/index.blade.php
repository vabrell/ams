@extends('layouts.app')

@section('content')
<div class="container">
<div class="card pr-3 pl-3 pt-3">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Kund</th>
                <th scope="col">
                    <a class="float-right" href="{{ route('settings.customer.create') }}">
                        <button class="btn btn-sm btn-primary">
                            <span class="fas fa-plus"></span>
                        </button>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($customers as $customer)

                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>
                        <a class="float-right" href="{{ route('settings.customer.edit', $customer->id) }}">
                            <button class="btn btn-sm btn-primary">
                                <span class="fas fa-pen"></span>
                            </button>
                        </a>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

    {{ $customers->links() }}

</div>
</div>
@endsection

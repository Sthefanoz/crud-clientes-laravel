@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">Editar cliente</h1></div>
                <div class="card-body">
                    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                        @method('PUT')
                        @include('clientes._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

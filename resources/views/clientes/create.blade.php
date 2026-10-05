@extends('layouts.app')

@section('title', 'Nuevo cliente')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">Nuevo cliente</h1></div>
                <div class="card-body">
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @include('clientes._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

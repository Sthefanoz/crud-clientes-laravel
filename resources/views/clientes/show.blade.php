@extends('layouts.app')

@section('title', $cliente->nombre)

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">{{ $cliente->nombre }}</h1></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $cliente->email }}</dd>
                        <dt class="col-sm-4">Teléfono</dt>
                        <dd class="col-sm-8">{{ $cliente->telefono ?? '—' }}</dd>
                        <dt class="col-sm-4">Dirección</dt>
                        <dd class="col-sm-8">{{ $cliente->direccion ?? '—' }}</dd>
                        <dt class="col-sm-4">Registrado</dt>
                        <dd class="col-sm-8">{{ $cliente->created_at->format('d/m/Y H:i') }}</dd>
                        <dt class="col-sm-4">Actualizado</dt>
                        <dd class="col-sm-8">{{ $cliente->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection

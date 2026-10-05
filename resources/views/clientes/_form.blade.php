@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}"
           class="form-control @error('nombre') is-invalid @enderror" maxlength="100" required>
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
    <input type="email" id="email" name="email" value="{{ old('email', $cliente->email) }}"
           class="form-control @error('email') is-invalid @enderror" maxlength="150" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}"
           class="form-control @error('telefono') is-invalid @enderror" maxlength="20">
    @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <textarea id="direccion" name="direccion" rows="2" maxlength="255"
              class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $cliente->direccion) }}</textarea>
    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-2">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" class="form-control" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}" class="form-control">
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="form-control">
        @error('phone')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Dirección</label>
        <input type="text" name="address" value="{{ old('address', $customer->address ?? '') }}" class="form-control">
        @error('address')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

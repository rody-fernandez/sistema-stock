<div class="mb-3">
    <label>Nombre</label>
    <input type="text" name="name" value="{{ old('name',$product->name ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Descripción</label>
    <textarea name="description" class="form-control">{{ old('description',$product->description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Precio</label>
    <input type="number" step="0.01" name="price" value="{{ old('price',$product->price ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Stock</label>
    <input type="number" name="stock" value="{{ old('stock',$product->stock ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Imagen</label>
    <input type="file" name="image" class="form-control">
    @if(!empty($product->image))
        <img src="{{ asset('storage/'.$product->image) }}" width="100" class="mt-2">
    @endif
</div>

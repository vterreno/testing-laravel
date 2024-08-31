<div class="form-group col-sm-12 modal-header">
    <h3 id="modalTitle">Agregar producto</h3>
</div>

<!-- Product Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', '* Producto:') !!}
    {!! Form::select('product_id', \App\Models\Product::pluck('name', 'id'), null, ['class' => 'form-control select-product', 'placeholder' => 'Seleccione un producto', 'id' => 'product_id']) !!}
</div>

<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Cantidad: ') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control', 'id' => 'detail_quantity']) !!}
</div>

<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'ID:') !!}
    <p>{{ $product->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $product->name }}</p>
</div>

<!-- Unit Price Sell Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price_sell', 'Precio unitario de venta:') !!}
    <p>{{ $product->unit_price_sell }}</p>
</div>

<!-- Unit Price Buy Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price_buy', 'Precio unitario de compra:') !!}
    <p>{{ $product->unit_price_buy }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Descripción:') !!}
    <p>{{ $product->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado en:') !!}
    <p>{{ $product->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualización en:') !!}
    <p>{{ $product->updated_at }}</p>
</div>


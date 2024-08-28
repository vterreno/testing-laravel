<!-- Name Field -->
<div class="form-group col-sm-4">
    {!! Form::label('name', 'Nombre: *') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Unit Price Sell Field -->
<div class="form-group col-sm-4">
    {!! Form::label('unit_price_sell', 'Precio unitario de venta: *') !!}
    {!! Form::number('unit_price_sell', null, ['class' => 'form-control', 'required', 'min' => 0, 'step' => 0.01]) !!}
</div>

<!-- Unit Price Buy Field -->
<div class="form-group col-sm-4">
    {!! Form::label('unit_price_buy', 'Precio unitario de compra: *') !!}
    {!! Form::number('unit_price_buy', null, ['class' => 'form-control', 'required', 'min' => 0, 'step' => 0.01]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Descripción:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>
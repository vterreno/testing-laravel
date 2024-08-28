<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $product->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $product->name }}</p>
</div>

<!-- Unit Price Sell Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price_sell', 'Unit Price Sell:') !!}
    <p>{{ $product->unit_price_sell }}</p>
</div>

<!-- Unit Price Buy Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price_buy', 'Unit Price Buy:') !!}
    <p>{{ $product->unit_price_buy }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $product->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $product->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $product->updated_at }}</p>
</div>


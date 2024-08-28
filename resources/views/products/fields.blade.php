<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Unit Price Sell Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_price_sell', 'Unit Price Sell:') !!}
    {!! Form::number('unit_price_sell', null, ['class' => 'form-control']) !!}
</div>

<!-- Unit Price Buy Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_price_buy', 'Unit Price Buy:') !!}
    {!! Form::number('unit_price_buy', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>
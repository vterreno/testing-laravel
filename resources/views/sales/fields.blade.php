<!-- Payment method -->
<div class="form-group col-sm-4">
    {!! Form::label('payment_method_id', 'Método de pago: *') !!}
    {!! Form::select('payment_method_id', App\Models\PaymentMethod::pluck('name', 'id'), null, ['class' => 'form-control', 'required', 'placeholder' => 'Seleccione un método']) !!}
</div>

<!-- Agregar este campo oculto para guardar los objetos -->
{!! Form::hidden('details_sales_json', null, ['id' => 'detailsSalesJson']) !!}

<!-- div titulo -->
<div class="form-group col-sm-12">
    <hr>
    <h4>Productos</h4>
</div>

@include('sales_details.table_products')
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre: *') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Observation Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observation', 'Observación:') !!}
    {!! Form::text('observation', null, ['class' => 'form-control']) !!}
</div>
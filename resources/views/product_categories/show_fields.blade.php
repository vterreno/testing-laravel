<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'ID:') !!}
    <p>{{ $productCategory->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $productCategory->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Descripción:') !!}
    <p>{{ $productCategory->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado en:') !!}
    <p>{{ $productCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado en:') !!}
    <p>{{ $productCategory->updated_at }}</p>
</div>


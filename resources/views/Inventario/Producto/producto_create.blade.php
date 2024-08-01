@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
    <h2 class="mb-4">{{ $titulo_modulo}}</h2>
    @component('components.boton_back',['ruta' => route('producto'),'color' => $array_color['back_button_color']])
        Botón de retorno
    @endcomponent   
</div>
    
@endsection

    
@section('main-content')

<div class="contenedor">
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                    </ul>
                    </div>
                @endif
                {!! Form::open(array('route' => array('producto.store'),
                'method'=>'POST','id' => 'form_rols_id','enctype' =>'multipart/form-data')) !!}
                <div class="form-group">                
                    <div class="estilo-almacen">                    
                        <div style="text-align:left;">
                            {!! Form::label('nombre','Nombre Producto', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::text('nombre',old('nombre'),['placeholder' => 'Nombre Producto','class' => 'form-control','id' => 'nombre_producto']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('ubicacion','Ubicacion', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::text('ubicacion',old('ubicacion'),['placeholder' => 'Ubicacion','class' => 'form-control','id' => 'ubicacion_producto']) !!}
                        </div>   
                        <div style="text-align:left;">
                            {!! Form::label('descripcion','Descripcion', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::text('descripcion',old('descripcion'),['placeholder' => 'descripcion','class' => 'form-control','id' => 'descripcion_producto']) !!}
                        </div>     
                        <div style="text-align:left;">
                            {!! Form::label('cantidad','cantidad', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::text('cantidad',old('cantidad'),['placeholder' => 'cantidad','class' => 'form-control','id' => 'cantidad_producto']) !!}
                        </div>                 
                        <div style="text-align:left;">
                            {!! Form::label('precio','precio', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::text('precio',old('precio'),['placeholder' => 'precio','class' => 'form-control','id' => 'precio_producto']) !!}
                        </div>                                                     
                    </div>     
                    <br>
                    <span class="boton">
                        {!! Form::submit('Guardar Prod.',['class'=> 'form-control btn btn-primary','title' => 'Guardar Almacen','data-toggle' => 'tooltip','style' => 'background-color:'.$array_color['group_button_color'].';']) !!}                     
                    </span>   
                </div> 
                {!!  Form::close() !!}
            </div>             
        </div>
    </div>
</div>
<style>
    .estilo-almacen{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .contenedor{
        max-width: 120px;
    }
</style>
@endsection
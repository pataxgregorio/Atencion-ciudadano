@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
    <h2 class="mb-4">Editar Almacen</h2>
    @component('components.boton_back',['ruta' => route('almacen'),'color' => $array_color['back_button_color']])
        Botón de retorno
    @endcomponent   
</div>
    
@endsection

    
@section('main-content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12 col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                    </ul>
                    </div>
                @endif                
                {!! Form::open(array('route' => array('almacen.update',$almacen->id),
                'method'=>'POST','id' => 'form_rols_id','enctype' =>'multipart/form-data')) !!}
                <div class="form-group">                
                <div class="col-lg-6 col-xs-6">                    
                    <div style="text-align:left;">
                        {!! Form::label('nombre','Nombre', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('nombre',$almacen->nombre,['class' => 'form-control','id' => 'name_rol', 'disabled' => false]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('ubicacion',trans('message.modulo_action.description'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('ubicacion',$almacen->ubicacion,['class' => 'form-control','id' => 'name_description']) !!}
                    </div>                            
                </div>        
                <hr>
                        {!! Form::submit('Actualizar',['class'=> 'form-control btn btn-primary','title' => 'Actualizar','data-toggle' => 'tooltip','style' => 'background-color:'.$array_color['group_button_color'].';']) !!}                     
                </div>      
                {!!  Form::close() !!}
            </div>             
        </div>
    </div>
</div>
@endsection
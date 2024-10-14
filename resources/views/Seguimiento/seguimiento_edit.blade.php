@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
<h2 style="margin: -25px 0px 0px 25pxpx"><img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="100px" >Editar Seguimiento</h2>

    @component('components.boton_back', ['ruta' => route('solicitud.index'), 'color' => $array_color['back_button_color']])
    Botón de retorno
    @endcomponent
</div>

    
@endsection

    
@section('main-content')

<div class="container-fluid w-50" style="max-width:640px">
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
                <?php 
                    $rols_id = auth()->user()->rols_id;
                    $phpValue = $rols_id;
                    $idmunicipio = $solicitud_edit->municipio_id;
                    $idjefecomunidad = $solicitud_edit->jefecomunidad_id;
                    echo "<script> var idmunicipioJS = '" . $idmunicipio . "'; </script>";
                    echo "<script> var rolsJS = '" . $phpValue . "'; </script>";
                    echo "<script> var jefecomunidadID = '" . $idjefecomunidad. "'; </script>";
                    $usuario = Auth::user()->name;
                    $variable =$solicitud_edit->tipo_solicitud_id;

                        if($solicitud_edit->tipo_solicitud_id == 6){
                            $valores =$beneficiario;
                        }
                    ?>               
                <div class="form-group">
                    <div style="text-align:left;">
                        {!! Form::label('solicitud_salud_id_label', 'ID DE LA SOLICITUD', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('solicitud_salud_id_show', old('solicitud_salud_id'), ['placeholder' => $correlativoSALUD, 'class' => 'form-control', 'id' => 'solicitud_salud_id', 'DISABLED' => TRUE]) !!}
                        <input type="text" name="solicitud_salud_id" id="solicitud_salud_id" value="{{ $correlativoSALUD }}" hidden>
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('nombrebeneficiario',trans('message.solicitud_action.nombrebeneficiario'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('nombrebeneficiario',isset($valores[0]["nombre"]) ?$valores[0]["nombre"]: '',['placeholder' => trans('message.solicitud_action.nombrebeneficiario'),'class' => 'form-control','id' => 'nombrebeneficiario_user' , 'disabled' => true]) !!}
                    </div> 
                    <div style="text-align:left;">
                        {!! Form::label('cedulabeneficiario',trans('message.solicitud_action.cedulabeneficiario'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('cedulabeneficiario',isset($valores[0]["cedula"]) ?$valores[0]["cedula"]: '',['placeholder' => trans('message.solicitud_action.cedulabeneficiario'),'class' => 'form-control','id' => 'cedulabeneficiario_user' , 'disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('edadbeneficiario', 'EDAD BENEFICIARIO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('edadbeneficiario', isset($valores[0]["edadbeneficiario"]) ? $valores[0]["edadbeneficiario"] : '', ['placeholder' => 'EDAD BENEFICIARIO', 'class' => 'form-control', 'id' => 'edadbeneficiario_user', 'disabled' => true]) !!}
                    </div>                              
                    <div style="text-align:left;">
                        {!! Form::label('trabajador','Trabajador', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('trabajador',$trabajador, $solicitud_edit->trabajador, ['class' => 'form-control','id' => 'trabajador', 'disabled' => true]) !!}
                    </div> 
                    @if($rols_id != 10)
                    <div style="text-align:left;">
                            {!! Form::label('telefono2',trans('message.solicitud_action.telefono2'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::text('telefono2',$solicitud_edit->telefono2,['placeholder' => trans('message.solicitud_action.telefono2'),'class' => 'form-control','id' => 'telefono2_user', 'disabled' => true]) !!}
                    </div>  
                    <div style="text-align:left;">
                            {!! Form::label('email',trans('message.users_action.email_user'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::email('email',$solicitud_edit->email,['placeholder' => trans('message.users_action.mail_ejemplo'),'class' => 'form-control','id' => 'email_user', 'disabled' => true]) !!}
                    </div>
                    @endif
                    <div style="text-align:left;">
                        {!! Form::label('estado_id','SEXO', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('sexo',$sexo, $solicitud_edit->sexo, ['placeholder' => trans('message.solicitud_action.sexo'),'class' => 'form-control','id' => 'sexo', 'disabled' => true]) !!}
                    </div> 
                    @if($rols_id != 10)
                    <div style="text-align:left;">
                        {!! Form::label('edocivil',trans('message.solicitud_action.edocivil'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('edocivil',$edocivil, $solicitud_edit->edocivil, ['placeholder' => trans('message.solicitud_action.edocivil'),'class' => 'form-control','id' => 'edocivil_id', 'disabled' => true]) !!}
                    </div>   
                    @endif                    
                    @if($rols_id != 10)
                    <div style="text-align:left;">
                        {!! Form::label('nivelestudio','NIVEL EDUCATIVO', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('nivelestudio',$nivelestudio, $solicitud_edit->nivelestudio, ['placeholder' => 'NIVEL EDUCATIVO','class' => 'form-control','id' => 'nivelestudio_user', 'disabled' => true]) !!}
                    </div>   
                    <div style="text-align:left;">
                        {!! Form::label('profesion','OCUPACION O/U OFICIO', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('profesion',$profesion, $solicitud_edit->profesion, ['placeholder' => 'OCUPACION O/U OFICIO','class' => 'form-control','id' => 'profesion_user', 'disabled' => true]) !!}
                    </div>  
                    @endif 
                    <div style="text-align:left;">
                        {!! Form::label('estado_id',trans('message.solicitud_action.estado'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('estado_id',$estado, $solicitud_edit->estado_id, ['placeholder' => trans('message.solicitud_action.estado'),'class' => 'form-control','id' => 'estado_id', 'disabled' => true]) !!}
                    </div> 
                    <div style="text-align:left;">
                        {!! Form::label('municipio_id',trans('message.solicitud_action.municipio'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('municipio_id',  $municipio,  $solicitud_edit->municipio_id, ['placeholder' => trans('message.solicitud_action.municipio'),'class' => 'form-control','id' => 'municipio_id', 'disabled' => true]) !!}
                    </div>    
                    <div style="text-align:left;">
                        {!! Form::label('parroquia_id',trans('message.solicitud_action.parroquia'), ['class' => 'control-label', 'id' => 'parroquia_id_label']) !!}<span class="required" style="color:red;" id="parroquia_id_span">*</span>
                        {!! Form::select('parroquia_id', $parroquia, $solicitud_edit->parroquia_id, ['placeholder' => trans('message.solicitud_action.parroquia'),'class' => 'form-control','id' => 'parroquia_id', 'disabled' => true]) !!}
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('comuna_id', trans('message.solicitud_action.comuna'), ['class' => 'control-label', 'id' => 'comuna_id_label']) !!}<span class="required" style="color:red;" id="comuna_id_span">*</span>
                        <select name="comuna_id" id="comuna_id" class="form-control" disabled>
                            @foreach($comuna as $key => $value)
                                <option value="{{ $value->id }}" @if(old('comuna_id', $solicitud_edit->comuna_id) == $value->id) selected @endif>{{ $value->codigo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('comunidad_id',trans('message.solicitud_action.comunidad'), ['class' => 'control-label', 'id' => 'comunidad_id_label']) !!}<span class="required" style="color:red;" id="comunidad_id_span">*</span>
                            <select name="comunidad_id" id="comunidad_id" class="form-control" disabled>
                                @foreach($comunidad as $key => $value)
                                    <option value="{{ $value->id }}" @if(old('comunidad_id', $solicitud_edit->comunidad_id) == $value->id) selected @endif>{{ $value->nombre }}</option>
                                @endforeach
                            </select>
                        </div>  

                        <div style="text-align:left;">
                            {!! Form::label('jefecomunidad_id', 'Jefe de Comunidad', ['class' => 'control-label', 'id' => 'jefecomunidad_label']) !!}<span class="required" style="color:red;" id="jefecomunidad_Span">*</span>
                            <select name="jefecomunidad_id" id="jefecomunidad_id" class="form-control" disabled>
                                <option value="">Seleccionar jefe de Comunidad</option> @foreach($jefecomunidad as $key => $value)
                                    <option value="{{ $value->id }}" 
                                        @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id || 
                                            (is_null(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id)) && $loop->first)) 
                                            selected 
                                        @endif>
                                        {{ $value->Nombre_Jefe_Comunidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('telefonoJEFE', 'Telefono de Jefe de Comunidad', ['class' => 'control-label', 'id' => 'telefonoJEFE_label']) !!}<span class="required" style="color:red;" id="telefonoJEFE_span">*</span>
                            <select name="telefonoJEFE" id="telefonoJEFE" class="form-control" disabled>
                                @foreach($jefecomunidad as $key => $value)
                                    <option value="{{ $value->id }}" @if(old('telefonoJEFE', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>{{ $value->Telefono_Jefe_Comunidad }}</option>
                                @endforeach
                            </select>
                        </div>
                       
                        <div style="text-align:left;">
                            {!! Form::label('nombreUBCH', 'Nombre de UBCH', ['class' => 'control-label', 'id' => 'nombreUBCH_label']) !!}<span class="required" style="color:red;" id="nombreUBCH_span">*</span>
                            <select name="nombreUBCH" id="nombreUBCH" class="form-control" disabled>
                                @foreach($jefecomunidad as $key => $value)
                                    <option value="{{ $value->id }}" @if(old('nombreUBCH', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>{{ $value->Nombre_Ubch }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('nomjefeUBCH', 'Nombre de Jefe UBCH', ['class' => 'control-label', 'id' => 'nomjefeUBCH_label']) !!}<span class="required" style="color:red;" id="nomjefeUBCH_span">*</span>
                            <select name="nomjefeUBCH" id="nomjefeUBCH" class="form-control" disabled>
                                @foreach($jefecomunidad as $key => $value)
                                    <option value="{{ $value->id }}" @if(old('nomjefeUBCH', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>{{ $value->Nombre_Jefe_Ubch }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('teljefeUBCH', 'Telefono de Jefe UBCH', ['class' => 'control-label', 'id' => 'teljefeUBCH_label']) !!}<span class="required" style="color:red;" id="teljefeUBCH_span">*</span>
                            <select name="teljefeUBCH" id="teljefeUBCH" class="form-control" disabled>
                                @foreach($jefecomunidad as $key => $value)
                                    <option value="{{ $value->id }}" @if(old('teljefeUBCH', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>{{ $value->Telefono_Jefe_Ubch }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="text-align:left;">
                            @if($rols_id == 10)
                                <input type="hidden" name="tipo_solicitud_id" id="tipo_solicitud_id" value="6">
                            @endif
                        </div>  

                        @if($rols_id == 10)
                            <div style="text-align:left;">
                                {!! Form::label('solicita', 'Solicita', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                {!! Form::text('solicita', isset($valores[0]["solicita"]) ?$valores[0]["solicita"]: '',['placeholder' => 'Solicita','class' => 'form-control','id' => 'solicita_user' , 'disabled' => true]) !!}
                            </div>  
                            <div style="text-align:left;">
                                {!! Form::label('venApp', 'Codigo venApp', ['class' => 'control-label']) !!}<span
                                    class="required" style="color:red;">*</span>
                                {!! Form::text('venApp', isset($valores[0]["venApp"]) ? $valores[0]["venApp"] : '', ['placeholder' => 'Codigo', 'class' => 'form-control', 'id' => 'venApp_user', 'disabled' => true]) !!}
                            </div>
                            <div style="text-align:left;">
                                {!! Form::label('direccionbeneficiario',trans('message.solicitud_action.direccionbeneficiario'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                {!! Form::text('direccionbeneficiario',isset($valores[0]["direccion"]) ?$valores[0]["direccion"]: '',['placeholder' => trans('message.solicitud_action.direccionbeneficiario'),'class' => 'form-control','id' => 'direccionbeneficiario_user' , 'disabled' => true]) !!}
                            </div> 
                            <div style="text-align:left;">
                                {!! Form::label('observacionbeneficiario',"OBSERVACION", ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                {!! Form::textarea('observacionbeneficiario',isset($valores[0]["observacion"]) ?$valores[0]["observacion"]: '',['placeholder' => "OBSERVACION",'class' => 'form-control','id' => 'observacionbeneficiario_user' , 'disabled' => true]) !!}
                            </div>
                        @endif

                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered users_all">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Fecha</th>
                                            <th style="text-align:center;">Asunto</th>
                                            <th style="text-align:center;">Evidencia</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($seguimiento_edit as $seguimiento_edit_2);
                                            $arrayData = isset($seguimiento_edit_2->seguimiento) ?$seguimiento_edit_2->seguimiento: NULL;
                                            
                                            if ($arrayData == NULL) {
                                                $seguimientoPrueba = [];
                                                $arrayData = [];
                                            }else{
                                                $seguimientoPrueba = json_decode($arrayData, true);
                                            }                                            
                                        ?>
                                        @foreach ($seguimientoPrueba as $data)                                                                         
                                        <tr>
                                            <td>{{$data['item']}}</td>
                                            <td>{{ \Carbon\Carbon::parse($data['fecha'])->format('d-m-Y H:i') }}</td>
                                            <td>{{$data['asunto']}}</td>
                                            @if($data['imagen'] == 'Undefined')
                                            <td>Sin evidencia</td>
                                            @endif
                                            @if($data['imagen'] != NULL)
                                                <td>
                                                    <a href="{{ asset($data['imagen']) }}" target="_blank"> 
                                                        <img src="{{ asset($data['imagen']) }}" style="width: 120px;">
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                foreach ($seguimiento_edit as $seguimiento_edit_2){
                }
            ?>
            {!! Form::open(array('route' => array('seguimiento.update',isset($seguimiento_edit_2->id) ?$seguimiento_edit_2->id: ''), 'method'=>'POST','id' =>
            'form_users_id','enctype' =>'multipart/form-data')) !!}
            <div class="-dialog">
                <div class="-content">
                    <div class="-header">
                        <h3 style="justify-content: center; font-size:20px;">Agregar Seguimiento</h3>
                        <button type="button" class="close" data-dismiss="">&times;</button>
                    </div>
                    <div class="-body">
                        <div style="text-align:left;">
                            {!! Form::label('asunto','Asunto del Caso', ['class' => 'control-label'])
                            !!}<span class="required" style="color:red;">*</span>
                            {!! Form::textarea('asunto',old('asunto'),['placeholder' => 'Asunto del Caso','class' =>
                            'form-control','id' => 'asunto']) !!}
                        </div>
                        <div style="text-align:left; margin: 10px 10px 10px 0px;">
                            {!! Form::label('asunto','Evidencia', ['class' => 'control-label']) !!}
                            <input type="file" name="image" id="image">
                        </div>
                    </div>
                    <div class="-footer">
                        <button type="submit" class="btn btn-primary" id="Agregar" data-dismiss="">Agregar</button>
                        <input type="text" hidden value="{{$solicitud_edit->id}}" name="solicitud_id">
                        <input type="text" hidden value="{{$solicitud_edit->tipo_solicitud_id}}" name="tipo_solicitud_id">
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

           
         <div class="card">
                <div class="-header">
                        <h3 style="justify-content: center; font-size:20px;">Agregar Medicinas/Insumos/Estudios</h3>
                </div>
          <div class="card-body">
            <table class="table table-bordered users_all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Medicina/Insumo/Estudio</th>
                        <th>Cantidad</th>
                      
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movimiento as $movimiento2)
                        <tr>
                            <td>{{ $movimiento2->id }}</td>
                            <td>{{isset($movimiento2->producto_id) ?$movimiento2->producto : $movimiento2->servicio}}</td>
                            <td>{{$movimiento2->cantidad}}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalMedicinas">Medic./Insum.</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEstudios">Estudios.</button>
        </div>
    </div>
        <div>
        

<div class="modal fade" id="modalMedicinas" tabindex="-1" role="dialog" aria-labelledby="modalMedicinasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMedicinasLabel">Agregar Medicinas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formMedicinas" method="POST" action="{{ route('seguimiento.store2') }}">
          @csrf
          <input type="text" hidden value="{{$solicitud_edit->id}}" name="solicitud_id">
          <div style="text-align:left;">
                            {!! Form::label('compra_id', 'Producto', ['class' => 'control-label', 'id' => 'producto_Label']) !!}
                            <select name="producto_id" id="producto_id" class="form-control">
                            @foreach($producto as $key => $value)
                                <option value="{{ $value->id }}" @if(old('producto_id',$value->id ) ) selected @endif>
                                    {{ $value->nombre }}
                                </option>
                            @endforeach
                            </select>
         </div> 
         <div class="form-group">
            
            <label for="cantidad">Exixtencia</label>
            <input type="text" class="form-control" id="existencia" name="existencia" disabled>
          </div>
          <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="text" class="form-control" id="cantidad" name="cantidad" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id ="formMedicinasbtn" form="formMedicinas" class="btn btn-primary" >Agregar</button>
      </div>
    </div>
  </div>
</div>
                      
        </div>
        <div>
        <div class="modal fade" id="modalEstudios" tabindex="-1" role="dialog" aria-labelledby="modalMedicinasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMedicinasLabel">Agregar Medicinas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEstudios" method="POST" action="{{ route('seguimiento.store3') }}">
          @csrf
          <input type="text" hidden value="{{$solicitud_edit->id}}" name="solicitud_id">
          <div style="text-align:left;">
                            {!! Form::label('compra_id', 'Producto', ['class' => 'control-label', 'id' => 'producto_Label']) !!}
                            <select name="servicio_id" id="producto_id" class="form-control">
                            @foreach($servicio as $key => $value)
                                <option value="{{ $value->id }}" @if(old('servicio_id',$value->id ) ) selected @endif>
                                    {{ $value->nombre }}
                                </option>
                            @endforeach
                            </select>
         </div> 
         
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id ="formMedicinasbtn" form="formEstudios" class="btn btn-primary" >Agregar</button>
      </div>
    </div>
  </div>
</div>
                      


        </div>
    <div style="text-align:left;">
                {!! Form::label('status_id', 'Estado de Solicitud', ['class' =>
                'control-label']) !!}<span class="required" style="color:red;">*</span>
                {!! Form::select('status_id', $status_solicitud, $status_solicitud, ['placeholder' => 'Seleccionar Estado','class'
                => 'form-control','id' =>
                'status_id']) !!}
            </div>
            <?php                
                foreach ($seguimiento_edit as $index => $seguimientoID) {
                    if ($seguimientoID->id !== null) {  // Verificar si el ID existe
                        echo '<script> var id = ' . $seguimientoID->id . ';</script>';
                        echo '<script> var idsolicitud = ' . $seguimientoID->solicitud_id . ';</script>';
                        break; // Salir del bucle después de encontrar el primer ID válido
                    } else {
                        // Manejo del error si el primer ID es nulo
                        if ($index === 0) { // Solo manejar el error en la primera iteración
                            echo '<script>
                                console.error("Error: El primer seguimientoID no tiene un valor válido.");
                                alert("Ha ocurrido un error al cargar los datos. Por favor, inténtelo de nuevo.");
                            </script>';
                        }
                    }
                }
            ?>
            @endsection
            @section('script_datatable')
            <script type="text/javascript">        
            $(document).ready(function() {
                $('#formMedicinasbtn').prop('disabled', true);

                if(jefecomunidadID == ''){
                $("#jefecomunidad_id").html('<option value="">Seleccione Jefe de Comunidad</option>'); // Opción inicial
                $("#telefonoJEFE").text('');
                $("#nombreUBCH").text('');
                $("#nomjefeUBCH").text('');
                $("#teljefeUBCH").text('');
                $("#telefonoJEFE").hide();
                $("#telefonoJEFE_label").hide();
                $("#telefonoJEFE_span").hide();
                $("#nombreUBCH").hide();
                $("#nombreUBCH_label").hide();
                $("#nombreUBCH_span").hide();
                $("#nomjefeUBCH").hide();
                $("#nomjefeUBCH_label").hide();
                $("#nomjefeUBCH_span").hide();
                $("#teljefeUBCH").hide();
                $("#teljefeUBCH_label").hide();
                $("#teljefeUBCH_span").hide();
            }
                if(idmunicipioJS == 2){
                    $("#parroquia_id").hide();
                    $("#parroquia_id_label").hide();
                    $("#parroquia_id_span").hide();
                    $("#comuna_id").hide();
                    $("#comuna_id_label").hide();
                    $("#comuna_id_span").hide();
                    $("#comunidad_id").hide();
                    $("#comunidad_id_label").hide();
                    $("#comunidad_id_span").hide();
                    $("#jefecomunidad_label").hide();
                    $("#jefecomunidad_Span").hide();
                    $("#jefecomunidad_id").hide();
                    $("#telefonoJEFE").hide();
                    $("#telefonoJEFE_label").hide();
                    $("#telefonoJEFE_span").hide();
                    $("#nombreUBCH").hide();
                    $("#nombreUBCH_label").hide();
                    $("#nombreUBCH_span").hide();
                    $("#nomjefeUBCH").hide();
                    $("#nomjefeUBCH_label").hide();
                    $("#nomjefeUBCH_span").hide();
                    $("#teljefeUBCH").hide();
                    $("#teljefeUBCH_label").hide();
                    $("#teljefeUBCH_span").hide();
                }
            var seguimientoID = null; // Declaramos seguimientoID como null por defecto
            var solicitudID = null; // Declaramos solicitudID como null por defecto

    <?php                
        foreach ($seguimiento_edit as $index => $seguimientoID) {
            if ($seguimientoID->id !== null) { 
                echo "seguimientoID = " . $seguimientoID->id . ";\n";
                echo "solicitudID = " . $seguimientoID->solicitud_id . ";\n";
                break; 
            } else {
                if ($index === 0) { 
                    echo 'console.error("Error: El primer seguimientoID no tiene un valor válido.");';
                    echo 'alert("Ha ocurrido un error al cargar los datos. Por favor, inténtelo de nuevo.");';
                }
            }
        }
    ?>
 $('#producto_id').on('change', function() {

    var productoID = $(this).val();
    $.ajax({
                    url: '{{ route('existencia') }}',
                    method: 'GET',
                    data: { 
                        id: productoID
                    },
                    success: function(response) {
                        $('#existencia').val(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la actualización: ' + error);
                    }
                });

  });

  $('#cantidad').on('input', function() {
    var existencia = parseInt($('#existencia').val());
    var cantidad = parseInt($(this).val());

    if (!isNaN(existencia) && !isNaN(cantidad)) {
        if (cantidad <= existencia) {
            $('#formMedicinasbtn').prop('disabled', false);
        } else {
            $('#formMedicinasbtn').prop('disabled', true);
        }
    } else {
        // Si alguno de los valores no es un número, deshabilitamos el botón
        $('#formMedicinasbtn').prop('disabled', true);
    }
});


    $('#status_id').on('change', function() {
        if (seguimientoID !== null) { // Verificamos si seguimientoID ya tiene un valor
            var nuevoValor = $(this).val();
            
            if (confirm('¿Desea ejecutar el cambio?')) {
                $.ajax({
                    url: '{{ route('update2') }}',
                    method: 'GET',
                    data: { 
                        id: seguimientoID,
                        solicitudID: solicitudID, 
                        nuevo_valor: nuevoValor
                    },
                    success: function(response) {
                        alert('¡Actualización exitosa!');
                        window.location.href = "/seguimiento";
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la actualización: ' + error);
                    }
                });
            } 
        }
    });
});

</script>
<style>
    section.content{
        background-image: url("{{ url('/images/siacreate.jpg') }}");
        }
</style>
@endsection
@extends('adminlte::layouts.app')

@section('css_database')
@include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
<h2 style="margin: -25px 0px 0px 25pxpx"><img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="100px" >Crear Solicitud</h2>

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
                    echo "<script> var rolsJS = '" . $phpValue . "'; </script>";
                ?>
                {!! Form::open(
                array(
                    'route' => array('solicitud.store'),
                    'method' => 'POST',
                    'id' => 'form_solicitud_id',
                    'enctype' => 'multipart/form-data'
                )
            ) !!}

                {{ csrf_field() }}
                <div class="form-group ">
                    <div style="text-align:left;">
                        @if($rols_id == 10)
                        <input type="text" name="tipo_solicitud_id" id="tipo_solicitud_id" value=6 hidden>
                        @endif                        
                    </div>
                    <h3>DATOS DEL BENEFICIARIO </h3>
                    <br>
                    <div style="text-align:left;">
                        <label>TRABAJADOR DE LA ALCALDIA <span
                        class="required" style="color:red;" id="teljefeUBCH_span">*</span></label>
                        <select required name="trabajador" id="trabajador" class="selectpicker form-control" data-live-search="true"
                            data-live-search-style="begins">
                            <option value="NO">NO</option>
                            <option value="EMPLEADO">EMPLEADO</option>
                            <option value="OBRERO">OBRERO</option>
                            <option value="JUBILADO">JUBILADO</option>
                            <option value="PENSIONADO">PENSIONADO</option>
                            <option value="PENSIONADO SOBREVIVIETE ALPAEZ">PENSIONADO SOBREVIVIETE ALPAEZ</option>
                        </select>
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('solicitud_salud_id_label', 'ID DE LA SOLICITUD', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('solicitud_salud_id_show', old('solicitud_salud_id'), ['placeholder' => $correlativoSALUD, 'class' => 'form-control', 'id' => 'solicitud_salud_id', 'DISABLED' => TRUE]) !!}
                        <input type="text" name="solicitud_salud_id" id="solicitud_salud_id" value="{{ $correlativoSALUD }}" hidden>
                    </div>
                    <div style="text-align:left;">
                            {!! Form::label('nombrebeneficiario', trans('message.solicitud_action.nombrebeneficiario'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('nombrebeneficiario', old('nombrebeneficiario'), ['placeholder' => trans('message.solicitud_action.nombrebeneficiario'), 'class' => 'form-control', 'id' => 'nombrebeneficiario_user', 'required' => true]) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('cedulabeneficiario', trans('message.solicitud_action.cedulabeneficiario'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('cedulabeneficiario', old('cedulabeneficiario'), ['placeholder' => trans('message.solicitud_action.cedulabeneficiario'), 'class' => 'form-control', 'id' => 'cedulabeneficiario_user', 'required' => true]) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('edadbeneficiario', 'EDAD BENEFICIARIO', ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('edadbeneficiario', old('edadbeneficiario'), ['placeholder' => 'EDAD BENEFICIARIO', 'class' => 'form-control', 'id' => 'edadbeneficiario_user', 'required' => true]) !!}
                        </div>                    
                    @if($rols_id != 10)
                    <div style="text-align:left;">
                        {!! Form::label('telefono2', 'TELEFONO DE CASA', ['class' => 'control-label']) !!}
                        {!! Form::text('telefono2', old('telefono2'), ['placeholder' => trans('message.solicitud_action.telefono2'), 'class' => 'form-control', 'id' => 'telefono2_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('email', 'CORREO', ['class' => 'control-label']) !!}
                        {!! Form::email('email', old('email'), ['placeholder' => trans('message.users_action.mail_ejemplo'), 'class' => 'form-control', 'id' => 'email_user']) !!}
                    </div>
                    @endif
                    <div style="text-align:left;">
                        <label>SEXO <span style="color:red;">*</span></label>
                            <select name="sexo" id="sexo" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" required>
                            <option value="">SELECCIONE UNA OPCION</option>
                            <option value="MASCULINO">MASCULINO</option>
                            <option value="FEMENINO">FEMENINO</option>
                        </select>
                    </div>
                    @if($rols_id != 10)
                    <div style="text-align:left;">
                        <label>ESTADO CIVIL*</label>
                        <select required name="edocivil" id="edocivil" class="selectpicker form-control"
                            data-live-search="true" data-live-search-style="begins">
                            <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                            <option value="SOLTERO">SOLTERO</option>
                            <option value="CASADO">CASADO</option>
                            <option value="VIUDO">VIUDO</option>
                            <option value="DIVORCIADO">DIVORCIADO</option>
                        </select>
                    </div>
                    @endif
                    @if($rols_id != 10)
                    <div style="text-align:left;">
                        <label>FECHA NACIMIENTO</label>
                        <input type="date" id="fechanacimiento" name="fechanacimiento" class="form-control">
                    </div>
                    <div style="text-align:left;">
                        <label>NIVEL EDUCATIVO*</label>
                        <select required name="niveleducativo" id="niveleducativo" class="selectpicker form-control"
                            data-live-search="true" data-live-search-style="begins">
                            <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                            <option value="PRIMARIA">PRIMARIA</option>
                            <option value="SECUNDARIA">SECUNDARIA</option>
                            <option value="BACHILLERATO">BACHILLERATO</option>
                            <option value="UNIVERSITARIO">UNIVERSITARIO</option>
                            <option value="ESPECIALIZACION">ESPECIALIZACION</option>
                        </select>
                    </div>

                    <div style="text-align:left;">
                        <label>OCUPACION O/U OFICIO*</label>
                        <select required name="profesion" id="profesion" class="selectpicker form-control"
                            data-live-search="true" data-live-search-style="begins">
                            <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                            <option value="OBRERO">OBRERO</option>
                            <option value="JUBILADO">JUBILADO</option>
                            <option value="PENSIONADO">PENSIONADO</option>
                            <option value="OFICIOS DEL HOGAR">OFICIOS DEL HOGAR</option>
                            <option value="OTRO">OTRO</option>
                            <option value="TECNICO MEDIO">TECNICO MEDIO</option>
                            <option value="TECNICO SUPERIOR">TECNICO SUPERIOR</option>
                            <option value="INGENIERO CIVIL">INGENIERO</option>
                            <option value="ABOGADO">ABOGADO</option>
                            <option value="MEDICO CIRUJANO">MEDICO CIRUJANO</option>
                            <option value="HISTORIADOR">HISTORIADOR</option>
                            <option value="PALEONTOLOGO">PALEONTOLOGO</option>
                            <option value="GEOGRAFO">GEOGRAFO</option>
                            <option value="BIOLOGO">BIOLOGO</option>
                            <option value="PSICOLOGO">PSICOLOGO</option>
                            <option value="MATEMATICO">MATEMATICO</option>
                            <option value="ARQUITECTO">ARQUITECTO</option>
                            <option value="COMPUTISTA">COMPUTISTA</option>
                            <option value="PROFESOR">PROFESOR</option>
                            <option value="PERIODISTA">PERIODISTA</option>
                            <option value="BOTANICO">BOTANICO</option>
                            <option value="FISICO">FISICO</option>
                            <option value="SOCIOLOGO">SOCIOLOGO</option>
                            <option value="FARMACOLOGO">FARMACOLOGO</option>
                            <option value="QUIMICO">QUIMICO</option>
                            <option value="POLITOLOGO">POLITOLOGO</option>
                            <option value="ENFERMERO">ENFERMERO</option>
                            <option value="ELECTRICISTA">ELECTRICISTA</option>
                            <option value="BIBLIOTECOLOGO">BIBLIOTECOLOGO</option>
                            <option value="PARAMEDICO">PARAMEDICO</option>
                            <option value="TECNICO DE SONIDO">TECNICO DE SONIDO</option>
                            <option value="ARCHIVOLOGO">ARCHIVOLOGO</option>
                            <option value="MUSICO">MUSICO</option>
                            <option value="FILOSOFO">FILOSOFO</option>
                            <option value="SECRETARIA">SECRETARIA</option>
                            <option value="TRADUCTOR">TRADUCTOR</option>
                            <option value="ANTROPOLOGO">ANTROPOLOGO</option>
                            <option value="TECNICO TURISMO">TECNICO TURISMO</option>
                            <option value="ECONOMISTA">ECONOMISTA</option>
                            <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                            <option value="CARPITERO">CARPITERO</option>
                            <option value="RADIOLOGO">RADIOLOGO</option>
                            <option value="COMERCIANTE">COMERCIANTE</option>
                            <option value="CERRAJERO">CERRAJERO</option>
                            <option value="COCINERO">COCINERO</option>
                            <option value="ALBAÑIL">ALBAÑIL</option>
                            <option value="PLOMERO">PLOMERO</option>
                            <option value="TORNERO">TORNERO</option>
                            <option value="EDITOR">EDITOR</option>
                            <option value="ESCULTOR">ESCULTOR</option>
                            <option value="ESCRITOR">ESCRITOR</option>
                            <option value="BARBERO">BARBERO</option>
                        </select>
                    </div>
                    @endif
                    
                    <div style="text-align:left;">
                        {!! Form::label('estado_id', 'ESTADO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('estado_id', $estado, old('estado_id'), ['placeholder' => trans('message.solicitud_action.estado'), 'class' => 'form-control', 'id' => 'estado_id', 'required' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('municipio_id', 'MUNICIPIO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('municipio_id', $municipio, old('municipio_id'), ['placeholder' => trans('message.solicitud_action.municipio'), 'class' => 'form-control', 'id' => 'municipio_id', 'required' => true]) !!}
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('parroquia_id', 'PARROQUIA', ['class' => 'control-label', 'id' => 'parroquia_id_label']) !!}<span
                            class="required" style="color:red;" id="parroquia_id_span">*</span>
                        {!! Form::select('parroquia_id', $parroquia, old('parroquia_id'), ['placeholder' => trans('message.solicitud_action.parroquia'), 'class' => 'form-control', 'id' => 'parroquia_id']) !!}
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('comuna_id', 'COMUNA', ['class' => 'control-label', 'id' => 'comuna_id_label']) !!}<span
                            class="required" style="color:red;" id="comuna_id_span">*</span>
                        <select required name="comuna_id" id="comuna_id" class="form-control">
                            @foreach($comuna as $key => $value)
                                <option value="{{ $value->id }}" @if(old('comuna_id', $solicitud_edit->comuna_id) == $value->id) selected @endif>{{ $value->codigo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('comunidad_id', 'COMUNIDAD', ['class' => 'control-label', 'id' => 'comunidad_id_label']) !!}<span
                            class="required" style="color:red;" id="comunidad_id_span">*</span>
                        {!! Form::select('comunidad_id', $comunidad, old('comunidad_id'), ['placeholder' => trans('message.solicitud_action.comunidad'), 'class' => 'form-control', 'id' => 'comunidad_id']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('jefecomunidad_id', 'JEFE DE COMUNIDAD', ['class' => 'control-label', 'id' => 'jefecomunidad_Label']) !!}
                        <select name="jefecomunidad_id" id="jefecomunidad_id" class="form-control">
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Nombre_Jefe_Comunidad }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if($rols_id != 10)
                    <div style="text-align:left;">
                        {!! Form::label('telefonoJEFE_label', 'TELEFONO DEL JEFE DE COMUNIDAD', ['class' => 'control-label', 'id' => 'telefonoJEFE_label']) !!}<span
                            class="required" style="color:red;" id="telefonoJEFE_span">*</span>
                        <p name="telefonoJEFE" id="telefonoJEFE" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Telefono_Jefe_Comunidad }}
                                </option>
                            @endforeach
                        </p>
                    </div>
                    @endif
                    <div style="text-align:left;">
                        {!! Form::label('nombreUBCH_label','NOMBRE DE UBCH', ['class' => 'control-label', 'id' => 'nombreUBCH_label']) !!}
                        <p name="nombreUBCH" id="nombreUBCH" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Nombre_Ubch }}
                                </option>
                            @endforeach
                        </p>
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('nomjefeUBCH_label', 'NOMBRES DEL JEFE DE UBCH', ['class' => 'control-label', 'id' => 'nomjefeUBCH_label']) !!}
                        <p name="nomjefeUBCH" id="nomjefeUBCH" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Nombre_Jefe_Ubch }}
                                </option>
                            @endforeach
                        </p>
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('teljefeUBCH_label', 'TELEFONO DEL JEFE DE UBCH', ['class' => 'control-label', 'id' => 'teljefeUBCH_label']) !!}
                        <p name="teljefeUBCH" id="teljefeUBCH" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Telefono_Jefe_Ubch }}
                                </option>
                            @endforeach
                        </p>
                    </div>
                    @if($rols_id == 10)
                    <div style="text-align:left;">
                    {!! Form::label('tipo_subsolicitud_id', 'TIPO SOLICITUD', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        <select required name="tipo_subsolicitud_id" id="tipo_subsolicitud_id" class="form-control">                           
                            @foreach($subtiposolicitud as $subtipo)
                                <option value="{{ $subtipo->id }}" {{ old('tipo_subsolicitud_id') == $subtipo->id ? 'selected' : '' }}>{{ $subtipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div style="text-align:left;">
                        {!! Form::label('solicita', 'SOLICITA', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('solicita', isset($valores[0]["solicita"]) ? $valores[0]["solicita"] : '', ['placeholder' => 'Solicita', 'class' => 'form-control', 'id' => 'solicita_user', 'required' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('venApp', 'CODIGO VENAPP', ['class' => 'control-label']) !!}
                        {!! Form::text('venApp', isset($valores[0]["venApp"]) ? $valores[0]["venApp"] : '', ['placeholder' => 'Codigo', 'class' => 'form-control', 'id' => 'venApp_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('direccionbeneficiario', trans('message.solicitud_action.direccionbeneficiario'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('direccionbeneficiario', old('direccionbeneficiario'), ['placeholder' => trans('message.solicitud_action.direccionbeneficiario'), 'class' => 'form-control', 'id' => 'direccionbeneficiario_user', 'required' => true]) !!}
                    </div>   
                    <div style="text-align:left;">
                        {!! Form::label('observacionbeneficiario', "OBSERVACION", ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::textarea('observacionbeneficiario', old('observacionbeneficiario'), ['placeholder' => "OBSERVACION", 'class' => 'form-control', 'id' => 'observacionbeneficiario_user', 'required' => true]) !!}
                    </div>   
                    <div id="denunciado">
                        <h3>DATOS DEL DENUNCIADO </h3>
                        <br>
                        <div style="text-align:left;">
                            {!! Form::label('ceduladenunciado', trans('message.solicitud_action.ceduladenunciado'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('ceduladenunciado', old('ceduladenunciado'), ['placeholder' => trans('message.solicitud_action.ceduladenunciado'), 'class' => 'form-control', 'id' => 'ceduladenunciado_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('nombredenunciado', trans('message.solicitud_action.nombredenunciado'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('nombredenunciado', old('nombredenunciado'), ['placeholder' => trans('message.solicitud_action.nombredenunciado'), 'class' => 'form-control', 'id' => 'nombredenunciado_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('testigo', trans('message.solicitud_action.testigo'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('testigo', old('testigo'), ['placeholder' => trans('message.solicitud_action.testigo'), 'class' => 'form-control', 'id' => 'testigo_user']) !!}
                        </div>
                        <h3>Descripcion de Hechos </h3>
                        <br>

                        <div style="text-align:left;">
                            {!! Form::label('relato', trans('message.solicitud_action.relato'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('relato', old('relato'), ['placeholder' => trans('message.solicitud_action.relato'), 'class' => 'form-control', 'id' => 'relato_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('observacion', trans('message.solicitud_action.observacion'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('observacion', old('observacion'), ['placeholder' => trans('message.solicitud_action.observacion'), 'class' => 'form-control', 'id' => 'observacion_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            <label>DENUNCIA PRESENTADA*</label>
                            <select required name="presentada" id="presentada" class="selectpicker form-control"
                                data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('explique', trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('explique', old('observacion'), ['placeholder' => trans('message.solicitud_action.explique'), 'class' => 'form-control', 'id' => 'explique_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            <label>COMPETENCIA*</label>
                            <select required name="competencia" id="competencia" class="selectpicker form-control"
                                data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('explique2', trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('explique2', old('observacion'), ['placeholder' => trans('message.solicitud_action.explique'), 'class' => 'form-control', 'id' => 'explique_user']) !!}
                        </div>
                        <h3>RECAUDOS DE LA DENUNCIA</h3>
                        <br>
                        <div class="col">
                            <div style="text-align:left;">
                                <input type="checkbox" id="checkcedula" name="checkcedula">
                                <label class="form-check-label" for="defaultCheck1">Copia Cedula</label>
                            </div>
                            <div style="text-align:left;">
                                <input type="checkbox" id="checkmotivo" name="checkmotivo">
                                <label class="form-check-label" for="defaultCheck1">Exposicion de Motivo</label>
                            </div>
                            <div style="text-align:left;">
                                <input type="checkbox" id="checkvideo" name="checkvideo">
                                <label class="form-check-label" for="defaultCheck1">Video</label>
                            </div>
                            <div style="text-align:left;">
                                <input type="checkbox" id="checkfoto" name="checkfoto">
                                <label class="form-check-label" for="defaultCheck1">Fotos</label>
                            </div>
                            <div style="text-align:left;">
                                <input type="checkbox" id="checkgrabacion" name="checkgrabacion">
                                <label class="form-check-label" for="defaultCheck1">Grabacion</label>
                            </div>
                            <div style="text-align:left;">
                                <input type="checkbox" id="checktestigo" name="checktestigo">
                                <label class="form-check-label" for="defaultCheck1">Cedula Testigo</label>
                            </div>
                            <div style="text-align:left;">
                                <input type="checkbox" id="checkresidencia" name="checkresidencia">
                                <label class="form-check-label" for="defaultCheck1">Carta Residencia</label>
                            </div>
                        </div>
                    </div>
                    <div id="sugerencia">
                        <h3>Sugerencia o Asesoria</h3>
                        <div style="text-align:left;">
                            {!! Form::label('observacion2', trans('message.solicitud_action.observacion'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('observacion2', old('observacion'), ['placeholder' => trans('message.solicitud_action.observacion'), 'class' => 'form-control', 'id' => 'observacion_user']) !!}
                        </div>
                        <h3>Recuados de la Solicitud</h3>
                        <br>
                        <div style="text-align:left;">
                            <input type="checkbox" id="checkmotivo2" name="checkmotivo2">
                            <label class="form-check-label" for="defaultCheck1">Exposicion de Motivo</label>
                        </div>
                    </div>

                    <div id="beneficiario">
                        <h3>DATOS DEL SOLICITANTE</h3>
                        <div style="text-align:left;">
                        {!! Form::label('nombre', 'NOMBRES', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('nombre', old('nombre'), ['placeholder' => trans('message.users_action.nombre'), 'class' => 'form-control', 'id' => 'nombre_user', 'required' => true]) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('cedula', 'CEDULA', ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('cedula', old('cedula'), ['placeholder' => trans('message.solicitud_action.cedula'), 'class' => 'form-control', 'id' => 'cedula_user', 'required' => true]) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('telefono', 'TELEFONO', ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('telefono', old('telefono'), ['placeholder' => trans('message.solicitud_action.telefono'), 'class' => 'form-control', 'id' => 'telefono_user', 'required' => true]) !!}
                        </div>
                        @if($rols_id = 10)
                        <div style="text-align:left;">
                            <label>EDAD</label><span
                            class="required" style="color:red;">*</span>
                            <input type="text" id="fechanacimiento" name="fechanacimiento" class="form-control" required>
                        </div>
                        @endif
                        <div style="text-align:left;">
                            {!! Form::label('direccion','DIRECCION', ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('direccion', old('direccion'), ['placeholder' => trans('message.solicitud_action.direccion'), 'class' => 'form-control', 'id' => 'direccion_user', 'required' => true]) !!}
                        </div>                        
                        <h3>RECAUDOS DE LA SOLICITUD</h3>
                        <br>
                        <div style="text-align:left;">
                            <input type="checkbox" id="checkcedula2" name="checkcedula2">
                            <label class="form-check-label" for="defaultCheck1">COPIA CEDULA SOLICITANTE</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="checkmotivo3" name="checkmotivo3">
                            <label class="form-check-label" for="defaultCheck1">EXPOSICION DE MOTIVO</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="recipe" name="recipe">
                            <label class="form-check-label" for="defaultCheck1">RECIPES</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="checkinforme" name="checkinforme">
                            <label class="form-check-label" for="defaultCheck1">INFORME MEDICO</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="checkcedulabeneficiario" name="checkcedulabeneficiario">
                            <label class="form-check-label" for="defaultCheck1">COPIA CEDULA BENEFICIARIO</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="checkpresupuesto" name="checkpresupuesto">
                            <label class="form-check-label" for="defaultCheck1">PRESUPUESTO (BS)</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="evifotobeneficiario" name="evifotobeneficiario">
                            <label class="form-check-label" for="defaultCheck1">EVIDENCIA FOTOGRAFICA</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="permisoinhumacion" name="permisoinhumacion">
                            <label class="form-check-label" for="defaultCheck1">PERMISO DE INHUMACION</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="certificadodefuncion" name="certificadodefuncion">
                            <label class="form-check-label" for="defaultCheck1">CERTIFICADO DE DEFUNSION</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="ordenexamen" name="ordenexamen">
                            <label class="form-check-label" for="defaultCheck1">ORDEN DE EXAMEN</label>
                        </div>
                        <div style="text-align:left;">
                            <input type="checkbox" id="ordenestudio" name="ordenestudio">
                            <label class="form-check-label" for="defaultCheck1">ORDEN DE ESTUDIO</label>
                        </div>
                    </div>
                    <div style="text-align:left;">

                        @if($rols_id != 10)
                            <div id=sinasignar>


                                <label>ASIGNACION*</label>
                                <select required name="asignacion" id="asignacion" class="selectpicker form-control"
                                    data-live-search="true" data-live-search-style="begins">
                                    <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                    <option value="DIRECCION">DIRECCION</option>
                                    <option value="ENTER">ENTER</option>
                                </select>
                            </div>

                            <div id="direccion">
                                <div style="text-align:left;">
                                    {!! Form::label('direcciones_id', trans('message.solicitud_action.direcciones'), ['class' => 'control-label']) !!}<span
                                        class="required" style="color:red;">*</span>
                                    {!! Form::select('direcciones_id', $direcciones, old('direcciones_id'), ['placeholder' => trans('message.solicitud_action.direcciones'), 'class' => 'form-control', 'id' => 'direcciones_id', 'required' => true]) !!}
                                </div>
                                <div style="text-align:left;">
                                    {!! Form::label('coordinacion_id', trans('message.solicitud_action.coordinacion'), ['class' => 'control-label']) !!}<span
                                        class="required" style="color:red;">*</span>
                                    {!! Form::select('coordinacion_id', $coordinacion, old('coordinacion_id'), ['placeholder' => trans('message.solicitud_action.coordinacion'), 'class' => 'form-control', 'id' => 'coordinacion_id', 'required' => true]) !!}
                                </div>
                            </div>
                            <div id="enter">
                                <div style="text-align:left;">
                                    {!! Form::label('enter_id', trans('message.solicitud_action.enter'), ['class' => 'control-label']) !!}<span
                                        class="required" style="color:red;">*</span>
                                    {!! Form::select('enter_id', $enter, old('enter_id'), ['placeholder' => trans('message.solicitud_action.enter'), 'class' => 'form-control', 'id' => 'enter_id', 'required' => true]) !!}
                                </div>

                            </div>
                        @endif 
                    </div>

                </div>

                <br>
                {!! Form::submit(trans('message.solicitud_action.new_solicitud'), ['class' => 'form-control btn btn-primary', 'title' => trans('message.solicitud_action.new_solicitud'), 'data-toggle' => 'tooltip', 'style' => 'background-color:' . $array_color['group_button_color'] . ';']) !!}
            </div>
            {!!  Form::close() !!}
        </div>
    </div>
</div>
</div>
@endsection
@section('script_datatable')


<script type="text/javascript">

    $(document).ready(function () {
        var rolID = rolsJS;
        
        // $("#comuna_id").empty()
        $("#comuna_id").html('<option value="">COMUNA<option/>')

        // const comuna = $('#parroquia_id')
        $("#municipio_id").prop('disabled', true);
        $("#parroquia_id").prop('disabled', true);
        $("#comuna_id").prop('disabled', true);
        $("#comunidad_id").prop('disabled', true);
        $("#denunciado").hide();
        $("#sugerencia").hide();
        if (rolID == 10) {
            x = $("#tipo_solicitud_id").val();
            $("#direccion").show();
            $("#beneficiario").show();
        } else {
            $("#beneficiario").hide();
            $("#direccion").hide();
        }
        $("#sinasignar").hide();
        $("#enter").hide();
        $('#municipio_id').change(function () {
            $("#parroquia_id").prop('disabled', false)
        });

        $('#estado_id').change(function () {
            $("#municipio_id").prop('disabled', false);

        });

        $('#tiposolicitud_id').change(function () {
            var tiposolicitud_id = $('#tiposolicitud_id').val();

            $.ajax({
                url: '/getTipoSolicitudes', // Ruta a tu controlador
                type: 'GET',
                data: { tiposolicitud_id: tiposolicitud_id }, // Datos a enviar al controlador
                success: function (data) {
                    // Limpiar las opciones existentes del select
                    $('#subtiposolicitud_id').empty();

                    // Agregar un placeholder si el select no está deshabilitado
                    if ($('#subtiposolicitud_id').not(':disabled')) {
                        $('#subtiposolicitud_id').append('<option value="">{{ trans('message.solicitud_action.tipo_solicitud') }}</option>');
                    }

                    // Agregar las nuevas opciones al select
                    $.each(data, function (key, value) {
                        $('#subtiposolicitud_id').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                }
            });
        });

        $('#municipio_id').change(function () {
            var municipio = $('#municipio_id').val();
            if (municipio == 2) {
                $("#parroquia_id").hide();
                $("#parroquia_id_label").hide();
                $("#parroquia_id_span").hide();
                $("#comuna_id").hide();
                $("#comuna_id_label").hide();
                $("#comuna_id_span").hide();
                $("#comunidad_id").hide();
                $("#comunidad_id_label").hide();
                $("#comunidad_id_span").hide();
                $("#jefecomunidad_Label").hide();
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
            } else {
                $("#parroquia_id").show();
                $("#parroquia_id_label").show();
                $("#parroquia_id_span").show();
                $("#comuna_id").show();
                $("#comuna_id_label").show();
                $("#comuna_id_span").show();
                $("#comunidad_id").show();
                $("#comunidad_id_label").show();
                $("#comunidad_id_span").show();
                $("#jefecomunidad_id").show();
                $("#jefecomunidad_Label").show();
                $("#jefecomunidad_Span").show();
                $("#telefonoJEFE").show();
                $("#telefonoJEFE_label").show();
                $("#telefonoJEFE_span").show();
                $("#nombreUBCH").show();
                $("#nombreUBCH_label").show();
                $("#nombreUBCH_span").show();
                $("#nomjefeUBCH").show();
                $("#nomjefeUBCH_label").show();
                $("#nomjefeUBCH_span").show();
                $("#teljefeUBCH").show();
                $("#teljefeUBCH_label").show();
                $("#teljefeUBCH_span").show();
            }
        })

        $('#parroquia_id').change(function () {
            var parroquia = $('#parroquia_id').val();
            $("#comuna_id").prop('disabled', false);

            $.ajax({
                url: "{{ route('getComunas') }}",
                type: "GET",
                data: { parroquia: parroquia },
                success: function (data) {
                    $("#comuna_id").empty();
                    $("#comuna_id").append('<option value="">COMUNA</option>'); // Opción inicial
                    $.each(data, function (key, value) {
                        $("#comuna_id").append('<option value="' + value.id + '">' + value.codigo + '</option>');
                    });
                },
                error: function () {
                    alert("Error al cargar las comunas."); // Manejo de errores
                }
            });
        });


        $('#asignacion').change(function () {

            var asignacion = $("#asignacion").val();

            if (asignacion == "DIRECCION") {
                $("#enter").hide();
                $("#direccion").show();

            }
            if (asignacion == "ENTER") {
                $("#enter").show();
                $("#direccion").hide();

            }
        })

        $('#comuna_id').change(function () {
            var comunaId = $(this).val();
            var comuna = $('#comuna_id').val();
            $("#jefecomunidad_id").prop('disabled', false);
            $("#comunidad_id").prop('disabled', false);

            $.ajax({
                url: "{{ route('getJefeComunidad') }}", // Ruta a tu controlador
                type: "GET",
                data: { comuna_id: comunaId },
                success: function (data) {
                    $("#jefecomunidad_id").empty(); // Limpia opciones anteriores
                    $("#jefecomunidad_id").append('<option value="">Seleccione Jefe de Comunidad</option>'); // Opción inicial

                    $.each(data, function (key, value) {
                        $("#jefecomunidad_id").append('<option value="' + value.id + '">' + value.Nombre_Jefe_Comunidad + '</option>');
                    });
                },
                error: function () {
                    // Manejo de errores (opcional)
                    alert("Error al cargar los jefes de comunidad.");
                }
            })
            $.ajax({
                url: "{{ route('getComunidad2') }}", // Ruta a tu controlador
                type: "GET",
                data: { comuna: comuna },
                success: function (data) {
                    $("#comunidad_id").empty(); // Limpia opciones anteriores
                    $("#comunidad_id").append('<option value="">Seleccione Comunidad</option>'); // Opción inicial

                    $.each(data, function (key, value) {
                        $("#comunidad_id").append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                },
                error: function () {
                    // Manejo de errores (opcional)
                    alert("Error al cargar la comunidad.");
                }
            });
        });

        $('#jefecomunidad_id').change(function () {
            var jefecomunidadID = $(this).val();
            $("#jefecomunidad_id").append('<option value="">Seleccione Jefe de Comunidad</option>'); // Opción inicial

            $.ajax({
                url: "{{ route('getJefeComunidad2') }}",
                type: "GET",
                data: { jefecomunidadID: jefecomunidadID },
                success: function (data) {
                    // Verifica si se recibieron datos
                    if (data.length > 0) {
                        var value = data[0]; // Accede al primer elemento del array

                        // Actualiza los campos usando .text() para elementos <p>
                        $("#telefonoJEFE").text(value.Telefono_Jefe_Comunidad);
                        $("#nombreUBCH").text(value.Nombre_Ubch);
                        $("#nomjefeUBCH").text(value.Nombre_Jefe_Ubch);
                        $("#teljefeUBCH").text(value.Telefono_Jefe_Ubch);
                    } else {
                        // Maneja el caso donde no se encontraron datos
                        $("#telefonoJEFE").text('');
                        $("#nombreUBCH").text('');
                        $("#nomjefeUBCH").text('');
                        $("#teljefeUBCH").text('');
                    }
                },
                error: function () {
                    alert("Error al cargar los datos.");
                }
            });
        });



        $('#direcciones_id').change(function () {
            var direccion = $('#direcciones_id').val();

            $.ajax({

                url: "{{ route('getCoodinacion') }}",
                type: "GET",
                data: { direccion: direccion }

            }).done(function (data) {
                // alert(JSON.stringify(data));

                $("#coordinacion_id").empty();
                $("#coordinacion_id").html('<option value="">COORDINACION<option/>');
                for (let c in data) {

                    $("#coordinacion_id").append(`<option value="${c}">${data[c]}<option/>`);

                }
                //  $("#comuna_id").find("option[value='']").remove();
                // $("#comuna_id").change();

            })

        });


        $('#tipo_solicitud_id').change(function () {

            var tipo = $('#tipo_solicitud_id').val();
            if (tipo == 0) {
                $("#denunciado").hide();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }

            if (tipo == 1) {
                $("#denunciado").show();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }

            if (tipo == 2) {
                $("#denunciado").show();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }
            if (tipo == 3) {
                $("#denunciado").show();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }
            if (tipo == 4) {
                $("#denunciado").hide();
                $("#sugerencia").show();
                $("#beneficiario").hide();
            }
            if (tipo == 5) {
                $("#denunciado").hide();
                $("#sugerencia").show();
                $("#beneficiario").hide();
            }
            if (tipo == 6) {
                $("#denunciado").hide();
                $("#sugerencia").hide();
                $("#beneficiario").show();
            }

        });
    })
</script>
<style>
section.content{
        background-image: url("{{ url('/images/siacreate.jpg') }}");
}
</style>
@endsection

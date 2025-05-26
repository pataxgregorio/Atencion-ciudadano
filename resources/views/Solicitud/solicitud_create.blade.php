@extends('adminlte::layouts.app')

@section('css_database')
@include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
<h2 style="margin: -25px 0px 0px 25px"><img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="100px" >Crear Solicitud</h2>

    @component('components.boton_back', ['ruta' => route('solicitud.index'), 'color' => $array_color['back_button_color']])
    Botón de retorno
    @endcomponent
</div>
<div style="text-align: right;">
        <span>Nro. de la Solicitud:</span>
        <input type="text" class="form-control" value="{{ $correlativoSALUD }}" style="font-weight: bold; font-size: 28px; width: 100px; display: inline-block;" readonly>
    </div>
@endsection


@section('main-content')

<div class="container-fluid w-50" style="" >
 <div class="row" style="margin-left: 100px">  {{-- Added a row to manage the layout --}}
  <div class="col-md-9">  {{-- columna principal    9 --}}

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
                        <form id="buscarPersonaForm">
                        @csrf


                        </form>

                            {!! Form::open(
                            array(
                                'route' => array('solicitud.store'),
                                'method' => 'POST',
                                'id' => 'form_solicitud_id',
                                'enctype' => 'multipart/form-data'
                            )
                        ) !!}

                     {{ csrf_field() }}
                      <div class="col-md-6">
                                {!! Form::label('cedula', trans('message.solicitud_action.cedula'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                <div class="row">
                                    <div class="col-md-6" >
                                    {!! Form::text('cedula', old('cedula'), ['placeholder' => trans('message.solicitud_action.cedula'), 'class' => 'form-control', 'id' => 'cedula_user', 'required' => true]) !!}
                                    <button type="button" class="btn btn-primary ml-2" style="margin-left: 250px; margin-top: -60px" id="buscarCedula">Buscar</button>
                                    </div>
                                </div>
                            </div>
                    <br>
                    <br>
                    <br>
                         <div class="row" >  {{-- Start of main row for two-column layout --}}
                             <div class="col-md-6" style="margin-left: -470px;">
                                        <h3>DATOS DEL SOLICITANTE</h3>
                                        <input type="hidden" name="cedula" id="cedula_hidden">
                                        <input type="hidden" name="nombre" id="nombre_hidden">
                                        <input type="hidden" name="telefono" id="telefono_hidden">
                                        <input type="hidden" name="sexo" id="sexo_hidden">
                                        <input type="hidden" name="fechanacimiento" id="fechanacimiento_hidden">
                                        <input type="hidden" name="estado_id" id="estado_id_hidden">
                                        <input type="hidden" name="municipio_id" id="municipio_id_hidden">
                                        <input type="hidden" name="parroquia_id" id="parroquia_id_hidden">
                                        <input type="hidden" name="comuna_id" id="comuna_id_hidden">
                                        <input type="hidden" name="comunidad_id" id="comunidad_id_hidden">
                                        <input type="hidden" name="jefecomunidad_id" id="jefecomunidad_id_hidden">
                                        <input type="hidden" name="direccion" id="direccion_hidden">
                                        <br>

                                        <div style="text-align:left;">
                                        {!! Form::label('nombre', 'NOMBRES', ['class' => 'control-label']) !!}<span
                                            class="required" style="color:red;">*</span>
                                        {!! Form::text('nombre', old('nombre'), ['placeholder' => trans('message.users_action.nombre'), 'class' => 'form-control', 'id' => 'nombre_user', 'required' => true]) !!}
                                        </div>

                                        <div style="text-align:left;">
                                            {!! Form::label('telefono', 'TELEFONO', ['class' => 'control-label']) !!}<span
                                                class="required" style="color:red;">*</span>
                                            {!! Form::text('telefono', old('telefono'), ['placeholder' => trans('message.solicitud_action.telefono'), 'class' => 'form-control', 'id' => 'telefono_user', 'required' => true]) !!}
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
                                        <div style="text-align:left;" id="sexo1">
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


                                        <div style="text-align:left;" id="estado">
                                            {!! Form::label('estado_id', 'ESTADO', ['class' => 'control-label']) !!}<span
                                                class="required" style="color:red;">*</span>
                                            {!! Form::select('estado_id', $estado, old('estado_id'), ['placeholder' => trans('message.solicitud_action.estado'), 'class' => 'form-control', 'id' => 'estado_id', 'required' => true]) !!}
                                        </div>
                                        <div style="text-align:left;" id ="minicipio">
                                            {!! Form::label('municipio_id', 'MUNICIPIO', ['class' => 'control-label']) !!}<span
                                                class="required" style="color:red;">*</span>
                                            {!! Form::select('municipio_id', $municipio, old('municipio_id'), ['placeholder' => trans('message.solicitud_action.municipio'), 'class' => 'form-control', 'id' => 'municipio_id', 'required' => true]) !!}
                                        </div>

                                        <div style="text-align:left;" id="parroquia">
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
                                        <div style="text-align:left;" id="direccion1">
                                            {!! Form::label('direccion','DIRECCION', ['class' => 'control-label']) !!}<span
                                                class="required" style="color:red;">*</span>
                                            {!! Form::text('direccion', old('direccion'), ['placeholder' => trans('message.solicitud_action.direccion'), 'class' => 'form-control', 'id' => 'direccion_user', 'required' => true]) !!}
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
                                            <label>FECHA ACTA DE ENTREGA</label>
                                            <input type="date" id="fechaentrega" name="fechaentrega" class="form-control">
                                        </div>
                                        <div style="text-align:left;">
                                            {!! Form::label('solicita', 'BENEFICIO', ['class' => 'control-label']) !!}<span
                                                class="required" style="color:red;">*</span>
                                            {!! Form::textarea('solicita', isset($valores[0]["solicita"]) ? $valores[0]["solicita"] : '', ['placeholder' => 'Solicita', 'class' => 'form-control', 'id' => 'solicita_user', 'required' => true]) !!}
                                        </div>
                                        <div style="text-align:left;">
                                            {!! Form::label('observacionbeneficiario', "OBSERVACION", ['class' => 'control-label']) !!}<span
                                                class="required" style="color:red;">*</span>
                                            {!! Form::textarea('observacionbeneficiario', old('observacionbeneficiario'), ['placeholder' => "OBSERVACION", 'class' => 'form-control', 'id' => 'observacionbeneficiario_user', 'required' => true]) !!}
                                        </div>
                                </div>  {{-- End of main column for two-column layout --}}
                                <div class="col-md-6" style="margin-left: 500px; margin-top: 100px;">

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
                                        {!! Form::submit(trans('message.solicitud_action.new_solicitud'), ['class' => 'form-control btn btn-primary', 'title' => trans('message.solicitud_action.new_solicitud'), 'data-toggle' => 'tooltip', 'style' => 'background-color:' . $array_color['group_button_color'] . ';']) !!}

                                        {!!  Form::close() !!}
                             </div>{{-- End of main column for 3ra-column layout --}}

                        </div>{{-- End of main rowa for 2ra-row layout --}}


                <br>

          </div>{{-- fin del col-md-12 principal --}}
        </div>{{-- fin del card body principal --}}
    </div>{{-- fin del card principal --}}
  </div>
    </div>{{-- fin del row principal --}}
 </div>{{-- fin del cointainer principal --}}
 @endsection
@section('script_datatable')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


<script type="text/javascript">

    $(document).ready(function () {
        var rolID = rolsJS;
        document.getElementById('estado').style.display = 'none';
        document.getElementById('minicipio').style.display = 'none';
        document.getElementById('parroquia').style.display = 'none';
        document.getElementById('sexo1').style.display = 'none';
        document.getElementById('direccion1').style.display = 'none';


        // $("#comuna_id").empty()  $('#buscarCedula').prop('disabled', true);

        $('#buscarCedula').prop('disabled', true);

// Escuchar el evento 'input' en el campo de cédula
$('#cedula_user').on('input', function() {
    // Verificar si el campo de cédula tiene algún valor
    if ($(this).val().trim() !== '') {
        // Si tiene valor, habilitar el botón "Buscar"
        $('#buscarCedula').prop('disabled', false);
    } else {
        // Si está vacío, deshabilitar el botón "Buscar"
        $('#buscarCedula').prop('disabled', true);
    }
});
$("#buscarCedula").click(function(event) {
    event.preventDefault();
    var cedula = $("#cedula_user").val();

    $.ajax({
        url: "{{ route('solicitud.getpersona') }}",
        type: "GET",
        data: { cedula: cedula },
        dataType: "json"
    })
    .done(function(data) {
        // Verificar si data está vacío o indica que no se encontraron resultados
        if (!data || Object.keys(data).length === 0) {
            alert("La cédula ingresada no existe.");
            document.getElementById('estado').style.display = 'block';
            document.getElementById('minicipio').style.display = 'block';
            document.getElementById('parroquia').style.display = 'block';
            document.getElementById('sexo1').style.display = 'block';
            document.getElementById('direccion1').style.display = 'block';
           $("#cedula_hidden").val($("#cedula_user").val());
        //    window.location.href = "{{ route('solicitud.create') }}"; // Redireccionar si no se encuentra
            return; // Importante: detener la ejecución del resto del bloque .done()
        }

        // Mostrar los campos del formulario
      //  alert(JSON.stringify(data)); // Para ver la estructura de la data
        $("#div_nombre").show();
        $("#div_telefono").show();
        $("#div_sexo").show();
        $("#div_fechanacimiento").show();
        $("#div_estado").show();
        $("#div_municipio").show();
        $("#div_parroquia").show();
        $("#div_comuna").show();
        $("#div_comunidad").show();
        $("#div_jefecomunidad").show();
        $("#div_numero_jefe_comunidad").show();
        $("#div_ubch").show();
        $("#div_jefe_ubch").show();
        $("#div_telefono_jefe_ubch").show();
        $("#div_direccion").show();

        // Asignar los valores básicos a los inputs invisibles
        const fechaUltimaSolicitud = new Date(data.fecha);
        let dias = calcularDiasTranscurridos(fechaUltimaSolicitud);
// Corregir la sintaxis del if y el mensaje de la alerta
        var fechaMoment = moment(data.fecha);
       var fechaFormateada = fechaMoment.format('DD-MM-YYYY');

            if (dias < 30) {
                alert("El solicitante tiene menos de 30 días de haber solicitado el beneficio. La Última fecha de solicitud: " + fechaFormateada);
            }
        $("#cedula_hidden").val(data.cedula);
        $("#nombre_user").val(data.nombre);
        $("#telefono_user").val(data.telefono);
        $("#sexo").val(data.sexo);
        $("#fechanacimiento").val(data.fechanacimiento);
        $("#estado_id").val(data.estado_id);
        $("#direccion_user").val(data.direccion);
        $("#municipio_id").val(data.municipio_id);
        $("#parroquia_id").val(data.parroquia_id);
         $("#comuna_id").val(data.comuna_id);
         $("#comunidad_id").val(data.comunidad_id);
         $("#municipio_id_hidden").val(data.municipio_id);
        $("#parroquia_id_hidden").val(data.parroquia_id);
        $("#comuna_id_hidden").val(data.comuna_id);
        $("#comunidad_id_hidden").val(data.comunidad_id);
        $("#direccion_hidden").val(data.direccion);

        cargarMunicipios(data.estado_id, data)
        .then(municipio_id => cargarParroquias(municipio_id, data))
        .then(parroquia_id => cargarComunas(parroquia_id, data))
        .then(comuna_id => cargarComunidades(comuna_id, data))
        .catch(error => {
            console.error("Error en la cascada:", error);
            alert("Ocurrió un error al cargar la información adicional. Por favor, inténtalo de nuevo más tarde.");
        });
    })
    .fail(function(xhr) {
        console.log("Error en la petición AJAX:", xhr); // Para depuración
        if (xhr.responseJSON && xhr.responseJSON.error) {
            alert(xhr.responseJSON.error); // Mostrar el mensaje de error específico del servidor
        } else {
            alert("Error al buscar la persona. Por favor, verifica la cédula e inténtalo de nuevo.");
        }
    });
});
function calcularDiasTranscurridos(fechaInput) {
    // 1. Validar si la entrada es un objeto Date válido
    if (!(fechaInput instanceof Date) || isNaN(fechaInput.getTime())) {
        console.error("La entrada 'fechaInput' debe ser un objeto Date válido. Se recibió:", fechaInput);
        return NaN; // Retorna NaN o maneja el error como prefieras
    }

    // 2. Obtener la fecha actual (solo la fecha, sin la hora)
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // Establecer la hora a medianoche

    // 3. Ajustar la fecha de entrada a medianoche también
    const fechaAjustada = new Date(fechaInput); // Crea una nueva instancia para no modificar el original si es necesario
    fechaAjustada.setHours(0, 0, 0, 0);

    // 4. Calcular la diferencia en milisegundos
    const diferenciaMilisegundos = hoy.getTime() - fechaAjustada.getTime();

    // 5. Definir los milisegundos en un día
    const milisegundosEnUnDia = 1000 * 60 * 60 * 24;

    // 6. Convertir la diferencia de milisegundos a días y redondear hacia abajo
    const diasTranscurridos = Math.floor(diferenciaMilisegundos / milisegundosEnUnDia);

    return diasTranscurridos;
}
function cargarMunicipios(estado_id, data) {
            return $.ajax({
                url: "{{ route('municipio.get') }}",
                type: "GET",
                data: { estado: estado_id }
            })
            .then(function(municipios) {
                llenarSelect("#municipio_id", municipios, data.municipio_id);
                return data.municipio_id;
            });
        }
function cargarParroquias(municipio_id, data) {
            return $.ajax({
                url: "{{ route('parroquia.get') }}",
                type: "GET",
                data: { municipio: municipio_id }
            })
            .then(function(parroquias) {
                llenarSelect("#parroquia_id", parroquias, data.parroquia_id);
                return data.parroquia_id;
            });
        }
        function cargarComunas(parroquia_id, data) {
            return $.ajax({
                url: "{{ route('getComunas') }}",
                type: "GET",
                data: { parroquia: parroquia_id }
            })
            .then(function(comunas) {
                llenarSelect2("#comuna_id", comunas, data.comuna_id);
                return data.comuna_id;
            });
        }

        function cargarComunidades(comuna_id, data) {
            return $.ajax({
                url: "{{ route('getComunidad2') }}",
                type: "GET",
                data: { comuna: comuna_id }
            })
            .then(function(comunidades) {
                llenarSelect("#comunidad_id", comunidades, data.comunidad_id);
                return data.comunidad_id;
            });
        }

        function llenarSelect(selectId, opciones, valorSeleccionado) {
            $(selectId).empty();
            $(selectId).append('<option value="">Seleccione una opción</option>');
            $.each(opciones, function (key, opcion) {
                $(selectId).append('<option value="' + opcion.id + '">' + opcion.nombre + '</option>');
            });
            $(selectId).val(valorSeleccionado);
        }
        function llenarSelect2(selectId, opciones, valorSeleccionado) {
            $(selectId).empty();
            $(selectId).append('<option value="">Seleccione una opción</option>');
            $.each(opciones, function (key, opcion) {
                $(selectId).append('<option value="' + opcion.id + '">' + opcion.codigo + '</option>');
            });
            $(selectId).val(valorSeleccionado);
        }
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
    section.content {
        background-image: url("{{ url('/images/icons/fondo5.jpeg') }}");
        background-size: cover; /* Ajusta la imagen al tamaño de la sección */
        animation: cambiarFondo 15s linear infinite; /* Animación para cambiar el fondo */
        width: 100%;

    }

    @keyframes cambiarFondo {
        0% {
            background-image: url("{{ url('/images/icons/fondo1.jpeg') }}");
        }
        33.33% {
            background-image: url("{{ url('/images/icons/fondo2.jpeg') }}"); /* Reemplaza con la ruta de tu segunda imagen */
        }
        66.66% {
            background-image: url("{{ url('/images/icons/fondo3.jpeg') }}"); /* Reemplaza con la ruta de tu tercera imagen */
        }
        100% {
            background-image: url("{{ url('/images/icons/fondo4-2.jpeg') }}");
        }
    }
</style>
@endsection

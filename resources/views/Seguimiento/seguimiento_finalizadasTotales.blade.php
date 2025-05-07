@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<!-- Componente Button Para todas las Ventanas de los Módulos, no Borrar.-->



@endsection

@section('link_css_datatable')
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/buttons.dataTables.min.css') }}" rel="stylesheet">
@endsection


@section('main-content')
@component('components.alert_msg',['tipo_alert'=>$tipo_alert])
 Componentes para los mensajes de Alert, No Eliminar
@endcomponent
<h2 style="margin: -25px 0px -25px 0px; text-align: center"><img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="100px" >Ayudas Entregadas por Comunas</h2>

<div class="container-fluid">
<div class="container table-borderless" >
    <div class="col-md-6 col-sm-6 table-borderless" >
        <div class="row table-borderless">
        <iframe class="" style="width: 100%; height: 795px; width: 1200px; overflow: hidden;" src="http://156.235.91.67:9000/#/buscarcomunasnoauth" allowfullscreen seamless frameborder="0"></iframe>
        </div>
    </div>
</div>
</div>


@endsection
@section('script_datatable')
<script src="{{ url ('/js_datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_delete/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#btn_listado').click(function() {
            // Obtén los valores de los campos de fecha
            var fechaDesde = $('#fecha_desde').val();
            var fechaHasta = $('#fecha_hasta').val();
            var tipo_subsolicitud = $('#tipo_subsolicitud').val();
            var comuna = $('#comuna').val();
            var comunidad = $('#comunidad').val();

            // Construye la URL con los parámetros
            var url = "{{ route('imprimir2') }}" + "?fecha_desde=" + fechaDesde + "&fecha_hasta=" + fechaHasta + "&tipo_subsolicitud=" + tipo_subsolicitud + "&comuna=" + comuna + "&comunidad=" + comunidad;

            // Redirige a la URL construida
            window.location.href = url;
        });

        $('#btn_totales').click(function() {
            var fechaDesde = $('#fecha_desde').val();
            var fechaHasta = $('#fecha_hasta').val();
            var tipo_subsolicitud = $('#tipo_subsolicitud').val();
            var comuna = $('#comuna').val();
            var comunidad = $('#comunidad').val();

            var url = "{{ route('solicitud.solicitudTotalFinalizadas') }}" + "?fecha_desde=" + fechaDesde + "&fecha_hasta=" + fechaHasta + "&tipo_subsolicitud=" + tipo_subsolicitud + "&comuna=" + comuna + "&comunidad=" + comunidad;

            window.location.href = url;
        });

        $('#comuna').change(function () {
            var comunaId = $(this).val();
            var comuna = $('#comuna').val();
            $("#comunidad").prop('disabled', false);

            $.ajax({
                url: "{{ route('getComunidad2') }}", // Ruta a tu controlador
                type: "GET",
                data: { comuna: comuna },
                success: function (data) {
                    $("#comunidad").empty(); // Limpia opciones anteriores
                    $("#comunidad").append('<option value="">Seleccione Comunidad</option>'); // Opción inicial

                    $.each(data, function (key, value) {
                        $("#comunidad").append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                },
                error: function () {
                    // Manejo de errores (opcional)
                    alert("Error al cargar la comunidad.");
                }
            });
        });

        var table = $('.solicitud_all').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth : false,
            ajax: {
                url: "{{ route('seguimiento.finalizadas') }}",
                data: function (d) {
                    d.fecha_desde = $('#fecha_desde').val();
                    d.fecha_hasta = $('#fecha_hasta').val();
                    d.tipo_subsolicitud = $('#tipo_subsolicitud').val();
                    d.comuna = $('#comuna').val();
                    d.comunidad = $('#comunidad').val();
                }
            },
            columns: [
                {
                    data: 'saludID', name: 'saludID',
                    "render": function ( data, type, row ) {
                        return '<div style="text-align:center;"><b>'+data+'</b></div>';
                    }
                },
                {data: 'usuario', name: 'usuario'},
                {
                    data: 'fecha', name: 'fecha',
                    "render": function ( data, type, row ) {
                        var fechaMoment = moment(data);
                        var fechaFormateada = fechaMoment.format('DD-MM-YYYY, HH:mm');
                        return fechaFormateada;
                    }
                },
                {data: 'solicitante', name: 'solicitante'},
                {data: 'edad', name: 'edad'},
                {data: 'cedula', name: 'cedula'},
                {data: 'direccion', name: 'direccion'},
                {data: 'nombretipo', name: 'nombretipo'},
                {data: 'solicita', name: 'solicita'},
            ],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado !!! - disculpe",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "Registros no disponible",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior",
                }
            }
        });

        $('#btn_filtrar').click(function() {
            table.ajax.reload();
        });
    });
</script>
<script src="{{ url ('/js_delete/delete_confirm.min.js') }}"></script>
<style>
    th{
        text-align: center;
    }
    td {
        text-align: center;
    }
    section.content{
        background-image: url("{{ url('/images/siabuscar.png') }}");
        background-size: 100%;
    }
</style>
@endsection

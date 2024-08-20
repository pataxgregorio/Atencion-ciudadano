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

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha_desde">Fecha Desde:</label>
                    <input type="date" class="form-control" id="fecha_desde">
                </div>
                <div class="col-md-3">
                    <label for="fecha_hasta">Fecha Hasta:</label>
                    <input type="date" class="form-control" id="fecha_hasta">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="btn_filtrar" style="margin-top: 25px;">Filtrar</button>
                </div>
            </div>
            <br>
            <table class="table table-bordered solicitud_all">
                <thead>
                    <tr>
                    <th>Nro Solicitud</th>
                    <th>Fecha</th>
                    <th>Funcionario Receptor</th>
                    <th>Nombre de Solicitante</th>
                    <th>Cedula de Solicitante</th>
                    <th>Tipo de Solicitud</th>
                    <th>Nombre del Beneficiario</th>
                    <th>Cedula Beneficiario</th>
                    <th>Solicita</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <a href="#" id="btn_listado"> <button class="btn btn-primary" style="padding:5px;">Imprimir Listado</button> </a>
    <button class="btn btn-primary" style="padding:5px;" id="btn_totales">Imprimir Totales</button>
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

            // Construye la URL con los parámetros
            var url = "{{ route('imprimir2') }}" + "?fecha_desde=" + fechaDesde + "&fecha_hasta=" + fechaHasta;

            // Redirige a la URL construida
            window.location.href = url;
        });

        $('#btn_totales').click(function() {
            var url = "{{ route('solicitud.solicitudTotalFinalizadas') }}";
            window.location.href = url;
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
                {data: 'cedula', name: 'cedula'}, 
                {data: 'nombretipo', name: 'nombretipo'}, 
                {data: 'beneficiarionombre', name: 'nombrebeneficiario'}, 
                {data: 'cedula2', name: 'cedula2'}, 
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
</style>
@endsection  

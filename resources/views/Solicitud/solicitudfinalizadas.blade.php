@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    <div >
        <h2 class="mb-4" style="text-align: center; display: flex; justify-content: space-between; margin-bottom: -50px">
            <img src="{{ url('/images/icons/logo.png') }}" alt="logo" height="100px">
                <p style="margin-top: 40px; font-size: 36px">Solicitudes Finalizadas</p>
            <img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="150px" style="margin-top: -15px">
        </h2> 
        <p style="margin-top: 15px; font-size: 28px; text-align: center">Reporte Estadistico</p>
    </div>
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
            <h2 style="margin-top: -20px; margin-bottom: 4rem;">Resumen de Solicitudes por Comunas:</h2>
                <div class="row" style="margin-bottom: 4rem">
                    @foreach($solcomunas as $comuna)
                        <div class="col-md-4">
                            <p style="font-size: 16px"><strong>{{$comuna->nombre}}</strong>: {{$comuna->TOTAL_SOLICITUD}}</p>
                        </div>
                    @endforeach
                </div>
                <h2 style="margin-top: 30px;">Listado de Solicitudes Finalizadas:</h2>
                <table class="table table-bordered solicitud_all">
                        <thead>
                            <tr>
                            <th>Nro Solicitud</th>
                            <th>Fecha</th>
                            <th>Funcionario Receptor</th>
                            <th>Nombre de Solicitante</th>
                            <th>Cedula de Solicitante</th>
                            <th>Comuna</th>
                            <th>Tipo de Solicitud</th>
                            <th>Nombre del Beneficiario</th>
                            <th>Cedula Beneficiario</th>
                            <th>Solicita</th>
                        </thead>
                    <tbody>
                    </tbody>
                </table>
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
                {data: 'comuna', name: 'comuna'},
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

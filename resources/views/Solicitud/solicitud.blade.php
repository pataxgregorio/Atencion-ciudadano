@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<h2 style="margin: -25px 0px -25px 0px"><img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="100px" >Listar Solicitudes</h2>

<a href="/solicitud/create"><button style="color: white; background-color: black; width: 200px;border-radius: 7px;height: 30px; font-size: 16px;">Nueva Solicitud</button></a>

  
    
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
                <table class="table table-bordered solicitud_all">
                        <thead>
                            <tr>
                                <th>Nro Solicitud</th>
                                <th>Nombre de Solicitante</th>
                                <th>Fecha</th>
                                <th>Cedula de Solicitante</th>
                                @if(Auth::user()->rols_id === 1)
                                    <th>Cedula 2</th>
                                @endif
                                @if(Auth::user()->rols_id === 10)
                                    <th>Tipo de Solicitud</th>
                                    <th>Nombre del Beneficiario</th>
                                    <th>Cedula Beneficiario</th>
                                @endif
                                <th>Solicita</th>
                                <th>Status</th>
                                <th>{{ trans('message.botones.edit') }}</th>
                                <th>{{ trans('message.botones.view') }}</th>
                            </tr>
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
        ajax: "{{ route('solicitud.list') }}",
        
        columns: [          
            {
                data: 'saludID', name: 'id',
                "render": function ( data, type, row ) {
                    return '<div style="text-align:center;"><b>'+data+'</b></div>';
                }
            },
            {data: 'solicitante', name: 'solicitante'},
            {
                    data: 'fecha', name: 'fecha',
                    "render": function ( data, type, row ) {
                        var fechaMoment = moment(data);
                        var fechaFormateada = fechaMoment.format('DD-MM-YYYY, HH:mm');
                        return fechaFormateada;
                    }
                },
            {data: 'cedula', name: 'cedula'}, 
            {data: 'nombretipo', name: 'nombretipo'}, 
            {data: 'beneficiarionombre', name: 'nombrebeneficiario'}, 
            {data: 'cedula2', name: 'cedula2'}, 
            {data: 'solicita', name: 'solicita'}, 
            {data: 'nombrestatus', name: 'nombrestatus'},          
          
          
            {
                data: 'edit', name: 'edit', orderable: false, searchable: false,
                "render": function ( data, type, row ) {                    
                    return '<div style="text-align:center;">'+data+'</div>';
                }
            },
            {
                data: 'view', name: 'view', orderable: false, searchable: false,                
                "render": function ( data, type, row ) {                    
                    return '<div style="text-align:center;">'+data+'</div>';
                }
            },
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

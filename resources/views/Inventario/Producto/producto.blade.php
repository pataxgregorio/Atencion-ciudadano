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
      <img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="150px" style="margin-top: -15px">
        <p style="margin-top: 40px; font-size: 36px">Productos</p>
        <img src="{{ url('/images/icons/logo.png') }}" alt="logo" height="100px">
      </h2>
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
                <table class="table table-bordered solicitud_all">
                        <thead>
                            <tr>
                                <th>Nro Producto</th>
                                <th>Nombre de Producto</th>
                                <th>descripcion</th>
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
<script type="text/javascript">
    $(function () {

    var table = $('.solicitud_all').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth : false,
        ajax: "{{ route('producto.list') }}",

        columns: [
            {
                data: 'id', name: 'id',
                "render": function ( data, type, row ) {
                    return '<div style="text-align:center;"><b>'+data+'</b></div>';
                }
            },
            {data: 'nombre', name: 'nombre'},
            {data: 'descripcion', name: 'descripcion'},
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
<style>

</style>

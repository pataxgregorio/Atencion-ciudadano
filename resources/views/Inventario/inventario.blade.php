@extends('adminlte::layouts.app')

@section('link_css_datatable')
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/buttons.dataTables.min.css') }}" rel="stylesheet">
@endsection
@section('contentheader_title')
<!-- Componente Button Para todas las Ventanas de los Módulos, no Borrar.-->
<div >
      <h2 class="mb-4" style="text-align: center; display: flex; justify-content: space-between; margin-bottom: -50px">
      <img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="150px" style="margin-top: -15px">
        <p style="margin-top: 40px; font-size: 36px">Inventario</p>
        <img src="{{ url('/images/icons/logo.png') }}" alt="logo" height="100px">
      </h2>
    </div>
    <a href="/inventario/create"><button style="color: white; background-color: black; width: 200px;border-radius: 7px;height: 30px; font-size: 16px;">Nuevo Inventario</button></a>


@endsection

@section('main-content')

<div>

</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
                <table class="table table-bordered solicitud_all">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Producto</th>
                                <th>Nombre de Almacen</th>
                                <th>Existencia</th>
                                <th>Cantidad de Entrada</th>
                                <th>Fecha de Entrada</th>
                                <th>Fecha de Salida</th>
                            </tr>
                        </thead>
                    <tbody>
                    </tbody>
                </table>
        </div>
    </div>
</div>
<div style="text-align: left;">

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
        ajax: "{{ route('inventario.list') }}",

        columns: [
            {
                data: 'id', name: 'id',
                "render": function ( data, type, row ) {
                    return '<div style="text-align:center;"><b>'+data+'</b></div>';
                }
            },
            {data: 'nombre', name: 'nombre'},
            {data: 'almacen', name: 'almacen'},
            {data: 'cantidad', name: 'cantidad'},
            {data: 'cantidad_entrada', name: 'cantidad_entrada'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},


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

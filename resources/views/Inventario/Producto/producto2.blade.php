@extends('adminlte::layouts.app2')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('contentheader_title')
    <div>
        <h2 class="mb-4" style="text-align: center; display: flex; justify-content: space-between; margin-bottom: -50px">
            <p style="margin-top: -20px; font-size: 24px">Producto</p>
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
                <form id="productForm" method="POST" action="{{ route('producto.store2') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre"  name="nombre" required>
                        <label for="descripcion">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion"  name="descripcion" required>
                        <label for="precio">Precio:</label>
                        <input type="number" class="form-control" id="precio" name="precio" required>
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        <label for="categoria">Categoría:</label>
                        <select class="form-control" id="categoria" name="categoria" >
                            <option value="" >Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option required value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="product_id" name="product_id">
                    </div>

                    <button type="submit" id ="crear" class="btn btn-primary">Crear</button>
                    <button type="button" id ="actualizar" class="btn btn-secondary" style="display: none;">Actualizar</button>
                    <button type="button" id ="cancelar" class="btn btn-secondary" style="display: none;">Cancelar</button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#productModal">Catálogo</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true" style="max-width: 580px">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Catálogo de Productos</h5>
                    <button type="button" id="closeModalBtn" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered solicitud_all">
                        <thead>
                            <tr>
                                <th>Nro Producto</th>
                                <th>Nombre de Producto</th>
                                <th>descripcion</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 table-borderless" style="overflow: visible;">
        <div class="row table-borderless" style="overflow: visible;">
            <iframe class="embed-responsive-item" style="width: 100%; height: 424px; overflow: visible;" src="http://192.168.0.113:9000/#/consultar2" allowfullscreen frameborder="0"></iframe>
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
        $(document).ready(function () {
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
        })
        // Inicializar la tabla DataTable solo cuando se muestra el modal
        $('#productModal').on('shown.bs.modal', function (e) {
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

        $(document).on('click', '.edit-button', function() {

            var productId = $(this).data('id');

            $.ajax({
                url: '/producto/' + productId,
                type: 'GET',
                success: function(response) {
                    $('#nombre').val(response.nombre);
                    $('#descripcion').val(response.descripcion);
                    $('#precio').val(response.precio);
                    $('#cantidad').val(response.cantidad);
                    $('#categoria').val(response.categoria_id);
                    $('#product_id').val(productId);

                    $('#crear').hide();
                    $('#actualizar').show();
                    $('#cancelar').show();

                    // Add _method field for PUT request
                    $('#productForm').append('<input type="hidden" name="_method" value="POST">');
                    $('#productForm').attr('action', "{{ route('producto.update2', ['producto' => '']) }}" + "/"+productId);
                    $('#nombre').focus();

                    // Cierra el modal después de cargar los datos
                },
                error: function(error) {
                    console.error('Error al obtener los datos del producto:', error);
                }
            });
        });

        $('#actualizar').on('click', function() {
            $('#productForm').submit();
        });

        $('#cancelar').on('click', function() {
            $('#productForm')[0].reset();
            $('#crear').show();
            $('#actualizar').hide();
            $('#cancelar').hide();

            $('input[name="_method"]').remove();

            $('#productForm').attr('action', "{{ route('producto.store2') }}");
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
        .section-content{
            overflow: hidden;
        }
    </style>
@endsection

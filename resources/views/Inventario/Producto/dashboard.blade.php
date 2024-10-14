@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<!-- Componente Button Para todas las Ventanas de los Módulos, no Borrar.--> 
<div style="margin-bottom: 20px">
      <h2 class="mb-4" style="text-align: center; display: flex; justify-content: space-between; margin-bottom: -50px">
      <img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="150px" style="margin-top: -15px">
        <p style="margin-top: 40px; font-size: 36px">Tablero de Inventario</p>
        <img src="{{ url('/images/icons/logo.png') }}" alt="logo" height="100px">
      </h2> 
    </div>
<div class="container table-borderless" >
    <div class="col-md-6 col-sm-6 table-borderless" >
        <div class="row table-borderless">
        <iframe class="embed-responsive-item" style="width: 100%; height: 800px" src="http://0.0.0.0:4000/producto2" allowfullscreen seamless frameborder="0"></iframe>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 table-borderless" >
        <div class="row table-borderless">
            <iframe class="embed-responsive-item" style="width: 100%; height: 800px" src="http://127.0.0.1:9000/#/consultar" allowfullscreen frameborder="0"></iframe>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-6 table-borderless" >
        <div class="row">
            <iframe class="embed-responsive-item" style="width: 100%; height: 1000px" src="http://127.0.0.1:9000/#/pie" allowfullscreen frameborder="0"></iframe>  
        </div>
    </div>
    <div class="col-md-6 col-sm-6 table-borderless" >
        <div class="row">
            <iframe class="embed-responsive-item" style="width: 100%; height: 1000px" src="http://127.0.0.1:9000/#/pie2" allowfullscreen frameborder="0"></iframe>  
        </div>
    </div>
</div>

    
@endsection

@section('link_css_datatable')
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/buttons.dataTables.min.css') }}" rel="stylesheet">
@endsection


@section('script_datatable')
<script src="{{ url ('/js_datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_delete/sweetalert.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
 
</script>
<script src="{{ url ('/js_delete/delete_confirm.min.js') }}"></script>
<style>
iframe .main-header {
   
}

</style>
@endsection  

@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('message.home_1') }}
@endsection

@section('contentheader_title')
<div >
      <h2 class="mb-4" style="text-align: center; display: flex; justify-content: space-between; margin-bottom: -50px">
        <img src="{{ url('/images/icons/logo.png') }}" alt="logo" height="100px">
        <p style="margin-top: 40px; font-size: 36px">SIA - Sistema Integral de Atención al Ciudadano</p>
        <img src="{{ url('/images/icons/logoSIA.png') }}" alt="logo" height="150px" style="margin-top: -15px">
      </h2> 
    </div>

@endsection

@section('main-content')

 
<div class="row">        
    <div class="col-lg-4 col-md-6 col-xs-12">            
		<a href="/solicitud"><x-box titulo="Total Solicitudes Registrada" cantidad="{{$total_solicitudes_registradas2}}" name="Solitudes Registradas"  color="bg-red"></x-box></a>
	</div>
	<div class="col-lg-4 col-md-6 col-xs-12">            		
		<a href="/seguimiento"><x-box titulo="Total Solicitudes en Proceso" cantidad="{{$total_solicitudes_procesadas2}}" name="Solitudes en Proceso" color="bg-yellow"></x-box></a>
	</div>
	<div class="col-lg-4 col-md-6 col-xs-12">            		
	  <a href="/solicitudfinalizadas"><x-box titulo="Total Solicitudes Terminadas" cantidad="{{$total_solicitudes_finalizadas2}}" name="Solitudes Terminadas" color="bg-green"></x-box></a>
	</div>
</div>
	<!--  CANVAS de las Metricas Para User, Rol y Notificaciones, para View-->
        <div class="row justify-content-center">
          <div class="col-sm-12 align-self-center">
            <div class="row">
              <div class="col-lg-6">
                <div class="panel panel-default">
                  <div class="panel-heading"><b> Indicadores de la Evolución de los Casos Atendidos</b></div>
                  <div class="panel-body" id="contenedor_01">
                    <canvas style="width: 684px; height: 400px;" id="solicitudTotalTipo"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="panel panel-default">
                  <div class="panel-heading"><b>Medidores por tipo de Gestiones y Solicitudes de Atención al Ciudadano </b></div>
                  <div class="panel-body" id="contenedor_02">
                    <canvas style="width: 684px; height: 400px;" id="solicitudTipo"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr/>
@endsection

@section('script_Chart')
<script src="{{ url('/js_Chart/Chart.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/js_dashboard/graficos_dashboard.min.js') }}" type="text/javascript"></script>
@endsection

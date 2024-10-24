<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="background-color: {{$array_color['menu_color']}};">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                  <!--  <img src="{{-- Gravatar::get($user->email) --}}" class="img-circle" alt="User Image" /> -->
                    @if (Auth::user()->avatar == 'default.jpg' || is_null(Auth::user()->avatar))
                        <img src="{{ url('/storage/avatars/default.jpg') }}" class="img-circle" alt="User Image"/>
                    @else
                        <img src="{{ url('/storage/avatars/'.Auth::user()->avatar) }}" class="img-circle" alt="User Image">
                    @endif
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        @if(Auth::user()->direccion_id === 15)
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/dashboard') }}"><i class='fa fa-link'></i> <span>{{ trans('message.dashboard') }}</span></a></li>            
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/solicitud') }}"><i class='fa fa-link'></i> <span>{{ trans('message.request') }}</span></a></li>

        </ul><!-- /.sidebar-menu -->
        @endif
        @if(Auth::user()->direccion_id === 5 )
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/dashboard') }}"><i class='fa fa-link'></i> <span>{{ trans('message.dashboard') }}</span></a></li>            
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/solicitud/buscarsolicitud') }}"><i class='fa fa-link'></i> <span>{{'Buscar Solicitudes'}}</span></a></li>            
            
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Solicitudes</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                <li><a href="{{ url('/solicitud/create') }}"><i class='fa fa-link'></i> <span>Crear Solicitudes</span></a></li>
                <li><a href="{{ url('/solicitud') }}"><i class='fa fa-link'></i> <span>Ver Solicitudes</span></a></li>
                </ul>
            </li>
            <li><a href="{{ url('/seguimiento') }}"><i class='fa fa-link'></i> <span>Seguimiento</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Reporte</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/finalizadas') }}"><i class='fa fa-link'></i> <span>Finalizadas</span></a></li>
                    <li><a href="{{ url('/finalizadas2') }}"><i class='fa fa-link'></i> <span>Solicitudes</span></a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Inventario</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/dashproducto') }}"><i class='fa fa-link'></i> <span>Tablero</span></a></li>
                    <li><a href="{{ url('/almacen') }}"><i class='fa fa-link'></i> <span>Almacen</span></a></li>
                    <li><a href="{{ url('/producto') }}"><i class='fa fa-link'></i> <span>Producto</span></a></li>
                    <li><a href="{{ url('/servicio') }}"><i class='fa fa-link'></i> <span>Servicios</span></a></li>
                    <li><a href="{{ url('/inventario') }}"><i class='fa fa-link'></i> <span>Inventario</span></a></li>
                </ul>
            </li>
            <li><a href="{{ url('/users/color_view') }}"><i class='fa fa-link'></i> <span>{{ trans('message.menu_color') }}</span></a></li>
        </ul><!-- /.sidebar-menu -->
        @endif
        @if(Auth::user()->rols_id === 1 )
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/dashboard') }}"><i class='fa fa-link'></i> <span>{{ trans('message.dashboard') }}</span></a></li>            
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/users') }}"><i class='fa fa-link'></i> <span>{{ trans('message.users') }}</span></a></li>
            <li><a href="{{ url('/solicitud') }}"><i class='fa fa-link'></i> <span>{{ trans('message.request') }}</span></a></li>
            <li><a href="{{ url('/seguimiento') }}"><i class='fa fa-link'></i> <span>Seguimiento</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Reporte</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/finalizadas') }}"><i class='fa fa-link'></i> <span>Finalizadas</span></a></li>
                    <li><a href="{{ url('/finalizadas2') }}"><i class='fa fa-link'></i> <span>Solicitudes</span></a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Inventario</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/dashproducto') }}"><i class='fa fa-link'></i> <span>Tablero</span></a></li>
                    <li><a href="{{ url('/almacen') }}"><i class='fa fa-link'></i> <span>Almacen</span></a></li>
                    <li><a href="{{ url('/producto') }}"><i class='fa fa-link'></i> <span>Producto</span></a></li>
                    <li><a href="{{ url('/servicio') }}"><i class='fa fa-link'></i> <span>Servicios</span></a></li>
                    <li><a href="{{ url('/inventario') }}"><i class='fa fa-link'></i> <span>Inventario</span></a></li>
                </ul>
            </li>
            @if(Auth::user()->rols_id === 1 )
            <li><a href="{{ url('/notificaciones') }}"><i class='fa fa-link'></i> <span>{{ trans('message.menu_notificaciones') }}</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{ trans('message.menu_seguridad') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/rols') }}">{{ trans('message.menu_rol') }}</a></li>
                    <li><a href="{{ url('/modulos') }}">{{ trans('message.menu_modulo') }}</a></li>
                    <li><a href="{{ url('/permisos') }}">{{ trans('message.menu_permiso') }}</a></li>
                </ul>
            </li>
            <li><a href="{{ url('/users/color_view') }}"><i class='fa fa-link'></i> <span>{{ trans('message.menu_color') }}</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->
        @endif
    </section>
    <!-- /.sidebar -->
</aside>

<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
    protected $fillable = [
        'users_id',
        'trabajador',
        'solicitud_salud_id',
        'direccion_id',        
        'coordinacion_id',
        'tipo_solicitud_id',
        'tipo_subsolicitud_id',
        'enter_descentralizados_id',
        'estado_id',
        'municipio_id',
        'parroquia_id',
        'comuna_id',
        'comunidad_id',
        'jefecomunidad_id',
        'codigo_control',
        'status_id',
        'nombre',
        'cedula',
        'sexo',
        'email',
        'direccion',
        'fecha',
        'telefono',
        'telefono2',
        'organismo',
        'edocivil',
        'asignacion',
        'fechaNacimiento',
        'nivelestudio',
        'profesion',
        'recaudos',
        'beneficiario',
        'quejas',
        'reclamo',
        'sugerecia',
        'asesoria',
        'denuncia',
        'denunciado',
        
    ];

    public function encasodeemergencia()
    {
        $resultados = DB::table('solicitud')
        ->leftJoin('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
        ->leftJoin('users', 'solicitud.users_id', '=', 'users.id')
        ->leftJoin('status', 'solicitud.status_id', '=', 'status.id')
        ->select(
            'tipo_solicitud.id AS SOLICITUD_ID',
            'tipo_solicitud.nombre AS SOLICITUD_NOMBRE',
            DB::raw('SUM(CASE WHEN solicitud.status_id IN (1, 5) THEN 1 ELSE 0 END) AS TOTAL_SOLICITUD'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 1 THEN 1 END) AS TOTAL_REGISTRADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 2 THEN 1 END) AS TOTAL_PROCESADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 5 THEN 1 END) AS TOTAL_FINALIZADAS')
        )
        ->groupBy('tipo_solicitud.id', 'tipo_solicitud.nombre')
        ->orderByDesc('TOTAL_SOLICITUD')
        ->get();

    return $resultados;
    }
    public function verificarJSON($id){
        return DB::table('seguimiento')->where('solicitud_id', $id)->get();
    }
    public function SolicitudRegistradas($status){
        $rols_id = auth()->user()->rols_id;
        $user_id = auth()->user()->id;
        return DB::table('solicitud')
        ->Where('solicitud.users_id', $user_id)
        ->Where('status_id',$status)
        ->get();
    }
    public function getSolicitudList_DataTableGeneral($params){
        try {
            //se lista las solicitudes si el parametro es solicitud_salud_id
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
            ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
            ->leftJoin('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
            ->select(
                DB::raw('COALESCE(solicitud.solicitud_salud_id, solicitud.solicitud_atc_id, solicitud.solicitud_dpa_id) as id'), 
                'solicitud.nombre AS solicitante', 
                'comuna.codigo AS comuna', 
                'solicitud.fecha AS fecha', 
                'comunidad.nombre AS comunidad', 
                DB::raw('COALESCE(tipo_subsolicitud.nombre, tipo_solicitud.nombre) AS nombretipo'), // Cambio aquí
                'users.name AS analista', 
                'solicitud.beneficiario as beneficiario', 
                'solicitud.quejas AS quejas', 
                'solicitud.reclamo AS reclamo', 
                'solicitud.denuncia as denuncia', 
                'solicitud.denunciado as denunciado', 
                'direccion.nombre AS direccionnombre', 
                'status.nombre AS nombrestatus'
            )
            ->where(function ($query) use ($params) {
                $query->where('solicitud.solicitud_salud_id', $params)
                    ->orWhere('solicitud.solicitud_atc_id', $params)
                    ->orWhere('solicitud.solicitud_dpa_id', $params);
            })
            ->orderBy('solicitud.fecha', 'desc') 
            ->get();
            // se chequea que la solicitu venga vacia por si el parametro es solicitud_salud_id
            if (count($solicitud) == 0) {
                //se lista las solicitudes si el parametro es cedula del solicitante
                $solicitud = DB::table('solicitud')
                ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                ->join('status', 'solicitud.status_id', '=', 'status.id')
                ->join('users', 'solicitud.users_id', '=', 'users.id')
                ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
                ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                ->select('solicitud.solicitud_salud_id as id','solicitud.nombre AS solicitante','comuna.codigo AS comuna','solicitud.fecha AS fecha','comunidad.nombre AS comunidad','tipo_subsolicitud.nombre AS nombretipo','users.name AS analista','solicitud.beneficiario as beneficiario','solicitud.quejas AS quejas','solicitud.reclamo AS reclamo','solicitud.denuncia as denuncia','solicitud.denunciado as denunciado','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')                
                ->Where('solicitud.cedula', $params)
                ->orderBy('solicitud.solicitud_salud_id', 'desc')
                ->get();
                    // se chequea que la solicitu venga vacia por si el parametro es cedula del solicitante
                if (count($solicitud) == 0) {                    
                    $cedulaBeneficiario = null;
                    //se lista las todas las solicitudes 
                    $solicitud2 = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=', 'status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
                    ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->select('solicitud.solicitud_salud_id as id','solicitud.nombre AS solicitante','comuna.codigo AS comuna','solicitud.fecha AS fecha','comunidad.nombre AS comunidad','tipo_subsolicitud.nombre AS nombretipo','users.name AS analista','solicitud.beneficiario as beneficiario','solicitud.quejas AS quejas','solicitud.reclamo AS reclamo','solicitud.denuncia as denuncia','solicitud.denunciado as denunciado','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
                    ->get();
                    $solicitudbeneficiario =[];
                    // se iteran las solicitudes para obterner la cedula del beneficiario
                    foreach ($solicitud2 as $item) {
                        $beneficiario = json_decode($item->beneficiario, true);
                        $cedulaBeneficiario = $beneficiario[0]['cedula'] ?? null;
                        
                        if(isset($cedulaBeneficiario) && $params == $cedulaBeneficiario){
                            $idsolicitud = $item->id;
                            $solicitud3 = DB::table('solicitud')
                            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                            ->join('status', 'solicitud.status_id', '=', 'status.id')
                            ->join('users', 'solicitud.users_id', '=', 'users.id')
                            ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
                            ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                            ->select('solicitud.solicitud_salud_id as id','solicitud.nombre AS solicitante','comuna.codigo AS comuna','solicitud.fecha AS fecha','comunidad.nombre AS comunidad','tipo_subsolicitud.nombre AS nombretipo','users.name AS analista','solicitud.beneficiario as beneficiario','solicitud.quejas AS quejas','solicitud.reclamo AS reclamo','solicitud.denuncia as denuncia','solicitud.denunciado as denunciado','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')        
                            ->where('solicitud.solicitud_salud_id', $idsolicitud)
                            ->get();
                            //agregar cedula2 =$cedulaBeneficiario en solicitud3
                            $solicitud3[0]->cedula2 = $cedulaBeneficiario;
                            // se agrega al arreglo solicitudbeneficiario el ojeto de la solicitud
                            array_push($solicitudbeneficiario, $solicitud3[0]);
                        }
                        
                    }
                // return $solicitudbeneficiario;
                return $solicitudbeneficiario;

                }else{
                    //caso donde hay una cedula del solicitante hace match y debemos verificar si la cedula tiene concidencia con la cedula del beneficiario
                    $cedulaBeneficiario = null;
                    //se lista las todas las solicitudes 
                    $solicitud2 = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=', 'status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
                    ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->select('solicitud.solicitud_salud_id as id','solicitud.nombre AS solicitante','comuna.codigo AS comuna','solicitud.fecha AS fecha','comunidad.nombre AS comunidad','tipo_subsolicitud.nombre AS nombretipo','users.name AS analista','solicitud.beneficiario as beneficiario','solicitud.quejas AS quejas','solicitud.reclamo AS reclamo','solicitud.denuncia as denuncia','solicitud.denunciado as denunciado','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
                    ->get();
                    $solicitudbeneficiario =[];
                    // se iteran las solicitudes para obterner la cedula del beneficiario
                    foreach ($solicitud2 as $item) {
                        $beneficiario = json_decode($item->beneficiario, true);
                        $cedulaBeneficiario = $beneficiario[0]['cedula'] ?? null;
                        
                        if(isset($cedulaBeneficiario) && $params == $cedulaBeneficiario){
                            $idsolicitud = $item->id;
                            $solicitud3 = DB::table('solicitud')
                            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                            ->join('status', 'solicitud.status_id', '=', 'status.id')
                            ->join('users', 'solicitud.users_id', '=', 'users.id')
                            ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
                            ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                            ->select('solicitud.solicitud_salud_id as id','solicitud.nombre AS solicitante','comuna.codigo AS comuna','solicitud.fecha AS fecha','comunidad.nombre AS comunidad','tipo_subsolicitud.nombre AS nombretipo','users.name AS analista','solicitud.beneficiario as beneficiario','solicitud.quejas AS quejas','solicitud.reclamo AS reclamo','solicitud.denuncia as denuncia','solicitud.denunciado as denunciado','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
                            ->orWhere('solicitud.solicitud_salud_id', $idsolicitud)
                            ->orWhere('solicitud.solicitud_atc_id', $idsolicitud)
                            ->orWhere('solicitud.solicitud_dpa_id', $idsolicitud)
                            ->get();
                            //agregar cedula2 =$cedulaBeneficiario en solicitud3
                            $solicitud3[0]->cedula2 = $cedulaBeneficiario;
                            //se agrega al arreglo solicitudbeneficiario el ojeto de la solicitud
                            
                          //  $solicitudData = $solicitud3[0]->toArray(); // Convertir a array para manipular
                           // $solicitudData['cedula2'] = $cedulaBeneficiario;
                            $solicitud[] = (object) $solicitud3[0];
                        }
                        
                    }
                    $solicitud_no_repetida = [];
                    foreach ($solicitud as $item) {
                        $solicitud_no_repetida[$item->id] = $item;
                    }
                    // Convertimos el array asociativo nuevamente en un array indexado numéricamente
                    $solicitud_no_repetida = array_values($solicitud_no_repetida);                    
                    return $solicitud_no_repetida;
                }

            } else {
                // se retorna la solicitud de salud que coincida con el parametro salud_id
                return $solicitud;
            }

           
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
    }
    public function getSolicitudesDiarias($status){
            $rols_id = auth()->user()->rols_id;
            $fechaHoy = Carbon::now('America/Caracas')->toDateString();
            $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->where('tipo_solicitud.id', '=', 6)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '=', $status)
                    ->whereDate('solicitud.fecha', $fechaHoy)
                    ->select(
                        'solicitud.id',
                        'solicitud.solicitud_salud_id as saludID',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_subsolicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.beneficiario'
                    )           
                    ->get();
                return $solicitud;
    }
    public function getSolicitudList_DataTable(){
        try {
            $rols_id = auth()->user()->rols_id;
            $user_id = auth()->user()->id;
        if($rols_id == 1){
            $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.solicitud_salud_id as saludID',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.denunciado'
                    ) // Extraer cedula     
                    ->get(); // Manejar otros roles
                    foreach ($solicitud as $item) {
                        $denunciado = json_decode($item->denunciado, true);                    
                        $item->cedula2 = $denunciado[0]['cedula'] ?? null; // Asignar cédula o null
                        
                        // Opcional: Eliminar el campo denunciado original si no lo necesitas
                        unset($item->denunciado); 
                    }

                    return $solicitud;
        }
        if($rols_id == 10){
            // En caso de que quieran ver las solicitudes por solo las creadas diariamente colocar el campo whereDate y descomentar $fechahoy
            // $fechaHoy = Carbon::now('America/Caracas')->toDateString();
            // ->whereDate('solicitud.fecha', $fechaHoy)
            $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->where('tipo_solicitud.id', '!=', 4)
                    ->where('tipo_solicitud.id', '!=', 5)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '!=', 4)
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.solicitud_salud_id as saludID',
                        'solicitud.fecha as fecha',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_subsolicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.beneficiario'
                    )           
                    ->get();

                
                // Parsear el JSON y agregar cedulabeneficiario
                foreach ($solicitud as $item) {
                    $beneficiario = json_decode($item->beneficiario, true);                    
                    $item->cedula2 = $beneficiario[0]['cedula'] ?? null; // Asignar cédula o null
                    $item->beneficiarionombre = $beneficiario[0]['nombre'] ?? null; // Asignar cédula o null
                    $item->solicita = $beneficiario[0]['solicita'] ?? null; // Asignar cédula o null
                    
                    // Opcional: Eliminar el campo beneficiario original si no lo necesitas
                    unset($item->beneficiario); 
                }
    
                return $solicitud;
        }else{
            return $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('status_id',1)->get();
        }    
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }   
    }

    public function getSolicitudList_DataTablefin(){
        try {
            $rols_id = auth()->user()->rols_id;
            $user_id = auth()->user()->id;
        if($rols_id == 1){
            $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('status_id', '=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.solicitud_salud_id as saludID',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.denunciado'
                    ) // Extraer cedula     
                    ->get(); // Manejar otros roles
                    foreach ($solicitud as $item) {
                        $denunciado = json_decode($item->denunciado, true);                    
                        $item->cedula2 = $denunciado[0]['cedula'] ?? null; // Asignar cédula o null
                        
                        // Opcional: Eliminar el campo denunciado original si no lo necesitas
                        unset($item->denunciado); 
                    }

                    return $solicitud;
        }
        if($rols_id == 10){
            // En caso de que quieran ver las solicitudes por solo las creadas diariamente colocar el campo whereDate y descomentar $fechahoy
            // $fechaHoy = Carbon::now('America/Caracas')->toDateString();
            // ->whereDate('solicitud.fecha', $fechaHoy)
            $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->where('tipo_solicitud.id', '=', 6)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.solicitud_salud_id as saludID',
                        'solicitud.fecha as fecha',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_subsolicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.beneficiario'
                    )           
                    ->get();

                
                // Parsear el JSON y agregar cedulabeneficiario
                foreach ($solicitud as $item) {
                    $beneficiario = json_decode($item->beneficiario, true);                    
                    $item->cedula2 = $beneficiario[0]['cedula'] ?? null; // Asignar cédula o null
                    $item->beneficiarionombre = $beneficiario[0]['nombre'] ?? null; // Asignar cédula o null
                    $item->solicita = $beneficiario[0]['solicita'] ?? null; // Asignar cédula o null
                    
                    // Opcional: Eliminar el campo beneficiario original si no lo necesitas
                    unset($item->beneficiario); 
                }
    
                return $solicitud;
        }else{
            return $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('status_id',1)->get();
        }    
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }   
    }

    public function getSolicitudList_DataTable2() {
        try {            
            $rols_id = auth()->user()->rols_id;            
            if($rols_id === 1) {
                $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.solicitud_salud_id as saludID',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.denunciado'
                    ) // Extraer cedula     
                    ->get(); // Manejar otros roles
                    foreach ($solicitud as $item) {
                        $denunciado = json_decode($item->denunciado, true);                    
                        $item->cedula2 = $denunciado[0]['cedula'] ?? null; // Asignar cédula o null
                        
                        // Opcional: Eliminar el campo denunciado original si no lo necesitas
                        unset($item->denunciado); 
                    }

                    return $solicitud;
            }
            elseif($rols_id === 10) {         
                $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->where('tipo_solicitud.id', '!=', 4)
                    ->where('tipo_solicitud.id', '!=', 5)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.solicitud_salud_id as saludID',
                        'solicitud.fecha as fecha',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_subsolicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.beneficiario'
                    )                
                    ->get();
                
                foreach ($solicitud as $item) {
                    $beneficiario = json_decode($item->beneficiario, true);                    
                    $item->cedula2 = $beneficiario[0]['cedula'] ?? null;
                    $item->beneficiarionombre = $beneficiario[0]['nombre'] ?? null;
                    $item->solicita = $beneficiario[0]['solicita'] ?? null;
                    
                    // Opcional: Eliminar el campo beneficiario original si no lo necesitas
                    unset($item->beneficiario); 
                }
    
                return $solicitud;
            } else {
                    $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('tipo_solicitud.id', '!=', 6)
                    ->where('tipo_solicitud.id', '!=', 4)
                    ->where('tipo_solicitud.id', '!=', 5)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.denunciado'
                    ) // Extraer cedula     
                    ->get(); // Manejar otros roles
                    foreach ($solicitud as $item) {
                        $denunciado = json_decode($item->denunciado, true);                    
                        $item->cedula2 = $denunciado[0]['cedula'] ?? null; // Asignar cédula o null
                        
                        // Opcional: Eliminar el campo denunciado original si no lo necesitas
                        unset($item->denunciado); 
                    }

                    return $solicitud;
            }
        } catch (Throwable $e) {
            Log::error("Error en getSolicitudList_DataTable2: " . $e->getMessage()); 
            return [];
        }
    }
    
    public function getSolicitudList_DataTable3($params){
        try {
            //se lista las solicitudes si el parametro es solicitud_salud_id
            $solicitud = DB::table('solicitud')
                ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                ->join('status', 'solicitud.status_id', '=', 'status.id')
                ->join('users', 'solicitud.users_id', '=', 'users.id')
                ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
                ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                ->leftJoin('comuna', 'solicitud.comuna_id', '=', 'comuna.id') 
                ->leftJoin('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                ->select(
                    'solicitud.solicitud_salud_id as id',
                    'solicitud.nombre AS solicitante',
                    DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comuna.codigo END AS comuna"),
                    'municipio.nombre AS municipio',
                    'solicitud.fecha AS fecha',
                    DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comunidad.nombre END AS comunidad"),
                    'tipo_subsolicitud.nombre AS nombretipo',
                    'users.name AS analista',
                    'solicitud.beneficiario as beneficiario',
                    'solicitud.quejas AS quejas',
                    'solicitud.reclamo AS reclamo',
                    'solicitud.denuncia as denuncia',
                    'solicitud.denunciado as denunciado',
                    'direccion.nombre AS direccionnombre',
                    'status.nombre AS nombrestatus'
                )
                ->where('solicitud.solicitud_salud_id', $params)
                ->orderBy('solicitud.solicitud_salud_id', 'desc')
                ->get();
            // se chequea que la solicitu venga vacia por si el parametro es solicitud_salud_id
            if (count($solicitud) == 0) {
                //se lista las solicitudes si el parametro es cedula del solicitante
                $solicitud = DB::table('solicitud')
                ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                ->join('status', 'solicitud.status_id', '=', 'status.id')
                ->join('users', 'solicitud.users_id', '=', 'users.id')
                ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
                ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                ->leftJoin('comuna', 'solicitud.comuna_id', '=', 'comuna.id') 
                ->leftJoin('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                ->select(
                    'solicitud.solicitud_salud_id as id',
                    'solicitud.nombre AS solicitante',
                    DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comuna.codigo END AS comuna"),
                    'municipio.nombre AS municipio',
                    'solicitud.fecha AS fecha',
                    DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comunidad.nombre END AS comunidad"),
                    'tipo_subsolicitud.nombre AS nombretipo',
                    'users.name AS analista',
                    'solicitud.beneficiario as beneficiario',
                    'solicitud.quejas AS quejas',
                    'solicitud.reclamo AS reclamo',
                    'solicitud.denuncia as denuncia',
                    'solicitud.denunciado as denunciado',
                    'direccion.nombre AS direccionnombre',
                    'status.nombre AS nombrestatus'
                )->Where('solicitud.cedula', $params)
                ->orderBy('solicitud.solicitud_salud_id', 'desc')
                ->get();
                    // se chequea que la solicitu venga vacia por si el parametro es cedula del solicitante
                if (count($solicitud) == 0) {                    
                    $cedulaBeneficiario = null;
                    //se lista las todas las solicitudes 
                    $solicitud2 = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=', 'status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
                    ->leftJoin('comuna', 'solicitud.comuna_id', '=', 'comuna.id') 
                    ->leftJoin('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                    ->select(
                        'solicitud.solicitud_salud_id as id',
                        'solicitud.nombre AS solicitante',
                        DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comuna.codigo END AS comuna"),
                        'municipio.nombre AS municipio',
                        'solicitud.fecha AS fecha',
                        DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comunidad.nombre END AS comunidad"),
                        'tipo_subsolicitud.nombre AS nombretipo',
                        'users.name AS analista',
                        'solicitud.beneficiario as beneficiario',
                        'solicitud.quejas AS quejas',
                        'solicitud.reclamo AS reclamo',
                        'solicitud.denuncia as denuncia',
                        'solicitud.denunciado as denunciado',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus'
                    )->get();
                    $solicitudbeneficiario =[];
                    // se iteran las solicitudes para obterner la cedula del beneficiario
                    foreach ($solicitud2 as $item) {
                        $beneficiario = json_decode($item->beneficiario, true);
                        $cedulaBeneficiario = $beneficiario[0]['cedula'] ?? null;
                        
                        if(isset($cedulaBeneficiario) && $params == $cedulaBeneficiario){
                            $idsolicitud = $item->id;
                            $solicitud3 = DB::table('solicitud')
                            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                            ->join('status', 'solicitud.status_id', '=', 'status.id')
                            ->join('users', 'solicitud.users_id', '=', 'users.id')
                            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                            ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
                            ->leftJoin('comuna', 'solicitud.comuna_id', '=', 'comuna.id') 
                            ->leftJoin('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                            ->select(
                                'solicitud.solicitud_salud_id as id',
                                'solicitud.nombre AS solicitante',
                                DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comuna.codigo END AS comuna"),
                                'municipio.nombre AS municipio',
                                'solicitud.fecha AS fecha',
                                DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comunidad.nombre END AS comunidad"),
                                'tipo_subsolicitud.nombre AS nombretipo',
                                'users.name AS analista',
                                'solicitud.beneficiario as beneficiario',
                                'solicitud.quejas AS quejas',
                                'solicitud.reclamo AS reclamo',
                                'solicitud.denuncia as denuncia',
                                'solicitud.denunciado as denunciado',
                                'direccion.nombre AS direccionnombre',
                                'status.nombre AS nombrestatus'
                            )->where('solicitud.solicitud_salud_id', $idsolicitud)
                            ->get();
                            //agregar cedula2 =$cedulaBeneficiario en solicitud3
                            $solicitud3[0]->cedula2 = $cedulaBeneficiario;
                            // se agrega al arreglo solicitudbeneficiario el ojeto de la solicitud
                            array_push($solicitudbeneficiario, $solicitud3[0]);
                        }
                        
                    }
                // return $solicitudbeneficiario;
                return $solicitudbeneficiario;

                }else{
                    //caso donde hay una cedula del solicitante hace match y debemos verificar si la cedula tiene concidencia con la cedula del beneficiario
                    $cedulaBeneficiario = null;
                    //se lista las todas las solicitudes 
                    $solicitud2 = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=', 'status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                    ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
                    ->leftJoin('comuna', 'solicitud.comuna_id', '=', 'comuna.id') 
                    ->leftJoin('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                    ->select(
                        'solicitud.solicitud_salud_id as id',
                        'solicitud.nombre AS solicitante',
                        DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comuna.codigo END AS comuna"),
                        'municipio.nombre AS municipio',
                        'solicitud.fecha AS fecha',
                        DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comunidad.nombre END AS comunidad"),
                        'tipo_subsolicitud.nombre AS nombretipo',
                        'users.name AS analista',
                        'solicitud.beneficiario as beneficiario',
                        'solicitud.quejas AS quejas',
                        'solicitud.reclamo AS reclamo',
                        'solicitud.denuncia as denuncia',
                        'solicitud.denunciado as denunciado',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus'
                    )->select('solicitud.solicitud_salud_id as id','solicitud.nombre AS solicitante','comuna.codigo AS comuna','solicitud.fecha AS fecha','comunidad.nombre AS comunidad','tipo_subsolicitud.nombre AS nombretipo','users.name AS analista','solicitud.beneficiario as beneficiario','solicitud.quejas AS quejas','solicitud.reclamo AS reclamo','solicitud.denuncia as denuncia','solicitud.denunciado as denunciado','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
                    ->get();
                    $solicitudbeneficiario =[];
                    // se iteran las solicitudes para obterner la cedula del beneficiario
                    foreach ($solicitud2 as $item) {
                        $beneficiario = json_decode($item->beneficiario, true);
                        $cedulaBeneficiario = $beneficiario[0]['cedula'] ?? null;
                        
                        if(isset($cedulaBeneficiario) && $params == $cedulaBeneficiario){
                            $idsolicitud = $item->id;
                            $solicitud3 = DB::table('solicitud')
                            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                            ->join('status', 'solicitud.status_id', '=', 'status.id')
                            ->join('users', 'solicitud.users_id', '=', 'users.id')
                            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                            ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
                            ->leftJoin('comuna', 'solicitud.comuna_id', '=', 'comuna.id') 
                            ->leftJoin('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                            ->select(
                                'solicitud.solicitud_salud_id as id',
                                'solicitud.nombre AS solicitante',
                                DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comuna.codigo END AS comuna"),
                                'municipio.nombre AS municipio',
                                'solicitud.fecha AS fecha',
                                DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comunidad.nombre END AS comunidad"),
                                'tipo_subsolicitud.nombre AS nombretipo',
                                'users.name AS analista',
                                'solicitud.beneficiario as beneficiario',
                                'solicitud.quejas AS quejas',
                                'solicitud.reclamo AS reclamo',
                                'solicitud.denuncia as denuncia',
                                'solicitud.denunciado as denunciado',
                                'direccion.nombre AS direccionnombre',
                                'status.nombre AS nombrestatus'
                            )->where('solicitud.solicitud_salud_id', $idsolicitud)
                            ->get();
                            //agregar cedula2 =$cedulaBeneficiario en solicitud3
                            $solicitud3[0]->cedula2 = $cedulaBeneficiario;
                            //se agrega al arreglo solicitudbeneficiario el ojeto de la solicitud
                            
                          //  $solicitudData = $solicitud3[0]->toArray(); // Convertir a array para manipular
                           // $solicitudData['cedula2'] = $cedulaBeneficiario;
                            $solicitud[] = (object) $solicitud3[0];
                        }
                        
                    }
                    $solicitud_no_repetida = [];
                    foreach ($solicitud as $item) {
                        $solicitud_no_repetida[$item->id] = $item;
                    }
                    // Convertimos el array asociativo nuevamente en un array indexado numéricamente
                    $solicitud_no_repetida = array_values($solicitud_no_repetida);
                    return $solicitud_no_repetida;
                }

            } else {
                // se retorna la solicitud de salud que coincida con el parametro salud_id
                return $solicitud;
            }

           
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
    }
    public function reportetotalcomunas (){
       $solicitud = DB::table('solicitud')
       ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
       ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
       ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
       ->select(  
           'comuna.codigo  as comuna',        
           DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "MEDICINA" THEN 1 END) AS MEDICINA'),
           DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "INSUMOS" THEN 1 END) AS INSUMOS'),
       )
       ->where(function ($query) {
           $query->where('solicitud.tipo_subsolicitud_id', '=', 1)
                 ->orWhere('solicitud.tipo_subsolicitud_id', '=', 4);
       })
       ->where('solicitud.status_id', '=', 5)
       ->groupBy('comuna.id')
       ->get();
        
       return $solicitud;
    }
    public function medicinacomunas (){
        $solicitud = DB::table('solicitud AS s')
    ->join('comuna AS c', 's.comuna_id', '=', 'c.id')    
    ->join('tipo_subsolicitud AS ts', 's.tipo_solicitud_id', '=', 'ts.id')  
    ->select('c.codigo as comuna', DB::raw('SUM(s.tipo_subsolicitud_id = 1) AS MEDICINA'),
    DB::raw('SUM(s.tipo_subsolicitud_id = 4) AS INSUMOS')) 
    ->where('s.status_id', '=', 5)
    ->groupBy('c.id')  
    ->get();
        return $solicitud;
    }
    public function ultimasEntradas (){
        $solicitud = DB::table('inventario')
        ->join('producto', 'inventario.producto_id', '=', 'producto.id')
        ->select('producto.nombre','inventario.cantidad_entrada','inventario.fecha','inventario.tipoentrada')
        ->orderBy('inventario.id', 'desc')->limit(10)->get();
   
        return $solicitud;
    }
    public function getSolicitudList_DataTable4($params){
        try {
            return $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
            ->select('solicitud.solicitud_salud_id as id','solicitud.denunciado as denunciado')
            ->orWhere('solicitud.solicitud_salud_id', $params)
            ->orWhere('solicitud.cedula', $params)->get();
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
    }
    public function getSolicitudListWAN_Totales($fechaDesde, $fechaHasta, $status_id){
        try {
            $query = DB::table('solicitud')
                ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                ->join('status', 'solicitud.status_id', '=', 'status.id')
                ->join('users', 'solicitud.users_id', '=', 'users.id')
                ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
                ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
                ->leftJoin('comuna', 'solicitud.comuna_id', '=', 'comuna.id') 
                ->leftJoin('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
                ->select(
                    'solicitud.solicitud_salud_id as id',
                    'solicitud.nombre AS solicitante',
                    DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comuna.codigo END AS comuna"),
                    'municipio.nombre AS municipio',
                    'solicitud.fecha AS fecha',
                    DB::raw("CASE WHEN solicitud.municipio_id = 2 THEN NULL ELSE comunidad.nombre END AS comunidad"),
                    'tipo_subsolicitud.nombre AS nombretipo',
                    'users.name AS analista',
                    'solicitud.beneficiario as beneficiario',
                    'solicitud.quejas AS quejas',
                    'solicitud.reclamo AS reclamo',
                    'solicitud.denuncia as denuncia',
                    'solicitud.denunciado as denunciado',
                    'direccion.nombre AS direccionnombre',
                    'status.nombre AS nombrestatus'
                )
                ->orderBy('solicitud.solicitud_salud_id', 'asc');
            
            if($fechaDesde != NULL && $fechaHasta != NULL){
                $query->whereBetween('solicitud.fecha', [$fechaDesde, $fechaHasta]);
                $query->where('solicitud.status_id', $status_id);
            }elseif(isset($status_id)){
                $query->where('solicitud.status_id', $status_id);
            }
    
            $solicitud = $query->get();
    
            return $solicitud;
        } catch(Throwable $e){
            return []; // Simplificamos el manejo de errores
        }
    }
    public function reportetotalcasosatendidosSALUD()
    {
        $resultados = DB::table('solicitud')
            ->leftJoin('status', 'solicitud.status_id', '=', 'status.id')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id') // Cambiamos a INNER JOIN
            ->select(
                DB::raw('COUNT(*) AS TOTAL_SOLICITUD'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "MEDICINA" THEN 1 END) AS MEDICINA'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "LABORATORIO" THEN 1 END) AS LABORATORIO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "ESTUDIO" THEN 1 END) AS ESTUDIO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "INSUMOS" THEN 1 END) AS INSUMOS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "CONSULTAS" THEN 1 END) AS CONSULTAS'), // Agregamos CONSULTAS
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "DONACIONES Y AYUDA ECONOMICA" THEN 1 END) AS DONACIONES_Y_AYUDA_ECONOMICA'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "AYUDAS TECNICAS" THEN 1 END) AS AYUDAS_TECNICAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "CIRUGIAS" THEN 1 END) AS CIRUGIAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "OFTAMOLOGIA" THEN 1 END) AS OFTAMOLOGIA'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "VISITA SOCIAL" THEN 1 END) AS VISITA_SOCIAL'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "MATERIALES" THEN 1 END) AS MATERIALES'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "JORNADAS" THEN 1 END) AS JORNADAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "ALTO COSTO" THEN 1 END) AS ALTO_COSTO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "HURNAS" THEN 1 END) AS HURNAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "FOSAS" THEN 1 END) AS FOSAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "APOYO LOGISTICO" THEN 1 END) AS APOYO_LOGISTICO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "DOTACION" THEN 1 END) AS DOTACION'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "OTROS" THEN 1 END) AS OTROS'),
            )
            ->where('solicitud.status_id', 5)
            ->first();

        return $resultados;
    }

    public function reportetotalcasosatendidosSALUDConFecha($fechaDesde, $fechaHasta)
    {
        $resultados = DB::table('solicitud')
            ->leftJoin('status', 'solicitud.status_id', '=', 'status.id')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id') // Cambiamos a INNER JOIN
            ->select(
                DB::raw('COUNT(*) AS TOTAL_SOLICITUD'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "MEDICINA" THEN 1 END) AS MEDICINA'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "LABORATORIO" THEN 1 END) AS LABORATORIO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "ESTUDIO" THEN 1 END) AS ESTUDIO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "INSUMOS" THEN 1 END) AS INSUMOS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "CONSULTAS" THEN 1 END) AS CONSULTAS'), // Agregamos CONSULTAS
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "DONACIONES Y AYUDA ECONOMICA" THEN 1 END) AS DONACIONES_Y_AYUDA_ECONOMICA'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "AYUDAS TECNICAS" THEN 1 END) AS AYUDAS_TECNICAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "CIRUGIAS" THEN 1 END) AS CIRUGIAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "OFTAMOLOGIA" THEN 1 END) AS OFTAMOLOGIA'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "VISITA SOCIAL" THEN 1 END) AS VISITA_SOCIAL'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "MATERIALES" THEN 1 END) AS MATERIALES'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "JORNADAS" THEN 1 END) AS JORNADAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "ALTO COSTO" THEN 1 END) AS ALTO_COSTO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "HURNAS" THEN 1 END) AS HURNAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "FOSAS" THEN 1 END) AS FOSAS'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "APOYO LOGISTICO" THEN 1 END) AS APOYO_LOGISTICO'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "DOTACION" THEN 1 END) AS DOTACION'),
                DB::raw('COUNT(CASE WHEN tipo_subsolicitud.nombre = "OTROS" THEN 1 END) AS OTROS'),
            )
            ->whereBetween ('solicitud.fecha', [$fechaDesde, $fechaHasta])
            ->where('solicitud.status_id', 5)
            ->first();

        return $resultados;
    }
    
    public function count_solictud(){
        $rols_id = auth()->user()->rols_id;
        return DB::table('solicitud')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('tipo_subsolicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id','!=', 2)
            ->where('users.rols_id', $rols_id)
            ->groupBy('tipo_subsolicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }
    
    public function count_solictud2()
    {
        return DB::table('solicitud')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('status.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.status_id) AS TOTAL_SOLICITUD'))
            ->groupBy('status.id')
            ->orderBy('status.id')->get();
    }
    public function count_solictud2PorFecha($fechaDesde, $fechaHasta)
    {
            
        return DB::table('solicitud')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('status.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.status_id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id','!=', 2)
            ->whereBetween('solicitud.fecha', [$fechaDesde, $fechaHasta])
            ->groupBy('status.id')

            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }
    public function count_solictud3()
    {
      
        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 2)
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }

    public function count_solictud4()
    {
        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 5)
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }
    public function count_solictud4PorFecha($fechaDesde, $fechaHasta)
    {
        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 5)
            ->where('solicitud.status_id', '!=',2)
            ->whereBetween('solicitud.fecha', [$fechaDesde, $fechaHasta])
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }
    public function count_solictud5()
    {
        $resultados = DB::table('solicitud')
        ->leftJoin('status', 'solicitud.status_id', '=', 'status.id')
        ->select(
            DB::raw('SUM(CASE WHEN solicitud.status_id IN (1, 5) THEN 1 ELSE 0 END) AS TOTAL_SOLICITUD'),
	    DB::raw('COUNT(CASE WHEN solicitud.status_id = 1 THEN 1 END) AS TOTAL_PROCESADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 2 THEN 1 END) AS TOTAL_PROCESADAS2'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 3 THEN 1 END) AS TOTAL_RECHAZADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 5 THEN 1 END) AS TOTAL_FINALIZADAS')
        )
        ->first();

    return $resultados;
    }
    public function count_solicitud5PorFecha($fechaDesde, $fechaHasta)
    {
        $resultados = DB::table('solicitud')
        ->leftJoin('status', 'solicitud.status_id', '=', 'status.id')
        ->select(
            DB::raw('SUM(CASE WHEN solicitud.status_id IN (1, 5) THEN 1 ELSE 0 END) AS TOTAL_SOLICITUD'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 1 THEN 1 END) AS TOTAL_PROCESADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 2 THEN 1 END) AS TOTAL_PROCESADAS2'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 3 THEN 1 END) AS TOTAL_RECHAZADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 5 THEN 1 END) AS TOTAL_FINALIZADAS')
        )
        ->whereBetween('solicitud.fecha', [$fechaDesde, $fechaHasta])
        ->first();

    return $resultados;
    }

    public function count_total_solictud(){      
        $rols_id = auth()->user()->rols_id;
        if($rols_id === 1){
            $resultado = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id','=','status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(tipo_solicitud.id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 5)
            ->groupBy('tipo_solicitud.id')
            ->orderBy('status.id')->get();
            return $resultado;
        }else{
            $resultado = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id','=','status.id')
            ->select('status.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(status.id) AS TOTAL_SOLICITUD'))
            ->where('users.rols_id', $rols_id)
            ->groupBy('status.id')
            ->orderBy('status.id')->get();
            return $resultado;}
        
    }
    public function getSolicitudporComunas(){      
        $rols_id = auth()->user()->rols_id;
        
            $resultado = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id','=','status.id')
            ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
            ->select('comuna.codigo AS nombre', DB::raw('COUNT(status.id) AS TOTAL_SOLICITUD'))
            ->where('users.rols_id', $rols_id)
            ->groupBy('comuna.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
            return $resultado;
    }
    public function nombreestado($idestado, $idmunicipio, $idparroquia, $idcomuna, $idcomunidad){
        $resultado = DB::table('solicitud')->join('estado', 'solicitud.estado_id', '=', 'estado.id')
        ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
        ->join('parroquia', 'solicitud.parroquia_id', '=', 'parroquia.id')
        ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
        ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
        ->select('estado.nombre as estado2', 'municipio.nombre as municipio', 'parroquia.nombre as parroquia', 'comuna.codigo as comuna', 'comunidad.nombre as comunidad')
        ->where('estado.id', $idestado)
        ->where('municipio.id', $idmunicipio)
        ->where('parroquia.id', $idparroquia)
        ->where('comuna.id', $idcomuna)
        ->where('comunidad.id', $idcomunidad)
        ->get();
        return $resultado;
    }    
/* Obtiene el ultimo numero de correlativo en salud*/
    public function ObtenerNumeroSolicitud(){
        $ultimoResultado = DB::table('solicitud')
        ->select('solicitud.solicitud_salud_id as salud_id')
        ->whereNotNull('solicitud.solicitud_salud_id')
        ->latest('solicitud.solicitud_salud_id')
        ->first();

    return $ultimoResultado ? $ultimoResultado->salud_id : null;
    }
/* Obtiene el numero de correlativo en salud */

    public function BuscarNumeroSolicitud($id){
        $ultimoResultado = DB::table('solicitud')
        ->select('solicitud.solicitud_salud_id as salud_id')
        ->where('solicitud.id', '=', $id)
        ->get();
        $ultimoResultado = $ultimoResultado[0]->salud_id;
    return $ultimoResultado;
    }

    public function solicitudesWAN($fechaDesde, $fechaHasta, $status, $comuna)
{
    $query = DB::table('solicitud'); // Ajusta el nombre de la tabla
    // Condición para manejar fechas nulas
    if ($fechaDesde === null && $fechaHasta === null) {
        // No se aplican filtros de fecha, se devuelven todas las solicitudes
    } else if ($fechaDesde === null || $fechaHasta === null) {
        // Error si solo una fecha es nula
        return 'Error: Debe seleccionar ambas fechas válidas';
    } else {
        // Filtrar por fechas (si ambas son válidas)
        $query->whereBetween('solicitud.fecha', [$fechaDesde, $fechaHasta]);
    }

    // Filtrar por estado (si se proporciona)
    if ($status !== null) {
        $query->where('status_id', $status);
    }

    // Filtrar por comuna (si se proporciona)
    if($comuna == null){
        $solicitudes = $query->get();
    }
    elseif ($comuna !== null) {
        $query->where('solicitud.comuna_id', $comuna);
    }

    $solicitudes = $query->get();

    // Puedes transformar los resultados aquí si es necesario

    return $solicitudes;
}

}

<?php

namespace App\Models\Seguimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;
class Seguimiento extends Model
{
    use HasFactory;
    protected $table = 'seguimiento';
    protected $fillable = [
        'id',
        'solicitud_id',
        'seguimiento',
        
    ];
    public function getSolicitudList_DataTable(){
        try {
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('status_id',1)->get();
            return $solicitud;
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
        
    }

    public function getSolicitudList_DataTable2(){
        try {
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('tipo_solicitud.id', '!=',4)
            ->where ('tipo_solicitud.id', '!=',5)
            ->where ('status_id', '!=',5)->get();
            return $solicitud;
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
        
    }
    public function getSolicitudList_Finalizadas($fechaDesde, $fechaHasta){
        try {
            $rols_id = auth()->user()->rols_id;
            if($fechaDesde == NULL && $fechaHasta == NULL){
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('users' , 'solicitud.users_id', '=', 'users.id')
            ->join('rols', 'users.rols_id', '=', 'rols.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
            ->select('solicitud.beneficiario','solicitud.id','solicitud.solicitud_salud_id as saludID','solicitud.fecha as fecha','users.name as usuario','solicitud.nombre AS solicitante','solicitud.cedula as cedula','tipo_subsolicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('tipo_solicitud.id', '!=',4)
            ->where ('tipo_solicitud.id', '!=',5)
            ->where ('rols_id', '=', $rols_id)
            ->where ('status_id', '=',5)
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
        }else{
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('users' , 'solicitud.users_id', '=', 'users.id')
            ->join('rols', 'users.rols_id', '=', 'rols.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
            ->select('solicitud.beneficiario','solicitud.id','solicitud.solicitud_salud_id as saludID','solicitud.fecha as fecha','users.name as usuario','solicitud.nombre AS solicitante','solicitud.cedula as cedula','tipo_subsolicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('tipo_solicitud.id', '!=',4)
            ->where ('tipo_solicitud.id', '!=',5)
            ->where ('rols_id', '=', $rols_id)
            ->whereBetween ('solicitud.fecha', [$fechaDesde, $fechaHasta])
            ->where ('status_id', '=',5)->get();
            foreach ($solicitud as $item) {
                $beneficiario = json_decode($item->beneficiario, true);                    
                $item->cedula2 = $beneficiario[0]['cedula'] ?? null;
                $item->beneficiarionombre = $beneficiario[0]['nombre'] ?? null;
                $item->solicita = $beneficiario[0]['solicita'] ?? null;
                
                // Opcional: Eliminar el campo beneficiario original si no lo necesitas
                unset($item->beneficiario); 
            }
            return $solicitud;
        }
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
        
    }

    public function getSolicitudList_Finalizadas2($fechaDesde, $fechaHasta){
        try {
            $rols_id = auth()->user()->rols_id;
            if($fechaDesde == NULL && $fechaHasta == NULL){
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('users' , 'solicitud.users_id', '=', 'users.id')
            ->join('rols', 'users.rols_id', '=', 'rols.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
            ->select('solicitud.beneficiario','solicitud.id','solicitud.solicitud_salud_id as saludID','solicitud.fecha as fecha','users.name as usuario','solicitud.nombre AS solicitante','solicitud.cedula as cedula','tipo_subsolicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('rols_id', '=', $rols_id)
            ->orderBy('solicitud.solicitud_salud_id', 'desc')
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
        }else{
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('users' , 'solicitud.users_id', '=', 'users.id')
            ->join('rols', 'users.rols_id', '=', 'rols.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
            ->select('solicitud.beneficiario','solicitud.id','solicitud.solicitud_salud_id as saludID','solicitud.fecha as fecha','users.name as usuario','solicitud.nombre AS solicitante','solicitud.cedula as cedula','tipo_subsolicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('rols_id', '=', $rols_id)
            ->whereBetween ('solicitud.fecha', [$fechaDesde, $fechaHasta])
            ->orderBy('solicitud.solicitud_salud_id', 'desc')
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
        }
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
        
    }
    public function getSolicitudList_DataTable3($params){
        try {
            $solicitud = DB::table('seguimiento')
            ->join('solicitud', 'seguimiento.solicitud_id', '=', 'solicitud.id')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('solicitud.solicitud_salud_id AS NumeroSolicitud','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS tipoSolicitud','users.name AS analista','seguimiento.seguimiento as Seguimiento','direccion.nombre AS direccionnombre','status.nombre AS estatus')
            ->where ('solicitud.solicitud_salud_id', $params)->get();
            return $solicitud;
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
    }
    
    public function count_solictud(){        
        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE',
                DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }
    
    public function count_total_solictud(){        
        return DB::table('solicitud')
            ->select(DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }


}

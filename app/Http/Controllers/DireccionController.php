<?php

namespace App\Http\Controllers;
use App\Models\Direccion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function createFromJson(){
        $direcciones = json_decode(file_get_contents("http://developers.ctdesarrollo.org/triofrio/json-dbs/addresses.json", false));
        $total = 0;
        foreach($direcciones as $f){
            if($f->id > 1883){
                $direccion = new Direccion();
                $direccion->id = $f->id;
                $direccion->persona_id =intval($f->person_id);
                $direccion->codigo_pais = $f->country;
                $direccion->postal_code = $f->postal_code;
                $direccion->detalle = $f->detail;
                $bandera = $direccion->save();
                if(!$bandera){
                    return "No se pudo ingresar las direcciones";
                }
                $total +=1;
            }
                
                

             
        }
        return "Direcciones ingresadas: ".$total;       
    }
}

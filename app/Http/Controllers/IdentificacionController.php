<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Identificacion;

class IdentificacionController extends Controller
{
    public function createFromJson(){
        $identificaciones = json_decode(file_get_contents("http://developers.ctdesarrollo.org/triofrio/json-dbs/identifications.json", false));
        $total = 0;
        foreach($identificaciones as $f){
            if($f->id > 2029){
                $ident = new Identificacion();
                $ident->id = $f->id;
                $ident->persona_id = $f->person_id;
                $ident->tipo = $f->type;
                $ident->valor = $f->value;
                $bandera = $ident->save();
                if(!$bandera){
                    return "No se pudo ingresar los paises";
                }
                $total +=1; 
            }
            
        }
        return "Identificaciones ingresadas: ".$total;       
    }
}

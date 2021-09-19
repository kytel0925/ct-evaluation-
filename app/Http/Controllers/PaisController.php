<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pais;
use App\Http\Controllers\Generic;
class PaisController extends Controller
{
    public function createFromJson(){
        $paises = json_decode(file_get_contents("https://pkgstore.datahub.io/core/country-list/data_json/data/8c458f2d15d9f2119654b29ede6e45b8/data_json.json", false));
        $total = 0;
        foreach($paises as $f){
            $pais = new Pais();
            $pais->codigo = $f->Code;
            $pais->nombre = $f->Name;
            $bandera = $pais->save();
            if(!$bandera){
                return "No se pudo ingresar los paises";
            }
            $total +=1; 
        }
        return "Paises ingresadas: ".$total;       
    }
}

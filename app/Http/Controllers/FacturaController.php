<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Generic;
use App\Models\Factura;

class FacturaController extends Controller
{
    public function createFromJson(){
        $facturas = json_decode(file_get_contents("http://developers.ctdesarrollo.org/triofrio/json-dbs/invoices.json", false));
        $total = 0;
        
        
        foreach($facturas as $f){            
            $factura = new Factura();
            $factura->id = $f->id;
            $factura->identificacion_id = $f->identification_id;
            $factura->fecha = date_create_from_format('Y-m-d',$f->date);
            $factura->total = floatval($f->total);
            $bandera = $factura->save();
            if(!$bandera){
                return "No se pudo ingresar las facturas";
            }
            $total +=1;           
            
        }
        return "Facturas ingresadas: ".$total;  
    }
}

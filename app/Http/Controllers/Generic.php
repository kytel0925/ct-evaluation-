<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class Generic extends Controller
{
    public function index()
    {
        return 'now developer do your thing';
    }

    public function question_1()
    {
        $arreglo = [];
        $caracteres_alfabeticos = 'abcdefghijklmnopqrstuvwxyz';
        for($i=0; $i<100;$i++){
            if(rand(0,1) == 1){
                array_push($arreglo, rand(0,10000));
            }else{ 
                array_push($arreglo, substr(str_shuffle($caracteres_alfabeticos),0,rand(1,26)));
            }            
        }
        return $arreglo;
    }

    public function question_2()
    {
        $arreglo = $this->question_1();
        echo "Arreglo Grande: \n".json_encode($arreglo)."\n";
        $arreglo_strings = [];
        $arreglo_numeros = [];
        foreach($arreglo as $elemento){
            if(gettype($elemento) == "string"){
                array_push($arreglo_strings, $elemento);
            }else{
                array_push($arreglo_numeros, $elemento);
            }
        }

        echo "\n Arreglo de Strings: \n".json_encode($arreglo_strings)."\n";
        echo "\n Arreglo de Numeros: \n".json_encode($arreglo_numeros)."\n";
    }

    public function question_3()
    {
        $arreglo = $this->question_1();
        $arreglo_strings = [];
        $arreglo_numeros = [];
        foreach($arreglo as $elemento){
            if(gettype($elemento) == "string"){
                array_push($arreglo_strings, $elemento);
            }else{
                array_push($arreglo_numeros, $elemento);
            }
        }
        $suma = array_sum($arreglo_numeros);
        echo "Este es el arreglo de numeros: \n".json_encode($arreglo_numeros);
        echo "\n Esta es la suma del arreglo de numeros: $suma";
    }

    public function question_4()
    {
        $arreglo = $this->question_1();
        $arreglo_strings = [];
        $arreglo_numeros = [];
        foreach($arreglo as $elemento){
            if(gettype($elemento) == "string"){
                array_push($arreglo_strings, $elemento);
            }else{
                array_push($arreglo_numeros, $elemento);
            }
        }
        echo "Este es el arreglo de strings: \n".json_encode($arreglo_strings);
        sort($arreglo_strings);
        echo "Este es el arreglo de strings ordenados: ".json_encode($arreglo_strings);
    }

    public function question_5()
    {
        return $this->cargarArchivo("http://developers.ctdesarrollo.org/triofrio/json-dbs/persons.json");
    }

    public function question_6()
    {
        $personas = $this->question_5();
        $mujeres = 0;
        foreach($personas as $p){
            if($p->gender == "f"){
                $mujeres += 1; 
            }
        }
        echo "Numero de mujeres: $mujeres";      
    }

    public function question_7()
    {
        $paises = $this->paisComoKey($this->cargarArchivo("https://pkgstore.datahub.io/core/country-list/data_json/data/8c458f2d15d9f2119654b29ede6e45b8/data_json.json"));
        $resultado = [];
        $personas = $this->question_5();
        //Para llenar el arreglo que se imprimira
        foreach($personas as $person){
            if(array_key_exists($person->country, $resultado)){
                $resultado[$person->country] += 1;
            }else{
                $resultado[$person->country] = 1;
            }
        }

        //Para imprimir el arreglo
        foreach($resultado as $clave => $valor){
            echo $paises[$clave].": $valor personas.\n\n";
        }
    }

    public function question_8(){
        return $this->cargarArchivo("http://developers.ctdesarrollo.org/triofrio/json-dbs/addresses.json");
    }
    public function question_9(){
        $personas_pais = $this->personaComoKey($this->question_5());
        $direcciones = $this->question_8();
        $resultado = [];
        foreach($direcciones as $d){
            if($d->country != $personas_pais[$d->person_id]){
                if(array_key_exists($d->person_id,$resultado)){
                    array_push($resultado[$d->person_id],$d->id);                      
                }else{
                    $resultado[$d->person_id] = [$d->id];
                }
            }
        }
        return $resultado;
    }
    
    public function question_10(){
        $personas = $this->personaComoKey($this->question_5());
        $direcciones_persona = $this->question_9();
        $facturas = $this->invoices();
        $identificaciones = $this->identifications();
        $resultado = [];
        foreach(array_keys($personas) as $p){
            $adresses = [];
            $invoices = [];
            $idents = [];
            if(array_key_exists($p,$direcciones_persona)){
                $adresses = array_merge($adresses,$direcciones_persona[$p]); 
            }
            if(array_key_exists($p,$identificaciones)){
                foreach($identificaciones[$p] as $i){
                    array_push($idents,$i);
                    if(array_key_exists($i,$facturas)){
                        $invoices = array_merge($invoices,$facturas[$i]);
                    }
                }
            }
            $parcial = ['persona'=>$p, 'invoices'=>$invoices,'identifications'=>$idents,'addresses'=>$adresses];
            array_push($resultado,$parcial);
            
        }
        return $resultado;
    }
    public function question_11(){
        echo "Modelos Creados en dir: app/Models";
    }
    public function question_12(){
        echo "Datos Ingresados en base de datos SQLITE";
    }
    public function question_13(){
        $resultado = DB::table('pais')
        ->join('persona','pais.codigo','=','persona.codigo_pais')
        ->join(DB::raw('(SELECT identificacion.persona_id, SUM(factura.total) as total FROM factura, identificacion WHERE factura.identificacion_id = identificacion.id GROUP BY identificacion.persona_id) valores'),function($join){
            $join->on('persona.id', '=', 'valores.persona_id');
        })->selectRaw('pais.nombre, persona.nombre as nombres, persona.apellido, MAX(valores.total) as total')
        ->groupBy('pais.codigo')->get();
        
        echo "Resultado del query \n"; 
        foreach($resultado as $p){
            echo "{Pais: ".$p->nombre." Persona: ".$p->nombres." ".$p->apellido." Total: ".$p->total."}\n\t\t\t";
        }
        
    }
    public function question_14(){
        $resultado = $resultado = DB::table('pais')
        ->join('persona','pais.codigo','=','persona.codigo_pais')
        ->join(DB::raw('(SELECT identificacion.persona_id, factura.total FROM factura, identificacion WHERE factura.identificacion_id = identificacion.id AND strftime("%m",factura.fecha) > 5 GROUP BY identificacion.persona_id) valores'),function($join){
            $join->on('persona.id', '=', 'valores.persona_id');
        })->selectRaw('pais.nombre, persona.nombre as nombres, persona.apellido, SUM(valores.total) as ventas')
        ->groupBy('pais.codigo')->get();

        echo json_encode($resultado);

    }
    public function question_15(){
        echo "No hay tabla producto";
    }
    //Metodo que devuelve un arreglo que tiene como llaves el ide de persona y valor el pais de origen
    private function paisComoKey($arreglo){
        $resultado = [];
        foreach($arreglo as $a){
            $resultado[$a->Code] = $a->Name;
        }
        return $resultado;
    }
    //metodo que carga las facturas a un arreglo
    public function invoices(){
        $invoices = $this->cargarArchivo("http://developers.ctdesarrollo.org/triofrio/json-dbs/invoices.json");
        
        $resultado = [];
        foreach($invoices as $i){
            if(array_key_exists($i->identification_id,$resultado)){
                array_push($resultado[$i->identification_id], $i->id);
            }else{
                $resultado[$i->identification_id] = [$i->id];
            }
        }
        return $resultado; 
    }
    /**
     * @array arreglo de prueba para el test de la ranita
     */
    protected $jumps=[3,1,1,1];
    protected $jumps1=[1,0,1];
    protected $jumps2 = [2,2,1,0,5,2,2,5,1,5,4,0,5,5,1,4,5,5,2,2,3,0,3,0,1,3,3,1,0,3,2,2,4,1,4,4,2,2,5,2,4,1,4,0,5,1,5,5,3,4,3,2,4,0,3,0,3,0,0,5,3,3,3,1,0,2,1,1,5,0,3,1,3,0,4,5,1,2,3,4,1,4,4,3,1,0,3,4,2,5,5,0,5,4,0,2,2,5,3,4]; 

    public function ranita(){
        $jumps=[3,1,1,1];
        $jumps1=[1,0,1];
        $jumps2 = [2,2,1,0,5,2,2,5,1,5,4,0,5,5,1,4,5,5,2,2,3,0,3,0,1,3,3,1,0,3,2,2,4,1,4,4,2,2,5,2,4,1,4,0,5,1,5,5,3,4,3,2,4,0,3,0,3,0,0,5,3,3,3,1,0,2,1,1,5,0,3,1,3,0,4,5,1,2,3,4,1,4,4,3,1,0,3,4,2,5,5,0,5,4,0,2,2,5,3,4]; 
        $arreglos = [$jumps,$jumps1,$jumps2];
        $arreglo_a_escoger = rand(0,2);
        echo "Arreglo: ";
        print_r($arreglos[$arreglo_a_escoger]);
        $this->jumping_frog($arreglos[$arreglo_a_escoger]);
    }
    //FUNCION RECURSIVA PARA EL TEST DE LA RANITA 
    private function jumping_frog($array){
        if(count($array)> 500 && count($array)<1){
            return false;
        }
        if($this->jumping_frog_aux($array, 0, $array[0])){
            echo "true";
        }else{
            echo "false";
        }
    }

    //FUNCION AUXILIAR PARA EL TEST DE LA RANITA
    private function jumping_frog_aux($array, $indice, $saltos){        
        if($indice >= count($array)-1){
            return true;
        }
        if($saltos == 0){
            return false;
        }
        if(($indice+$saltos) >= count($array)-1){
            return true;
        }
        if($this->jumping_frog_aux($array,$indice+$saltos,$array[$saltos + $indice])){
            return true;
        }else{
            return $this->jumping_frog_aux($array,$indice,$saltos-1);
        }
    }
    //Metodo que carga las identificaciones a un arreglo
    private function identifications(){
        $identifications = $this->cargarArchivo("http://developers.ctdesarrollo.org/triofrio/json-dbs/identifications.json");
        $resultado = [];
        foreach($identifications as $i){
            if(array_key_exists($i->person_id,$resultado)){
                array_push($resultado[$i->person_id],$i->id); 
            }else{
                $resultado[$i->person_id] = [$i->id];
            }
        }
        return $resultado;
    }

    //Metodo que dada una identificacion encuentra el id de la persona de dicha identificacion
    private function buscarIdPersona($identificacion){
        $identifications = $this->identifications();
        foreach(array_keys($identifications) as $i){
            if(in_array($identificacion,$identifications[$i])){
                return $i;
            }
        }
        return null;
    }
    //Metodo que devuelve un arreglo que tiene como llaves el id = de persona y valor = array de direcciones 
    private function personaComoKey($arreglo){
        $resultado = [];
        foreach($arreglo as $a){
            $resultado[$a->id] = $a->country;
        }
        return $resultado;
    }
    //Metodo que devuelve el recurso que se obtiene de dicha url pasada como parametro 
    private function cargarArchivo($url){
        return json_decode(file_get_contents($url,false));
    }
}
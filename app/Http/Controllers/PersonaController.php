<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
class PersonaController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Persona::latest()->paginate(5);
    
        return view('persona.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('persona.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'codigo_pais'=>'required',
            'fecha_nacimiento'=> 'required',
            'genero'=>'required'
        ]);    
        Persona::create($request->all());
     
        return redirect()->route('persona.index')
                        ->with('success','Persona created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        return view('persona.show',compact('persona'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        return view('persona.edit',compact('persona'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
        ]);
    
        $persona->update($request->all());
    
        return redirect()->route('persona.index')
                        ->with('success','Persona updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
    
        return redirect()->route('persona.index')
                        ->with('success','Persona deleted successfully');
    } 
    
    
    public function createFromJson(){
        $identificaciones = json_decode(file_get_contents("http://developers.ctdesarrollo.org/triofrio/json-dbs/persons.json", false));
        $total = 0;
        foreach($identificaciones as $f){
            
            $persona = new Persona();
            $persona->id = $f->id;
            $persona->nombre = $f->name;
            $persona->apellido = $f->last_name;
            $persona->fecha_nacimiento = date_create_from_format('Y-m-d',$f->birth_date);
            $persona->genero = $f->gender;
            $persona->codigo_pais = $f->country;
            $bandera = $persona->save();
            if(!$bandera){
                return "No se pudo ingresar los paises";
            }
            $total +=1;
        
             
        }
        return "Personas ingresadas: ".$total;       
    }
}

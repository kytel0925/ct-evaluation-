@extends('persona.layout')
 
@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>CT - EVALUATION</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('persona.create') }}"> Crear Persona</a>
                
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Apellido</th>
            <th width="280px">Acciones</th>
        </tr>
        @foreach ($data as $key => $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->apellido}}</td>
            <td>
                <form action="{{ route('persona.destroy',$value->id) }}" method="POST">   
                    <a class="btn btn-info" href="{{ route('persona.show',$value->id) }}">Mostrar</a>    
                    <a class="btn btn-primary" href="{{ route('persona.edit',$value->id) }}">Editar</a>   
                    @csrf
                    @method('DELETE')      
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>  
       
@endsection
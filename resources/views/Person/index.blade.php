@extends('Person.base')

@section('content')

    <div class="container mt-5">

        <a class="btn btn-success" href="#">Nuevo</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Birtday</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($persons as $person)

                    <tr>
                        <th>{{ $person->id }}</th>
                        <td>{{ $person->name }}</td>
                        <td>{{ $person->lastName }}</td>
                        <td>{{ $person->birth_date }}</td>
                        <td>{{$person->gender}}</td>
                        <td><a class="btn btn-warning" href="#">Editar</a></td>
                        <td><a class="btn btn-danger" href="#">Eliminar</a></td>
                    </tr>

                @endforeach

            </tbody>
        </table>
        {{$persons->links('pagination::bootstrap-4')}}

    </div>

@endsection

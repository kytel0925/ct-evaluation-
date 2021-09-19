<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class PersonController extends Controller
{
    public function index(){

        $persons = Person::paginate(5);
        return view('person.index', compact('persons'));

    }

    public function destroy(Person $person){

        $person->delete();
        return redirect()->route('person.index');

    }

}

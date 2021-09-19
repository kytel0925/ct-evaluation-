<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use App\Models\Country;

class Address extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //relacion 1 a 1 inversa person
    public function address(){
        return $this->belongsTo(Person::class);
    }

    //relacion 1 a n inversa country
    public function country(){
        return $this->belongsTo(Country::class);
    }

}

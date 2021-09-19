<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Address;
use App\Models\Identification;

class Person extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //relacion 1 a 1 address
    public function address(){
        return $this->hasOne(address::class);
    }

    //relacion 1 a n inversa country
    public function country(){
        return $this->belongsTo(Country::class);
    }

    //relacion 1 a n identifications
    public function identifications(){
        return $this->hasMany(Identification::class);
    }

}

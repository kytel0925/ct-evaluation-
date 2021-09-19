<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use App\Models\Address;

class Country extends Model
{

    protected $primaryKey = 'code';
    public $incrementing = false;

    use HasFactory;

    protected $fillable = ['code', 'name'];

    // relacion 1 a n persons
    public function persons(){
        return $this->hasMany(Person::class);
    }

    //relacion 1 a n addresses
    public function addresses(){
        return $this->hasMany(Address::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\Person;
use App\Models\Invoice;

class Identification extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //relacion 1 a n inversa type
    public function type(){
        return $this->belongsTo(Type::class);
    }

    //relacion 1 a n inversa person
    public function person(){
        return $this->belongsTo(Person::class);
    }

    //relacion 1 a n invoices
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

}

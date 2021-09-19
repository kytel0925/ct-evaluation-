<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Identification;

class Invoice extends Model
{

    protected $primaryKey = 'id';
    public $incrementing = false;

    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    //relacion 1 a n inversa identification
    public function identification(){
        return $this->belongsTo(Identification::class);
    }

}

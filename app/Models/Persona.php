<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persona';
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'codigo_pais');
    }

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'apellido', 'fecha_nacimiento', 'genero', 'codigo_pais', 'created_at', 'updated_at'];
}

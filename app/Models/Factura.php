<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'factura';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function identificacion()
    {
        return $this->belongsTo(Identificacion::class, 'identificacion_id');
    }
    /**
     * @var array
     */
    protected $fillable = ['id', 'identificacion_id','fecha','total', 'created_at', 'updated_at'];
}

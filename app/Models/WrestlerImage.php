<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class WrestlerImage extends Model
{
    /**
     * Table name.
     */
    protected $table = 'wrestlerImage';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['wrestler_id', 'mime', 'extension', 'type', 'url'];
    
    /**
     * Column name of id for updating.
     */
    public $idColumnName = 'wrestler_id';
}

<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    /**
     * Table name.
     */
    protected $table = 'fedTitle';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['name', 'type', 'placement'];
}

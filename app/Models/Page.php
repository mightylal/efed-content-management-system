<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * Table name.
     */
    protected $table = 'fedPage';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['name', 'access', 'placement'];
}

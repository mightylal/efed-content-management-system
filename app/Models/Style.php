<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    /**
     * Table name.
     */
    protected $table = 'fedStyle';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['name', 'primary1', 'primary2', 'secondary1', 'secondary2', 'secondary3', 'secondary4'];

    /**
     * Retrieve the style.
     *
     * @return object
     */
    public function get()
    {
        return static::orderBy('id', 'desc')->first();
    }
}

<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * Table name.
     */
    protected $table = 'settings';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['roleplayLimit', 'gradeRights'];

    /**
     * Retrieve the settings.
     *
     * @return object
     */
    public function get()
    {
        return static::orderBy('id', 'desc')->first();
    }
}

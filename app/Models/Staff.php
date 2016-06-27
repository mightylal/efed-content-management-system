<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    /**
     * Table name.
     */
    protected $table = 'fedStaff';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['wrestler_id'];
    
    /**
     * Check to see if the wrestler is staff.
     * 
     * @param integer $wrestler_id
     * @return boolean
     */
    public function is($wrestler_id)
    {
        return static::where('wrestler_id', $wrestler_id)->exists();
    }
}

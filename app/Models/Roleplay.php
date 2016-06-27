<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Roleplay extends Model
{
    /**
     * Table name.
     */
    protected $table = 'fedRp';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['wrestler_id', 'event_id', 'name', 'rp'];

    /**
     * Inverse of one to many relationship with wrestler.
     */
    public function wrestler()
    {
        return $this->belongsTo('Efed\Models\Wrestler');
    }
    
    /**
     * Inverse of one to many relationship with event.
     */
    public function event()
    {
        return $this->belongsTo('Efed\Models\Event');
    }
}

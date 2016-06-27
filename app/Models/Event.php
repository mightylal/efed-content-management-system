<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Table name.
     */
    protected $table = 'fedEvent';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['name', 'scheduled_at', 'deadline_at', 'preview'];

    /**
     * One to many relationship with roleplays.
     */
    public function roleplays()
    {
        return $this->hasMany('Efed\Models\Roleplay', 'event_id', 'id');
    }

    /**
     * One to many relationship with segments.
     */
    public function segments()
    {
        return $this->hasMany('Efed\Models\Segment', 'event_id', 'id');
    }
}

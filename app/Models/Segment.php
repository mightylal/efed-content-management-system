<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    /**
     * Table name.
     */
    protected $table = 'eventSegment';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['event_id', 'type', 'name', 'placement'];
    
    /**
     * One to many relationship with segment wrestler.
     */
    public function wrestlers()
    {
        return $this->hasMany('Efed\Models\SegmentWrestler', 'segment_id', 'id');
    }
}

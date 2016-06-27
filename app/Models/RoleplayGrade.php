<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class RoleplayGrade extends Model
{
    /**
     * Table name.
     */
    protected $table = 'rpGrade';
    
    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['rp_id', 'wrestler_id', 'fed_grade', 'comment'];
    
    /**
     * Inverse of one to many relationship with wrestler.
     */
    public function wrestler()
    {
        return $this->belongsTo('Efed\Models\Wrestler');
    }
}

<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    /**
     * Table name.
     */
    protected $table = 'forumPost';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['topic_id', 'wrestler_id', 'post'];
    
    /**
     * One to one relationship with wrestler.
     */
    public function wrestler()
    {
        return $this->hasOne('Efed\Models\Wrestler', 'id', 'wrestler_id');
    }
}

<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    /**
     * Table name.
     */
    protected $table = 'forum';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['name', 'description', 'access', 'posting', 'placement'];

    /**
     * One to many relationship with forum topics.
     */
    public function topics()
    {
        return $this->hasMany('Efed\Models\ForumTopic', 'category_id', 'id');
    }
}

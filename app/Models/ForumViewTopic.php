<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class ForumViewTopic extends Model
{
    /**
     * Table name.
     */
    protected $table = 'forumViewTopic';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['category_id', 'topic_id', 'wrestler_id'];
}

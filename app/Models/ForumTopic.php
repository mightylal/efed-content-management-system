<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    /**
     * Table name.
     */
    protected $table = 'forumTopic';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['category_id', 'wrestler_id', 'name'];

    /**
     * One to many relationship with forum posts.
     */
    public function posts()
    {
        return $this->hasMany('Efed\Models\ForumPost', 'topic_id', 'id');
    }
    
    /**
     * One to one relationship with wrestler.
     */
    public function wrestler()
    {
        return $this->hasOne('Efed\Models\Wrestler', 'id', 'wrestler_id');
    }
    
    /**
     * Count the amount of topics for the category.
     * 
     * @param integer $category_id
     * @return integer
     */
    public function categoryCount($category_id)
    {
        return static::where('category_id', $category_id)->count();
    }
}

<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wrestler extends Model
{
    use SoftDeletes;
    /**
     * Table name.
     */
    protected $table = 'wrestler';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['name', 'username', 'password', 'slug', 'age', 'gender', 'height', 'weight', 'bio', 'admin'];

    /**
     * Dates.
     */
    protected $dates = ['deleted_at'];

    /**
     * One to many relationship with roleplays.
     */
    public function roleplays()
    {
        return $this->hasMany('Efed\Models\Roleplay');    
    }
    
    /**
     * One to many relationship with roleplay grades.
     */
    public function roleplayGrades()
    {
        return $this->hasMany('Efed\Models\RoleplayGrade');
    }

    /**
     * One to one relationship with wrestler image.
     */
    public function image()
    {
        return $this->hasOne('Efed\Models\WrestlerImage', 'wrestler_id', 'id');
    }
}

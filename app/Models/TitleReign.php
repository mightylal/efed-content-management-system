<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class TitleReign extends Model
{
    /**
     * Table name.
     */
    protected $table = 'fedTitleReign';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['title_id', 'date_won', 'defenses', 'date_lost', 'last_defense', 'wrestler_id_one', 'wrestler_id_two'];
}

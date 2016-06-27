<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class TitleImage extends Model
{
    /**
     * Table name.
     */
    protected $table = 'titleImage';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['title_id', 'mime', 'extension', 'url'];

    /**
     * Column name of id for updating.
     */
    public $idColumnName = 'title_id';
}

<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class MessageBody extends Model
{
    /**
     * Table name.
     */
    protected $table = 'messageBody';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['message_id', 'wrestler_id', 'message'];
}

<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class MessageWrestler extends Model
{
    /**
     * Table name.
     */
    protected $table = 'messageWrestler';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['message_id', 'wrestler_id', 'viewed_at'];

    /**
     * Belongs to relationship with message.
     */
    public function message()
    {
        return $this->belongsTo('Efed\Models\Message', 'message_id', 'id');
    }
}

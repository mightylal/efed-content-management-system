<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Table name.
     */
    protected $table = 'message';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['subject'];

    /**
     * One to many relationship with message body.
     */
    public function messages()
    {
        return $this->hasMany('Efed\Models\MessageBody', 'message_id', 'id');
    }
}

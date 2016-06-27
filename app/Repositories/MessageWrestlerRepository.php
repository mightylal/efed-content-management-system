<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\MessageWrestlerRepository as MessageWrestlerRepositoryInterface;
use Efed\Models\MessageWrestler;

class MessageWrestlerRepository implements MessageWrestlerRepositoryInterface
{

    /**
     * @var MessageWrestler
     */
    private $model;

    /**
     * Start new MessageWrestlerRepository.
     *
     * @param MessageWrestler $model
     */
    public function __construct(MessageWrestler $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all the messages for the wrestler.
     *
     * @param integer $wrestler_id
     * @param array $columns (optional)
     * @return array
     */
    public function all($wrestler_id, $columns = ['*'])
    {
        $messages = $this->model->select($columns)->where('wrestler_id', $wrestler_id)->whereNull('deleted_at')->groupBy('message_id')->get();
        if (count($messages) > 0) {
            $messages->load('message');
            foreach ($messages as $message) {
                $message->message->load('messages');
            }
        }
        return $messages->toArray();
    }

    /**
     * Create new message for wrestler.
     *
     * @param array $attributes
     */
    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Update the message wrestler.
     *
     * @param integer $message_id
     * @param integer $wrestler_id
     * @param array $attributes
     */
    public function update($message_id, $wrestler_id, $attributes)
    {
        $this->model->where('message_id', $message_id)->where('wrestler_id', $wrestler_id)->update($attributes);
    }

    /**
     * Check to see if wrestler is involved in message.
     *
     * @param integer $wrestler_id
     * @param integer $message_id
     * @return boolean
     */
    public function exists($wrestler_id, $message_id)
    {
        return $this->model->where('message_id', $message_id)->where('wrestler_id', $wrestler_id)->whereNull('deleted_at')->exists();
    }


}
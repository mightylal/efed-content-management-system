<?php

namespace Efed\Services;

use Efed\Models\Message;
use Efed\Models\MessageBody;
use Efed\Contracts\Repositories\MessageWrestlerRepository;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Validation\MessageValidator;
use Carbon\Carbon;

class MessageService
{
    
    /**
     * @var MessageWrestlerRepository
     */
    private $messageWrestlerRepo;

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;
    
    /**
     * Start new MessageService.
     *
     * @param MessageWrestlerRepository $messageWrestlerRepo
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(MessageWrestlerRepository $messageWrestlerRepo, WrestlerRepository $wrestlerRepo)
    {
        $this->messageWrestlerRepo = $messageWrestlerRepo;
        $this->wrestlerRepo = $wrestlerRepo;
    }
    
    /**
     * Create new message.
     * 
     * @param integer $wrestler_id
     * @param array $input
     */
    public function create($wrestler_id, $input)
    {
        (new MessageValidator)->validateCreateMessage($input);
        $wrestler = $this->wrestlerRepo->getByName($input['name'], ['id']);
        $message = (new Message)->create(['subject' => $input['subject']]);
        (new MessageBody)->create(['message_id' => $message->id, 'wrestler_id' => $wrestler_id, 'message' => clean($input['message'], 'default')]);
        $this->messageWrestlerRepo->create(['message_id' => $message->id, 'wrestler_id' => $wrestler_id, 'viewed_at' => Carbon::now()->toDateTimeString()]);
        // wrestler is sending message to itself
        if ($wrestler_id != $wrestler['id']) {
            $this->messageWrestlerRepo->create(['message_id' => $message->id, 'wrestler_id' => $wrestler['id']]);
        }
    }

    /**
     * Create reply message.
     *
     * @param integer $message_id
     * @param integer $wrestler_id
     * @param array $input
     */
    public function reply($message_id, $wrestler_id, $input)
    {
        (new MessageValidator)->validateReply($input);
        (new Message)->where('id', $message_id)->update(['updated_at' => Carbon::now()->toDateTimeString()]);
        (new MessageBody)->create(['message_id' => $message_id, 'wrestler_id' => $wrestler_id, 'message' => clean($input['message'], 'default')]);
    }
    
    /**
     * Wrestler views a message.
     * 
     * @param integer $message_id
     * @param integer $wrestler_id
     */
    public function viewed($message_id, $wrestler_id)
    {
        $this->messageWrestlerRepo->update($message_id, $wrestler_id, ['viewed_at' => Carbon::now()->toDateTimeString()]);
    }
    
    /**
     * Delete messages.
     * 
     * @param integer $wrestler_id
     * @param array $input
     */
    public function delete($wrestler_id, $input)
    {
        $input['id'] = array_map('trim', $input['id']);
        (new MessageValidator)->validateDeleteMessage($input, $wrestler_id);
        foreach ($input['id'] as $message_id) {
            $this->messageWrestlerRepo->update($message_id, $wrestler_id, ['deleted_at' => Carbon::now()->toDateTimeString()]);
        }
    }
    
}
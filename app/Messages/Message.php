<?php

namespace Efed\Messages;

use Illuminate\Database\DatabaseManager;

class Message
{

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * Message constructor.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the message.
     *
     * @param integer $message_id
     * @param integer $wrestler_id
     * @return array
     */
    public function get($message_id, $wrestler_id)
    {
        return $this->db->connection('mysql')->table('messageWrestler')
        ->selectRaw('messageBody.message, messageBody.created_at, wrestler.slug AS wrestlerSlug, wrestler.name AS wrestlerName')
        ->join('messageBody', 'messageWrestler.message_id', '=', 'messageBody.message_id')
        ->join('wrestler', 'messageBody.wrestler_id', '=', 'wrestler.id')
        ->where('messageWrestler.message_id', $message_id)
        ->where('messageWrestler.wrestler_id', $wrestler_id)
        ->orderBy('messageBody.created_at', 'desc')
        ->get();
    }

}
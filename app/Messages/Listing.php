<?php

namespace Efed\Messages;

use Illuminate\Database\DatabaseManager;

class Listing
{

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * Start new Listing.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the messages.
     *
     * @param integer $wrestler_id
     * @return array
     */
    public function get($wrestler_id)
    {
        return $this->db->connection('mysql')->table('messageWrestler')
        ->selectRaw("message.id, message.subject, message.updated_at, CASE WHEN (messageWrestler.viewed_at >= message.updated_at) THEN 1 ELSE 0 END AS has_viewed")
        ->join('message', 'messageWrestler.message_id', '=', 'message.id')
        ->where('messageWrestler.wrestler_id', $wrestler_id)
        ->whereNull('messageWrestler.deleted_at')
        ->orderBy('message.updated_at', 'desc')
        ->get();
    }
}
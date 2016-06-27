<?php

namespace Efed\Messages;

use Illuminate\Database\DatabaseManager;

class NewCount
{

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * NewCount constructor.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the new message count.
     *
     * @param integer $wrestler_id
     * @return integer
     */
    public function get($wrestler_id)
    {
        return $this->db->connection('mysql')->table('messageWrestler')
            ->join('message', 'messageWrestler.message_id', '=', 'message.id')
            ->where('messageWrestler.wrestler_id', $wrestler_id)
            ->whereNull('messageWrestler.deleted_at')
            ->whereRaw("(message.updated_at > messageWrestler.viewed_at OR messageWrestler.viewed_at IS NULL)")
            ->count('message.id');
    }

}
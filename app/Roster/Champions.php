<?php

namespace Efed\Roster;

use Illuminate\Database\DatabaseManager;

class Champions
{

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * Start new Champions.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the champions.
     *
     * @return array
     */
    public function get()
    {
        return $this->db->connection('mysql')->table('fedTitle')
            ->selectRaw("fedTitle.name AS titleName, fedTitle.type, wrestlerone.id AS wrestler_one_id, wrestlerone.name AS wrestlerOneName, wrestlertwo.id AS wrestler_two_id, wrestlertwo.name AS wrestlerTwoName, titleImage.url")
            ->join('fedTitleReign', 'fedTitle.id', '=', 'fedTitleReign.title_id')
            ->leftJoin($this->db->raw("(SELECT id, name FROM wrestler) AS wrestlerone"), 'fedTitleReign.wrestler_id_one', '=', 'wrestlerone.id')
            ->leftJoin($this->db->raw("(SELECT id, name FROM wrestler) AS wrestlertwo"), 'fedTitleReign.wrestler_id_two', '=', 'wrestlertwo.id')
            ->leftJoin('titleImage', 'fedTitle.id', '=', 'titleImage.title_id')
            ->whereNull('fedTitleReign.date_lost')
            ->orderBy('fedTitle.placement', 'ASC')
            ->get();
    }
}
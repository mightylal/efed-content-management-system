<?php

namespace Efed\Title;

use Illuminate\Database\DatabaseManager;

class Available
{

    /**
     * @var DatabaseManager
     */
    private $db;
    
    /**
     * Start new Available.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the titles available to be selected.
     * 
     * @param string $type
     * @param array $wrestlers
     * @return array
     */
    public function get($type, $wrestlers)
    {
        $wrestlers[] = 0;
        $results = $this->db->connection('mysql')->table('fedTitle')
            ->selectRaw("fedTitle.id, fedTitle.name")
            ->join('fedTitleReign', 'fedTitle.id', '=', 'fedTitleReign.title_id')
            ->where('fedTitle.type', $type)
            ->whereNull('fedTitleReign.date_lost')
            ->whereIn('fedTitleReign.wrestler_id_one', $wrestlers)
            ->whereIn('fedTitleReign.wrestler_id_two', $wrestlers)
            ->get();
        $titles = [0 => 'Non-Title'];
        if (count($results) > 0) {
            foreach ($results as $result) {
                $titles[$result->id] = $result->name;
            }
        }
        return $titles;
    }

}
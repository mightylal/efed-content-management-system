<?php

namespace Efed\Staff;

use Illuminate\Database\DatabaseManager;

class Staff
{
    
    /**
     * @var DatabaseManager
     */
    private $db;
    
    /**
     * Start new Staff.
     * 
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }
    
    /**
     * Retrieve the staff members.
     * 
     * @return array
     */
    public function get()
    {
        return $this->db->connection('mysql')->table('fedStaff')
            ->selectRaw("fedStaff.id, wrestler.name")
            ->join('wrestler', 'fedStaff.wrestler_id', '=', 'wrestler.id')
            ->get();
    }
    
}
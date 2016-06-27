<?php

namespace Efed\Services\Admin;

use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Validation\RosterValidator;

class RosterService
{

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;
    
    /**
     * Start new RosterService.
     * 
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(WrestlerRepository $wrestlerRepo)
    {
        $this->wrestlerRepo = $wrestlerRepo;        
    }
    
    /**
     * Remove a wrestler from fed. Soft delete.
     * 
     * @param array $input
     */
    public function remove($input)
    {
        $input['id'] = array_map('trim', $input['id']);
        (new RosterValidator)->validateRemovingWrestlers($input);
        foreach ($input['id'] as $id) {
            $this->wrestlerRepo->remove($id);
        }
    }

}
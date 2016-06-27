<?php

namespace Efed\Services\Admin;

use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Models\Staff;
use Efed\Validation\StaffValidator;

class StaffService
{
    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new StaffService.
     * 
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(WrestlerRepository $wrestlerRepo)
    {
        $this->wrestlerRepo = $wrestlerRepo;
    }
    
    /**
     * Create new staff.
     * 
     * @param array $input
     */
    public function create($input)
    {
        (new StaffValidator)->validateAdd($input);
        $wrestler = $this->wrestlerRepo->getByName($input['name'], ['id']);
        (new Staff)->create(['wrestler_id' => $wrestler['id']]);
    }
    
    /**
     * Delete from staff.
     * 
     * @param array $input
     */
    public function delete($input)
    {
        $input['id'] = array_map('trim', $input['id']);
        (new StaffValidator)->validateDelete($input);
        (new Staff)->destroy($input['id']);
    }
    
}
<?php

namespace Efed\Services;

use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Image\Upload;
use Efed\Models\WrestlerImage;
use Efed\Validation\WrestlerValidator;
use Illuminate\Http\Request;

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
     * @return void
     */
    public function __construct(WrestlerRepository $wrestlerRepo)
    {
        $this->wrestlerRepo = $wrestlerRepo;
    }
    
    /**
     * Update a wrestler.
     * 
     * @param integer $wrestler_id
     * @param Request $request
     * @return string
     */
    public function update($wrestler_id, Request $request)
    {
        $input = array_map('trim', $request->only('name', 'age', 'gender', 'height', 'weight', 'bio'));
        $input['image'] = $request->file('image');
        (new WrestlerValidator)->validateUpdateWrestler($input);
        if ($request->hasFile('image')) {
            (new Upload)->handle(new WrestlerImage, $request->file('image'), $wrestler_id);
        }
        $input['slug'] = str_slug($input['name']);
        unset($input['image']);
        $input['bio'] = clean($input['bio'], 'default');
        $this->wrestlerRepo->update($wrestler_id, $input);
        return $input['slug'];
    }
    
}
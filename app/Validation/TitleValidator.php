<?php

namespace Efed\Validation;

use Efed\Placement\PlacementValidator;
use Efed\Placement\PlacementForm;

class TitleValidator extends Validator implements PlacementValidator
{
    
    /**
     * Validate creating a title.
     * 
     * @param array $data
     */
    public function validateTitle($data)
    {
        self::$rules = [
            'name' => 'required',
            'type' => 'required|in:Single,Tag Team'
        ];
        $this->validate($data);
    }
    
    /**
     * Validate editing a title.
     * 
     * @param array $data
     */
    public function validateEditTitle($data)
    {
        self::$rules = [
            'id' => 'required|exists:fedTitle,id',
            'name' => 'required',
            'doAssign' => 'required',
            'assign' => 'array|required_if:doAssign,yes|wrestlers_match_title|vacant_title',
            'assign.*' => 'exists_title',
            'image' => 'mimes:png,jpeg,jpg,gif|max:100'
        ];
        $this->validate($data);
    }
    
    /**
     * Validate title placement.
     * 
     * @param array $data
     * @param integer $entity_id
     */
    public function validatePlacement($data, $entity_id = null)
    {
        self::$rules = PlacementForm::$rules;
        self::$rules[] = ['id.*' => 'exists:fedTitle,id'];
        $this->validate($data);
    }
    
    /**
     * Validate deleting a title.
     * 
     * @param array $data
     */
    public function validateDeleteTitle($data)
    {
        self::$rules = [
            'id' => 'required|exists:fedTitle,id'
        ];
    }
    
}
<?php

namespace Efed\Validation;

use Efed\Placement\PlacementValidator;
use Efed\Placement\PlacementForm;

class PageValidator extends Validator implements PlacementValidator
{
    
    /**
     * Validate creating a page.
     * 
     * @param array $data
     */
    public function validateCreatePage($data)
    {
        self::$rules = [
            'name' => 'required|max:100',
            'access' => 'required|in:Everyone,Staff'
        ];
        $this->validate($data);
    }
    
    /**
     * Validate editing a page.
     * 
     * @param array $data
     */
    public function validateEditPage($data)
    {
        self::$rules = [
            'name' => 'required',
            'access' => 'required|in:Everyone,Staff'
        ];
        $this->validate($data);
    }

    /**
     * Validate updating placement.
     *
     * @param array $data
     * @param integer $entity_id (optional)
     */
    public function validatePlacement($data, $entity_id = null)
    {
        self::$rules = PlacementForm::$rules;
        self::$rules[] = ['id.*' => 'exists:fedPage,id'];
        $this->validate($data);
    }


}
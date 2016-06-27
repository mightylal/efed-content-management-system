<?php

namespace Efed\Validation;

use Efed\Placement\PlacementValidator;
use Efed\Placement\PlacementForm;

class ForumValidator extends Validator implements PlacementValidator
{

    /**
     * Validate creating a forum.
     *
     * @param array $data
     */
    public function validateCreateForum($data)
    {
        self::$rules = [
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'access' => 'required|in:Everyone,Staff',
            'posting' => 'required|in:Everyone,Staff'
        ];
        $this->validate($data);
    }

    /**
     * Validate updating a forum.
     * 
     * @param array $data
     */
    public function validateUpdateForum($data)
    {
        self::$rules = [
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'access' => 'required|in:Everyone,Staff',
            'posting' => 'required|in:Everyone,Staff',
        ];
        $this->validate($data);
    }

    /**
     * Validate deleting a forum.
     * 
     * @Param array $data
     */
    public function validateDeleteForum($data)
    {
        self::$rules = [
            'id' => 'exists:forum,id',
        ];
        $this->validate($data);
    }
    
    /**
     * Validate creating a topic.
     * 
     * @param array $data
     */
    public function validateCreateTopic($data)
    {
        self::$rules = [
            'name' => 'required',
            'post' => 'required',
        ];
        $this->validate($data);
    }
    
    /**
     * Validate creating a post.
     * 
     * @param array $data
     */
    public function validateCreatePost($data)
    {
        self::$rules = [
            'post' => 'required',
        ];
        $this->validate($data);
    }
    
    /**
     * Validate editing a post.
     * 
     * @param array $data
     */
    public function validateEditPost($data)
    {
        self::$rules = [
            'post' => 'required',
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
        self::$rules[] = ['id.*' => 'exists:forum,id'];
        $this->validate($data);
    }


}
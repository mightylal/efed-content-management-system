<?php

namespace Efed\Placement;

interface PlacementValidator
{

    /**
     * Validate updating placement.
     * 
     * @param array $data
     * @param integer $entity_id (optional)
     */
    public function validatePlacement($data, $entity_id = null);

}
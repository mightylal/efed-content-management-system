<?php

namespace Efed\Placement;

use Efed\Placement\PlacementValidator;

class Placement
{

    /**
     * Update the placement of the entity.
     *
     * @param PlacementValidator $validator
     * @param object $repo
     * @param array $input
     * @param integer $entity_id (optional)
     */
    public function handle(PlacementValidator $validator, $repo, $input, $entity_id = null)
    {
        $input['id'] = array_map('trim', $input['id']);
        $validator->validatePlacement($input, $entity_id);
        foreach ($input['id'] as $key => $id) {
            $repo->update($id, ['placement' => ($key + 1)]);
        }
    }
    
}
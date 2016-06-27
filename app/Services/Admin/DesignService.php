<?php

namespace Efed\Services\Admin;

use Efed\Models\Style;
use Efed\Validation\DesignValidator;

class DesignService
{

    /**
     * Update the style.
     *
     * @param array $input
     */
    public function update($input)
    {
        (new DesignValidator)->validateEditStyle($input);
        $style = (new Style)->get();
        $style->fill($input);
        $style->save();
    }

}
<?php

namespace Efed\Services\Admin;

use Efed\Models\Settings;
use Efed\Validation\SettingsValidator;

class SettingsService
{
    
    /**
     * Update the settings.
     * 
     * @param array $input
     */
    public function update($input)
    {
        (new SettingsValidator)->validateEditSettings($input);
        $settings = (new Settings)->get();
        $settings->fill($input);
        $settings->save();
    }

}
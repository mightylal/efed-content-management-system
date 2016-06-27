<?php

namespace Efed\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Models\Settings;
use Efed\Services\Admin\SettingsService;
use Efed\Exceptions\ValidationException;

class SettingsController extends Controller
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * Start new SettingsController.
     * 
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }
    
    /**
     * Display the admin settings view.
     * 
     * @return view
     */
    public function index()
    {
        $settings = (new Settings)->get()->toArray();
        return view('admin.control-panel.settings', compact('settings'));
    }

    /**
     * Update the settings.
     *
     * @param Request $request
     * @return response
     */
    public function update(Request $request)
    {
        try {
            $this->settingsService->update(array_map('trim', $request->only('roleplayLimit', 'gradeRights')));
            return redirect()->route('admin.settings')->with('message', 'Settings updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.settings')->withErrors($error->getErrors());
        }
    }
}

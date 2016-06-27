<?php

namespace Efed\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Models\Style;
use Efed\Services\Admin\DesignService;
use Efed\Exceptions\ValidationException;

class DesignController extends Controller
{
    /**
     * @var DesignService
     */
    private $designService;

    /**
     * Start new DesignController.
     *
     * @param DesignService $designService
     */
    public function __construct(DesignService $designService)
    {
        $this->designService = $designService;
    }
    
    /**
     * Display the admin design view.
     * 
     * @return view
     */
    public function index()
    {
        $style = (new Style)->get();
        return view('admin.control-panel.design', compact('style'));
    }
    
    /**
     * Update the style sheet.
     * 
     * @param Request $request
     * @return response
     */
    public function update(Request $request)
    {
        try {
            $this->designService->update(array_map('trim', $request->only('primary1', 'primary2', 'secondary1', 'secondary2', 'secondary3', 'secondary4')));
            return redirect()->route('admin.design')->with('message', 'Design updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.design')->withErrors($error->getErrors());
        }
    }
}

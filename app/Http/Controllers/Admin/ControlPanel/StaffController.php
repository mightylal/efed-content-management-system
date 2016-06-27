<?php

namespace Efed\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\StaffService;
use Efed\Staff\Staff;
use Efed\Exceptions\ValidationException;

class StaffController extends Controller
{
    /**
     * @var StaffService
     */
    private $staffService;

    /**
     * @var Staff
     */
    private $staff;

    /**
     * Start new StaffController.
     * 
     * @param StaffService $staffService
     * @param Staff $staff
     */
    public function __construct(StaffService $staffService, Staff $staff)
    {
        $this->staffService = $staffService;
        $this->staff = $staff;
    }
    
    /**
     * Display the admin staff view.
     * 
     * @return view
     */
    public function index()
    {
        $staffs = $this->staff->get();
        return view('admin.control-panel.staff', compact('staffs'));
    }
    
    /**
     * Create new staff.
     * 
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        try {
            $this->staffService->create(array_map('trim', $request->only('name')));
            return redirect()->route('admin.staff')->with('message', 'Staff member added successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.staff')->withErrors($error->getErrors());
        }
    }
    
    /**
     * Delete staff member.
     * 
     * @param Request $request
     * @return response
     */
    public function destroy(Request $request)
    {
        try {
            $this->staffService->delete($request->only('id'));
            return redirect()->route('admin.staff')->with('message', 'Staff member(s) deleted successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.staff')->withErrors($error->getErrors());
        }
    }
}

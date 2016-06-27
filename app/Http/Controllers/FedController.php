<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Models\Settings;

class FedController extends Controller
{

    /**
     * Display the home view.
     *
     * @return view
     */
    public function index()
    {
        $settings = (new Settings)->get()->toArray();
        $content = $settings['content'];
        return view('fed', compact('content'));
    }
    
    /**
     * Display the edit home view.
     * 
     * @return view
     */
    public function edit()
    {
        $settings = (new Settings)->get()->toArray();
        $content = $settings['content'];
        return view('edit', compact('content'));
    }

    /**
     * Update the home page.
     *
     * @param Request $request
     * @return response
     */
    public function update(Request $request)
    {
        $settings = (new Settings)->get();
        $settings->content = clean(trim($request->home));
        $settings->save();
        return redirect()->route('home')->with('message', 'Home page updated successfully.');
    }

}

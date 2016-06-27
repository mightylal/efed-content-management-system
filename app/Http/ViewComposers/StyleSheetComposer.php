<?php

namespace Efed\Http\ViewComposers;

use Illuminate\View\View;
use Efed\Models\Style;

class StyleSheetComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $style = (new Style)->get();
        $view->with('style', $style);
    }

}
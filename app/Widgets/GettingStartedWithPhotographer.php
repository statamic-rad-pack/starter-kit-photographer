<?php

namespace App\Widgets;

use Statamic\Widgets\Widget;

class GettingStartedWithPhotographer extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        $galleries = \Statamic\Facades\Entry::query()->where('collection', 'galleries')->count();

        return view('widgets.getting-started', compact('galleries'));
    }
}

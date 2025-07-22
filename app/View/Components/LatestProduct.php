<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Theme;

use App\CmsTrait;

class LatestProduct extends Component
{
    use CmsTrait;
    /**
     * Create a new component instance.
     */

    public $id, $title, $description;

    public function __construct($id=null, $title = null, $description = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view($this->default_template().'.components.latest-product');
    }
}

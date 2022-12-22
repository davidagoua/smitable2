<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuLink extends Component
{

    public $link, $badge, $icon, $label= null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link=null, $badge=null, $label=null, $icon=null)
    {
        $this->link = $link;
        $this->badge = $badge;
        $this->label = $label;
        $this->icon =  $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu-link');
    }
}

<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Base extends Component
{
    public $brand;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->brand = session('brand');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.base');
    }
}

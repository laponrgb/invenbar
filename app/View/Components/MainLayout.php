<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    /**
     * Create a new component instance.
     */
     public $titlePage; // tambahkan ini
     
      public function __construct($titlePage)
    {
        $this->titlePage = $titlePage;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.main');
    }
}

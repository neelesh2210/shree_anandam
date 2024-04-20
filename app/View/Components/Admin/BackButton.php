<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackButton extends Component
{
    public $route="";

    public function __construct($route){
        $this->route = $route;
    }

    public function render(): View|Closure|string{
        return view('components.admin.back-button');
    }
}

<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddButton extends Component
{

    public $route = "";
    public $text = "";

    public function __construct($route,$text){
        $this->route = $route;
        $this->text = $text;
    }

    public function render(): View|Closure|string{
        return view('components.admin.add-button');
    }
}

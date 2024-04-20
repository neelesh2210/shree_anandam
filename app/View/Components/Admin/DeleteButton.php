<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $route = "";
    public $id = "";

    public function __construct($route,$id){
        $this->route = $route;
        $this->id = $id;
    }

    public function render(): View|Closure|string{
        return view('components.admin.delete-button');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
    public $label;
    public $type;
    public $placeholder;
    public $name;
    public function __construct($label, $type, $placeholder, $name)
    {
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}

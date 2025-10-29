<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $placeholder;
    public $type;
    public $required;
    public $label;
    public $col;
    public $value; // <-- add this

    public function __construct($name, $label = '', $placeholder = '', $type = 'text', $required = false, $col = 'col-12', $value = '')
    {
        $this->name = $name;
        $this->label = $label ?: ucfirst($name); // Default label is capitalized name
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->required = $required;
        $this->col = $col;
          $this->value = $value;
    }

    public function render()
    {
        return view('components.input');
    }
}

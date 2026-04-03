<?php

namespace Elcheco\SortablePillbox\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class SortablePillbox extends Component
{
    #[Modelable]
    public array $selected = [];

    public array $options = [];

    public function render()
    {
        return view('sortable-pillbox::livewire.sortable-pillbox');
    }
}

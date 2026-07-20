<?php

namespace App\View\Components\Property;

use Illuminate\View\Component;

class EmptyState extends Component
{
    public function render()
    {
        return view('components.property.empty-state');
    }
}
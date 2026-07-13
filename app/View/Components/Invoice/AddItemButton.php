<?php

namespace App\View\Components\Invoice;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddItemButton extends Component
{
    public string $id;
    public string $text;
    public string $onclick;

    public function __construct(
        string $id = 'add-item-btn',
        string $text = 'Add New Item',
        string $onclick = 'addItemRow()'
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->onclick = $onclick;
    }

    public function render(): View|Closure|string
    {
        return view('components.invoice.add-item-button');
    }
}
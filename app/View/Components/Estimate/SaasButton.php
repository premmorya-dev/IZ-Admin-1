<?php

namespace App\View\Components\Invoice;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SaasButton extends Component
{
    public string $href;
    public ?string $icon;

    public function __construct($href = '#', $icon = null)
    {
        $this->href = $href;
        $this->icon = $icon;
    }

    public function render(): View|Closure|string
    {
        return view('components.invoice.saas-button');
    }
}
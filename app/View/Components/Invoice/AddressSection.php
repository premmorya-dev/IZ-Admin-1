<?php

namespace App\View\Components\Invoice;

use Illuminate\View\Component;

class AddressSection extends Component
{
    public $setting;

    public function __construct($setting)
    {
        $this->setting = $setting;
    }

    public function render()
    {
        return view('components.invoice.address-section');
    }
}
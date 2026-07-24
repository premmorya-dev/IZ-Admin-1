<?php

namespace App\View\Components\Estimate;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SettingSwitch extends Component
{
    /**
     * Create a new component instance.
     */
    public $data;
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.estimate.setting-switch', [
            'data' => $this->data,
        ]);
    }
}

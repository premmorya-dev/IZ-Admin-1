<?php

namespace App\View\Components\Invoice;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $data;
  
   public function __construct( array $data)
    {
        $this->data = $data;
       
    }

    public function render(): View|Closure|string
    {


        return view('components.invoice.header', [
                'data' => $this->data
            ]);


    }
}
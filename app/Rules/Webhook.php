<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class Webhook implements Rule
{
    protected $webhook;

    public function __construct($webhook)
    {
        $this->webhook = $webhook;
    }

    public function passes($attribute, $value)
    {
       
        if($value){
            foreach($value as $key => $val){
            //    dd($val);
                if(!isset($val) || !$val){   
                    unset($value[$key]);                   
                //    return false;

                }

            }

        }
        return true;
    }

    public function message()
    {
        return 'The : Please pass the url value .';
    }
}
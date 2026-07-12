<?php

namespace App\Repositories\Invoice;

use App\Models\PaymentModel;

class PaymentRepository
{
    public function create(array $attributes): PaymentModel
    {
        return PaymentModel::create($attributes);
    }
}

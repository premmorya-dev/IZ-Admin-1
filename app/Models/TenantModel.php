<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

abstract class TenantModel extends Model
{
    use BelongsToTenant;
}

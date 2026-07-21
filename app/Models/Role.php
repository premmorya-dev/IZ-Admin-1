<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\Traits\BelongsToTenant;

class Role extends SpatieRole
{
    use BelongsToTenant;
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'guard_name',
        'account_id',
    ];
}

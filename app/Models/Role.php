<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'role_type'])]
class Role extends Model
{
    const ADMIN_ROLE = 1;
    const MENAGER_ROLE = 2;
    const USER_ROLE = 3;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

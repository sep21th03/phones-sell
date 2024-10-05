<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService extends BaseService
{
    public function setModel()
    {
        return new Role();
    }
}

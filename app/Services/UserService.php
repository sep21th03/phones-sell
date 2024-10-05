<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    public function setModel()
    {
        return new User();
    }

    public function getAllUsers()
    {
        return $this->model->all();
    }
    public function update($id, $data)
    {
        DB::beginTransaction();

        try {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'updated_at' => now(),
                ]);

            if (!empty($data['role'])) {
                $role = DB::table('roles')->where('name', $data['role'])->first();
                if ($role) {
                    DB::table('model_has_roles')
                        ->where('model_id', $id)
                        ->updateOrInsert(
                            ['model_id' => $id, 'model_type' => 'App\Models\User'],
                            ['role_id' => $role->id]
                        );
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getAllUsersWithRoles()
    {
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->get();

        $result = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'roles' => $user->role_name ?? 'No role',
            ];
        });

        return $result;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('model_has_roles')->where('model_id', $id)->delete();

            $deleted = DB::table('users')->where('id', $id)->delete();

            DB::commit();
            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

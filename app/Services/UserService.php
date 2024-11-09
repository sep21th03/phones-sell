<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
                'avt_url' => $user->avt_url,
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

    public function getNewUsersComparison()
    {
        $today = Carbon::now();
        $lastWeek = Carbon::now()->subDays(7);

        $newUsersPerDay = User::whereBetween('created_at', [$lastWeek, $today])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $dates = [];
        for ($i = 0; $i <= 6; $i++) {
            $date = $lastWeek->copy()->addDays($i)->format('Y-m-d');
            $dates[$date] = $newUsersPerDay->get($date, 0);
        }

        $currentWeekUsers = User::whereBetween('created_at', [$lastWeek, $today])->count();
        $previousWeekStart = Carbon::now()->subDays(14);
        $previousWeekEnd = Carbon::now()->subDays(7);
        $previousWeekUsers = User::whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])->count();

        if ($previousWeekUsers == 0) {
            $percentageChange = $currentWeekUsers > 0 ? 100 : 0;
        } else {
            $percentageChange = (($currentWeekUsers - $previousWeekUsers) / $previousWeekUsers) * 100;
        }

        return [
            'dates' => array_keys($dates),
            'usersPerDay' => array_values($dates),
            'currentWeekUsers' => $currentWeekUsers,
            'previousWeekUsers' => $previousWeekUsers,
            'percentageChange' =>  round($percentageChange, 2),
        ];
    }


    public function getCurrentUser()
    {
        return Auth::user();
    }
    public function getUserId()
    {
        return response()->json(['user_id' => Auth::user()->id]);
    }
}

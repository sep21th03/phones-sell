<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Thiết lập khoảng thời gian từ 8/10/2024 đến hôm nay
        $startDate = Carbon::create(2024, 10, 8);
        $endDate = Carbon::now();

        foreach (range(1, 50) as $index) {
            // Tạo một người dùng với ngày tạo ngẫu nhiên
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('password'),
                'created_at' => $faker->dateTimeBetween($startDate, $endDate),
            ]);

            // Gán vai trò cho người dùng
            $user->assignRole('member');
        }
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
/**
 * @method string createToken(string $name, array $abilities = ['*'])
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'phone',
        'address',
        'avt_url',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public static function getByUsername($email)
    {
        return self::where('email', $email)->first();
    }

    public static function checkUsername($email)
    {
        return self::where('email', $email)->exists();
    }

    public static function createUser($email, $name, $password, $address, $phone, $avt)
    {
        $create = new User();
        $create->email = $email;
        $create->name = $name;
        $create->password = $password;
        $create->address = $address;
        $create->phone = $phone;
        $create->phone = $phone;
        $create->avt_url = $avt;

        if ($create->save()) {
            return $create;
        }

        return null;
    }

    public static function updateToken($username, $token)
    {
        return self::where('email', $username)->update(['remember_token' => $token]);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
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

    public static function createUser($email, $name, $password, $address, $phone)
    {
        $create = new User();
        $create->email = $email;
        $create->name = $name;
        $create->password = $password;
        $create->address = $address;
        $create->phone = $phone;
        $create->role = 0;

        if ($create->save()) {
            return $create;
        }

        return null;
    }

    public static function getUser()
    {
        return self::all();
    }

    public static function getUserById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function updateToken($username, $token)
    {
        return self::where('email', $username)->update(['remember_token' => $token]);
    }
}

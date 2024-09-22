<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    protected $table = 'categories';

    public static function search($query)
    {
        return self::where('name', 'LIKE', "%{$query}%")->get();
    }
    public static function delete_category($id)
    {
        return self::where('id', $id)->delete();
    }
    public static function getCategory(){
        return self::all();
    }
}

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
    protected $primaryKey = 'id';
    public function phones() {
        return $this->hasMany(Product::class, 'category_id');
    }
    public static function delete_category($id)
    {
        return self::where('id', $id)->delete();
    }
    public static function getCategory(){
        return self::all();
    }
    public static function newCategory() {
        $dateThreshold = now()->subDays(10);
    
        $categories = Category::where('created_at', '>=', $dateThreshold)
            ->orWhere('updated_at', '>=', $dateThreshold)
            ->get(); 
    
        $count = $categories->count();
    
        return [
            'count' => $count,
            'categories' => $categories,
        ];
    }
    
}

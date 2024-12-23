<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'info',
        'description',
        'category_id',
        'discount',
    ];

    public function specifications()
    {
        return $this->hasOne(ProductSpecification::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
}

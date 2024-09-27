<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
        'product_variant_id', 'image_url'
    ];
    public $timestamps = false;

    // Quan hệ n-1 với ProductVariant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}

<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id', 'rom_id', 'color', 'price', 'availability'
    ];
    public $timestamps = false;

    // Quan hệ n-1 với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ n-1 với Rom
    public function rom()
    {
        return $this->belongsTo(Rom::class);
    }

    // Quan hệ 1-n với product_images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public static function createVariant($productId, $romId, $color, $color_code, $price, $availability, $stock) {
        $variant = new self(); 
        $variant->product_id = $productId;
        $variant->rom_id = $romId;
        $variant->color = $color;
        $variant->color_code = $color_code;
        $variant->price = $price;
        $variant->availability = $availability;
        $variant->stock = $stock;
        $variant->save(); 

        return $variant; 
    }
}

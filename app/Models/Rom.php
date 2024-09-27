<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rom extends Model
{
    use HasFactory;
    protected $table = 'roms';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['capacity'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}

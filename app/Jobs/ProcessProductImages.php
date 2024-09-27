<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProcessProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;
    protected $images;

    public function __construct(Product $product, array $images)
    {
        $this->product = $product;
        $this->images = $images;
    }

    public function handle()
    {
        $this->product->images()->delete();
    }
    protected function storeImage(Request $request) {
        $path = $request->file('photo')->store('public/profile');
        return substr($path, strlen('public/'));
      }
      
}

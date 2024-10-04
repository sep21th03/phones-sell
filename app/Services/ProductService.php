<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{

    public function getAllProducts()
    {
        return Product::with('specifications', 'variants.rom', 'variants.images')->get();
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $product = Product::create([
                'title' => $data['title'],
                'category_id' => $data['category_id'],
                'description' => $data['description'],
                'info' => $data['info'],
                'discount' => $data['discount'],
            ]);

            $this->createSpecifications($product->id, $data);

            $variant = $this->createVariant($product->id, $data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $this->saveImage($variant->id, $data['image']);
            } else {
                ProductImage::create([
                    'product_variant_id' => $variant->id,
                    'image_url' => 'assets/img/products/template_img.jpg',
                ]);
            }

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Thêm sản phẩm thành công!'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ];
        }
    }

    private function createSpecifications($productId, $data)
    {
        $specifications = new ProductSpecification();
        $specifications->product_id = $productId;
        $specifications->screen_size = $data['screen_size'];
        $specifications->screen_type = $data['screen_type'];
        $specifications->screen_resolution = $data['screen_resolution'];
        $specifications->ram = $data['ram'];
        $specifications->memory_card_slot = $data['memory_card_slot'];
        $specifications->battery = $data['battery'];
        $specifications->camera_front = $data['camera_front'];
        $specifications->camera_rear = $data['camera_rear'];
        $specifications->sim = $data['sim'];
        $specifications->operating_system = $data['operating_system'];
        $specifications->chip = $data['chip'];
        $specifications->pin = $data['pin'];
        $specifications->connectivity = $data['connectivity'];
        $specifications->bluetooth = $data['bluetooth'];
        $specifications->dimensions = $data['dimensions'];
        $specifications->weight = $data['weight'];
        $specifications->save();
    }

    private function createVariant($productId, $data)
    {
        $variant = new ProductVariant();
        $variant->product_id = $productId;
        $variant->rom_id = $data['rom_id'];
        $variant->color = $data['color'];
        $variant->color_code = $data['color_code'];
        $variant->price = $data['price'];
        $variant->availability = $data['availability'];
        $variant->stock = $data['stock'];
        $variant->save();

        return $variant;
    }

    private function saveImage($variantId, $image)
    {
        $randomName = Str::random(10);
        $imageName = $randomName . '_' . time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('assets/img/products'), $imageName);

        $imageAdd = new ProductImage();
        $imageAdd->product_variant_id = $variantId;
        $imageAdd->image_url = 'assets/img/products/' . $imageName;
        $imageAdd->save();
    }

    public function show(String $id)
    {
        $product = Product::with('specifications', 'variants.rom', 'variants.images')
            ->where('id', $id)
            ->firstOrFail();
        return $product;
    }

    public function update($data)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($data['id']);
            if (!$product) {
                return [
                    'status' => 'error',
                    'message' => 'Sản phẩm không tồn tại!',
                ];
            }

            $product->title = $data['title'];
            $product->info = $data['info'];
            $product->description = $data['description'];
            $product->category_id = $data['category_id'];
            $product->discount = $data['discount'];
            $product->save();

            $specifications = ProductSpecification::find($data['specifications_id']);
            if (!$specifications) {
                return [
                    'status' => 'error',
                    'message' => 'Thông số kỹ thuật không tồn tại!',
                ];
            }

            $specifications->screen_size = $data['screen_size'];
            $specifications->screen_type = $data['screen_type'];
            $specifications->screen_resolution = $data['screen_resolution'];
            $specifications->ram = $data['ram'];
            $specifications->memory_card_slot = $data['memory_card_slot'];
            $specifications->battery = $data['battery'];
            $specifications->camera_front = $data['camera_front'];
            $specifications->camera_rear = $data['camera_rear'];
            $specifications->sim = $data['sim'];
            $specifications->operating_system = $data['operating_system'];
            $specifications->chip = $data['chip'];
            $specifications->pin = $data['pin'];
            $specifications->connectivity = $data['connectivity'];
            $specifications->bluetooth = $data['bluetooth'];
            $specifications->dimensions = $data['dimensions'];
            $specifications->weight = $data['weight'];
            $specifications->save();

            $variant = ProductVariant::find($data['variant_id']);
            if (!$variant) {
                return [
                    'status' => 'error',
                    'message' => 'Phiên bản sản phẩm không tồn tại!',
                ];
            }

            $variant->update([
                'rom_id' => $data['rom_id'],
                'color' => $data['color'],
                'price' => $data['price'],
                'availability' => $data['availability'],
                'stock' => $data['stock'],
            ]);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $product_image = ProductImage::where('product_variant_id', $data['variant_id'])->first();

                if ($product_image) {
                    $oldImagePath = public_path($product_image->image_url);

                    if ($product_image->image_url === 'assets/img/products/template_img.jpg') {
                        $randomName = Str::random(10);
                        $image = $data['image'];
                        $imageName = $randomName . '_' . time() . '.' . $image->getClientOriginalExtension();

                        $image->move(public_path('assets/img/products'), $imageName);

                        $product_image->image_url = 'assets/img/products/' . $imageName;
                        $product_image->save();
                    } else {
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                        $product_image->delete();
                    }
                } else {
                    $randomName = Str::random(10);
                    $image = $data['image'];
                    $imageName = $randomName . '_' . time() . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path('assets/img/products'), $imageName);

                    ProductImage::create([
                        'product_variant_id' => $data['variant_id'],
                        'image_url' => 'assets/img/products/' . $imageName,
                    ]);
                }
            }
            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Cập nhật sản phẩm thành công!',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ];
        }
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }


    public function addColor($data)
    {
        $product = Product::find($data['product_id']);
        if (!$product) {
            return [
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại!'
            ];
        }

        DB::beginTransaction();

        try {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'color' => $data['color'],
                'color_code' => $data['color_code'],
                'price' => $data['price'],
                'availability' => $data['availability'],
                'stock' => $data['stock'],
            ]);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $randomName = Str::random(10);
                $image = $data['image'];
                $imageName = $randomName . '_' . time() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('assets/img/products'), $imageName);

                $imageAdd = new ProductImage();
                $imageAdd->product_variant_id = $variant->id; 
                $imageAdd->image_url = 'assets/img/products/' . $imageName;
                $imageAdd->save();
            } else {
                ProductImage::create([
                    'product_variant_id' => $variant->id,
                    'image_url' => 'assets/img/products/template_img.jpg',
                ]);
            }

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Màu sắc đã thêm thành công.',
                'data' => ['variant' => $variant]
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $exception->getMessage() 
            ];
        }
    }

    public function deleteColor($variantId)
    {
        $variant = ProductVariant::find($variantId);
        if (!$variant) {
            return [
                'status' => 'error',
                'message' => 'Phiên bản sản phẩm không tồn tại!'
            ];
        }
        $variant->delete();
        $images = ProductImage::where('product_variant_id', $variant->id)->get();

        if ($images->isNotEmpty()) {
            foreach ($images as $image) {
                $imagePath = public_path($image->image_url);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }
        }
        return [
           'status' => 'success',
           'message' => 'Màu sắc đã xóa thành công.'
        ];
    }

    public function deleteProducts(array $ids){
        return DB::table('products')->whereIn('id', $ids)->delete();
    }

    public function getProductsByCategory($categoryName)
    {
        return Product::with('specifications', 'variants.rom', 'variants.images')->whereHas('category', function ($query) use ($categoryName) {
            $query->where('name', $categoryName);
        })->get();
    }
}

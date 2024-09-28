<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ProductVariant;
use App\Models\ProductSpecification;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!',
        //     ], 401);
        // }
        // if (Auth::user()->role != 1) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Bạn không có quyền thực hiện thao tác này!',
        //     ], 403);
        // }
        $products = Product::with('specifications', 'variants.rom', 'variants.images')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Danh sách sản phẩm',
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category_id ? $product->category->name : null,
                    'title' => $product->title,
                    'description' => $product->description,
                    'discount' => $product->discount,
                    'info' => $product->info,
                    'specifications' => [
                        'id' => $product->specifications->id,
                        'product_id' => $product->specifications->product_id,
                        'screen_size' => $product->specifications->screen_size,
                        'screen_type' => $product->specifications->screen_type,
                        'screen_resolution' => $product->specifications->screen_resolution,
                        'ram' => $product->specifications->ram,
                        'memory_card_slot' => $product->specifications->memory_card_slot,
                        'battery' => $product->specifications->battery,
                        'sim' => $product->specifications->sim,
                        'camera_front' => $product->specifications->camera_front,
                        'camera_rear' => $product->specifications->camera_rear,
                        'operating_system' => $product->specifications->operating_system,
                        'chip' => $product->specifications->chip,
                        'pin' => $product->specifications->pin,
                        'connectivity' => $product->specifications->connectivity,
                        'bluetooth' => $product->specifications->bluetooth,
                        'dimensions' => $product->specifications->dimensions,
                        'weight' => $product->specifications->weight,
                    ],
                    'variants' => $product->variants->map(function ($variant) {
                        return [
                            'id' => $variant->id,
                            'product_id' => $variant->product_id,
                            'rom_id' => $variant->rom_id,
                            'color' => $variant->color,
                            'price' => $variant->price,
                            'availability' => $variant->availability,
                            'stock' => $variant->stock,
                            'rom' => [
                                'id' => $variant->rom->id,
                                'capacity' => $variant->rom->capacity,
                            ],
                            'images' => $variant->images->map(function ($image) {
                                return [
                                    'id' => $image->id,
                                    'product_variant_id' => $image->product_variant_id,
                                    'image_url' => $image->image_url,
                                ];
                            })
                        ];
                    })
                ];
            })
        ]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'info' => 'nullable|string',
                'description' => 'nullable|string',
                'category_id' => 'required|integer|exists:categories,id',
                'discount' => 'nullable|numeric|min:0',
                'screen_size' => 'nullable|string',
                'screen_resolution' => 'nullable|string',
                'screen_type' => 'nullable|string',
                'ram' => 'nullable|string',
                'memory_card_slot' => 'nullable|string',
                'battery' => 'nullable|string',
                'camera_front' => 'nullable|string',
                'camera_rear' => 'nullable|string',
                'sim' => 'nullable|string',
                'operating_system' => 'nullable|string',
                'connectivity' => 'nullable|string',
                'bluetooth' => 'nullable|string',
                'pin' => 'nullable|string',
                'chip' => 'nullable|string',
                'dimensions' => 'nullable|string',
                'weight' => 'nullable|string',
                'rom_id' => 'required|integer',
                'color' => 'required|string',
                'color_code' => 'required|string',
                'stock' => 'required|integer|min:0',
                'price' => 'required|numeric|min:0',
                'availability' => 'required|boolean',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);


            DB::beginTransaction();
            $product = Product::create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'info' => $request->info,
                'discount' => $request->discount,
            ]);


            $specifications = new ProductSpecification();
            $specifications->product_id = $product->id;
            $specifications->screen_size = $request->screen_size;
            $specifications->screen_type = $request->screen_type;
            $specifications->screen_resolution = $request->screen_resolution;
            $specifications->ram = $request->ram;
            $specifications->memory_card_slot = $request->memory_card_slot;
            $specifications->battery = $request->battery;
            $specifications->camera_front = $request->camera_front;
            $specifications->camera_rear = $request->camera_rear;
            $specifications->sim = $request->sim;
            $specifications->operating_system = $request->operating_system;
            $specifications->chip = $request->chip;
            $specifications->pin = $request->pin;
            $specifications->connectivity = $request->connectivity;
            $specifications->bluetooth = $request->bluetooth;
            $specifications->dimensions = $request->dimensions;
            $specifications->weight = $request->weight;
            $specifications->save();

            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->rom_id = $request->rom_id;
            $variant->color = $request->color;
            $variant->color_code = $request->color_code;
            $variant->price = $request->price;
            $variant->availability = $request->availability;
            $variant->stock = $request->stock;
            $variant->save();


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/products'), $imageName);

                $imageAdd = new ProductImage();
                $imageAdd->product_variant_id = $variant->id;
                $imageAdd->image_url = 'assets/img/products/' . $imageName;
                $imageAdd->save();
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Cập nhật sản phẩm thành công!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('specifications', 'variants.rom', 'variants.images')
            ->where('id', $id)
            ->firstOrFail();;

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại',
            ], 404);
        }

        $responseData = [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'title' => $product->title,
            'description' => $product->description,
            'discount' => $product->discount,
            'info' => $product->info,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'specifications' => [
                'id' => $product->specifications->id,
                'product_id' => $product->specifications->product_id,
                'screen_size' => $product->specifications->screen_size,
                'screen_type' => $product->specifications->screen_type,
                'screen_resolution' => $product->specifications->screen_resolution,
                'ram' => $product->specifications->ram,
                'memory_card_slot' => $product->specifications->memory_card_slot,
                'sim' => $product->specifications->sim,
                'camera_front' => $product->specifications->camera_front,
                'camera_rear' => $product->specifications->camera_rear,
                'operating_system' => $product->specifications->operating_system,
                'chip' => $product->specifications->chip,
                'pin' => $product->specifications->pin,
                'connectivity' => $product->specifications->connectivity,
                'bluetooth' => $product->specifications->bluetooth,
                'dimensions' => $product->specifications->dimensions,
                'weight' => $product->specifications->weight,
            ],
            'variants' => $product->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'rom_id' => $variant->rom_id,
                    'color' => $variant->color,
                    'color_code' => $variant->color_code,
                    'price' => $variant->price,
                    'availability' => $variant->availability,
                    'stock' => $variant->stock,
                    'rom' => [
                        'id' => $variant->rom->id,
                        'capacity' => $variant->rom->capacity,
                    ],
                    'images' => $variant->images[0]->image_url,
                ];
            }),
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Danh sách sản phẩm',
            'data' => $responseData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }



    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:products,id',
                'title' => 'required|string|max:255',
                'info' => 'nullable|string',
                'description' => 'nullable|string',
                'category_id' => 'required|integer|exists:categories,id',
                'discount' => 'nullable|numeric|min:0',
                'specifications_id' => 'required|integer|exists:product_specifications,id',
                'screen_size' => 'nullable|string',
                'screen_resolution' => 'nullable|string',
                'screen_type' => 'nullable|string',
                'ram' => 'nullable|string',
                'memory_card_slot' => 'nullable|string',
                'battery' => 'nullable|string',
                'camera_front' => 'nullable|string',
                'camera_rear' => 'nullable|string',
                'sim' => 'nullable|string',
                'operating_system' => 'nullable|string',
                'connectivity' => 'nullable|string',
                'bluetooth' => 'nullable|string',
                'pin' => 'nullable|string',
                'chip' => 'nullable|string',
                'dimensions' => 'nullable|string',
                'weight' => 'nullable|string',
                'variant_id' => "required|integer",
                'rom' => 'required|string',
                'color' => 'required|string',
                'stock' => 'required|integer|min:0',
                'price' => 'required|numeric|min:0',
                'availability' => 'required|boolean',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $product = Product::find($request->id);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm không tồn tại!'
                ], 404);
            }

            DB::beginTransaction();

            $product->title = $request->title;
            $product->info = $request->info;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->discount = $request->discount;
            $product->save();

            $specifications = ProductSpecification::find($request->specifications_id);
            if (!$specifications) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Thông số kỹ thuật không tồn tại!'
                ], 404);
            }

            $specifications->screen_size = $request->screen_size;
            $specifications->screen_type = $request->screen_type;
            $specifications->screen_resolution = $request->screen_resolution;
            $specifications->ram = $request->ram;
            $specifications->memory_card_slot = $request->memory_card_slot;
            $specifications->battery = $request->battery;
            $specifications->camera_front = $request->camera_front;
            $specifications->camera_rear = $request->camera_rear;
            $specifications->sim = $request->sim;
            $specifications->operating_system = $request->operating_system;
            $specifications->chip = $request->chip;
            $specifications->pin = $request->pin;
            $specifications->connectivity = $request->connectivity;
            $specifications->bluetooth = $request->bluetooth;
            $specifications->dimensions = $request->dimensions;
            $specifications->weight = $request->weight;
            $specifications->save();

            $variant = ProductVariant::find($request->variant_id);
            if (!$variant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Phiên bản sản phẩm không tồn tại!'
                ], 404);
            }

            $variant->rom_id = $request->rom_id;
            $variant->color = $request->color;
            $variant->price = $request->price;
            $variant->availability = $request->availability;
            $variant->stock = $request->stock;
            $variant->save();


            $product_image = ProductImage::where('product_variant_id', $request->variant_id)->first();
            if ($request->hasFile('image')) {
                if ($product_image) {
                    if (file_exists(public_path($product_image->image_url))) {
                        unlink(public_path($product_image->image_url));
                    }
                    $product_image->delete();
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/products'), $imageName);

                $imagePr = new ProductImage();
                $imagePr->product_variant_id = $request->variant_id;
                $imagePr->image_url = 'assets/img/products/' . $imageName;
                $imagePr->save();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Cập nhật sản phẩm thành công!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addColor(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer',
                'rom_id' => 'required|integer',
                'color' => 'required|string|max:255',
                'color_code' => 'required|string|max:7',
                'price' => 'required|string|max:255',
                'availability' => 'required|integer',
                'stock' => 'required|integer',
                'image_url' => 'required|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            ]);

            $id = $request->product_id;
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm không tồn tại!'
                ], 404);
            }
            DB::beginTransaction();

            $variant = ProductVariant::createVariant(
                $request->product_id,
                $request->rom_id,
                $request->color,
                $request->color_code,
                $request->price,
                $request->availability,
                $request->stock
            );
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/products'), $imageName);

                $imagePr = new ProductImage();
                $imagePr->product_variant_id = $variant->id;
                $imagePr->image_url = 'assets/img/products/' . $imageName;
                $imagePr->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Màu sắc đã thêm thành công.',
                'data' => ['variant' => $variant, 'image' => $imagePr]
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    // public function getProductByCategory($query)
    // {
    //     $products = Product::getProductByCategory($query);

    //     if ($products->isEmpty()) {
    //         return response()->json([
    //             'message' => 'Không tìm thấy sản phẩm nào trong danh mục: ' . $query,
    //         ], 404);
    //     }

    //     return response()->json(['products' => $products], 200);
    // }
    public function getProductByCategory()
{
    $categoryName = request()->query('category');

    if (!$categoryName) {
        return response()->json(['message' => 'Vui lòng cung cấp tên danh mục'], 400);
    }

    $products = Product::getProductByCategory($categoryName);

    if ($products->isEmpty()) {
        return response()->json([
            'message' => 'Không tìm thấy sản phẩm nào trong danh mục: ' . $categoryName,
        ], 404);
    }

    return response()->json(['products' => $products], 200);
}

}

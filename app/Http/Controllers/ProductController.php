<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ProductService;
use App\Http\Requests\Admin\Product\DeleteProductRequest;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Requests\Admin\ProductColor\StoreProductColorRequest;
use App\Http\Requests\Admin\ProductColor\DeleteProductColorRequest;
use App\Http\Requests\Api\Product\StoreReviewRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Lấy danh sách tất cả sản phẩm.
     * @return JSON danh sách sản phẩm hoặc lỗi nếu không tìm thấy sản phẩm.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();

        return $products
            ? jsonResponse('success', 'Danh sách sản phẩm', $this->prepareProductsData($products))
            : jsonResponse('error', 'Không tìm thấy danh sách sản phẩm!');
    }
    /**
     * Chuẩn bị dữ liệu sản phẩm để trả về.
     * @param Collection $products
     * @return Collection dữ liệu sản phẩm đã được chuẩn hóa.
     */
    private function prepareProductsData($products)
    {
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'category_name' => $product->category_id ? $product->category->name : null,
                'title' => $product->title,
                'description' => $product->description,
                'discount' => $product->discount,
                'info' => $product->info,
                'specifications' => $this->prepareSpecificationsData($product->specifications),
                'variants' => $this->prepareVariantsData($product->variants),
            ];
        });
    }
    /**
     * Chuẩn bị dữ liệu thông số kỹ thuật của sản phẩm.
     * @param $specifications
     * @return array dữ liệu thông số kỹ thuật.
     */
    private function prepareSpecificationsData($specifications)
    {
        return [
            'id' => $specifications->id,
            'product_id' => $specifications->product_id,
            'screen_size' => $specifications->screen_size,
            'screen_type' => $specifications->screen_type,
            'screen_resolution' => $specifications->screen_resolution,
            'ram' => $specifications->ram,
            'memory_card_slot' => $specifications->memory_card_slot,
            'battery' => $specifications->battery,
            'sim' => $specifications->sim,
            'camera_front' => $specifications->camera_front,
            'camera_rear' => $specifications->camera_rear,
            'operating_system' => $specifications->operating_system,
            'chip' => $specifications->chip,
            'pin' => $specifications->pin,
            'connectivity' => $specifications->connectivity,
            'bluetooth' => $specifications->bluetooth,
            'dimensions' => $specifications->dimensions,
            'weight' => $specifications->weight,
        ];
    }
    /**
     * Chuẩn bị dữ liệu các biến thể sản phẩm.
     * @param $variants
     * @return array dữ liệu biến thể sản phẩm.
     */
    private function prepareVariantsData($variants)
    {
        return $variants->map(function ($variant) {
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
                }),
            ];
        });
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image');
        $result = $this->productService->store($data);

        return $result['status'] === 'success'
            ? jsonResponse('success', $result['message'])
            : jsonResponse('error', $result['message']);
    }

    /**
     * Hiển thị thông tin sản phẩm theo ID.
     * @param string $id
     * @return JSON thông tin sản phẩm hoặc lỗi nếu không tìm thấy.
     */
    public function show(string $id)
    {
        $result = $this->productService->show($id);

        return $result
            ? jsonResponse('success', 'Thông tin sản phẩm', $result)
            : jsonResponse('error', 'Không tìm thấy sản phẩm!', []);
    }


    public function update(UpdateProductRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image');
        $result = $this->productService->update($data);

        return $result['status'] === 'success'
            ? jsonResponse('success', $result['message'])
            : jsonResponse('error', $result['message']);
    }



    public function destroy(DeleteProductRequest $request)
    {
        $data = $request->validated();
        $result = $this->productService->delete($data['id']);

        return $result
            ? jsonResponse('success', 'Xóa sản phẩm thành công!')
            : jsonResponse('error', 'Xóa sản phẩm thất bại!');
    }


    public function addColor(StoreProductColorRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image_url');
        $result = $this->productService->addColor($data);

        return $result['status'] === 'success'
            ? jsonResponse('success', $result['message'])
            : jsonResponse('error', $result['message']);
    }

    // Xóa nhiều sản phẩm
    public function deleteProducts(Request $request)
    {
        $idToDelete = $request->input('ids');
        $result = $this->productService->deleteProducts($idToDelete);
        return $result
            ? jsonResponse('success', 'Xóa thành công', $result)
            : jsonResponse('error', 'Xóa thất bại', $result);
    }

    // Xóa màu sản phẩm 
    public function deleteProductColor(DeleteProductColorRequest $request)
    {
        $data = $request->validated();
        $result = $this->productService->deleteColor($data['id']);
        return $result['status'] === 'success'
            ? jsonResponse('success', $result['message'])
            : jsonResponse('error', $result['message']);
    }


    public function getProductsByCategory()
    {
        $categoryName = request()->query('category');

        if (!$categoryName) {
            return response()->json(['message' => 'Vui lòng cung cấp tên danh mục'], 400);
        }

        $result = $this->productService->getProductsByCategory($categoryName);
        return $result
            ? jsonResponse('success', 'Danh sách sản phẩm theo danh mục', $result)
            : jsonResponse('error', 'Không tìm thấy sản phẩm nào trong danh mục: ' . $categoryName, []);
    }

    // Review
    /**
     * Lưu đánh giá sản phẩm.
     *
     * Phương thức này nhận yêu cầu chứa thông tin đánh giá sản phẩm từ người dùng, 
     * kiểm tra và xác thực dữ liệu đầu vào bằng lớp `StoreReviewRequest`, sau đó 
     * chuyển dữ liệu đã xác thực cho `ProductService` để lưu đánh giá.
     *
     * @param StoreReviewRequest $request Yêu cầu chứa dữ liệu đánh giá.
     * @return \Illuminate\Http\JsonResponse Trả về phản hồi dạng JSON thông báo kết quả.
     */
    public function storeProductReview(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $result = $this->productService->storeReview($data);
        return jsonResponse($result ? 'success' : 'error');
    }
    /**
     * Lấy danh sách các đánh giá sản phẩm.
     *
     * Phương thức này nhận yêu cầu và chuyển nó đến `ProductService` để lấy danh sách 
     * đánh giá sản phẩm từ cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request Yêu cầu từ người dùng.
     * @return \Illuminate\Http\JsonResponse Trả về phản hồi dạng JSON chứa danh sách đánh giá hoặc thông báo lỗi.
     */
    public function getReviews(Request $request)
    {
        $result = $this->productService->getReviews($request);
        return jsonResponse($result ? 'success' : 'error',  $result ? 'Lấy đánh giá thành công!' : 'Lấy đánh giá thất bại!', $result);
    }
    /**
     * Lấy danh sách đánh giá theo ID sản phẩm.
     *
     * Phương thức này nhận ID sản phẩm và lấy các đánh giá liên quan đến sản phẩm đó
     * thông qua `ProductService`.
     *
     * @param int $id ID của sản phẩm.
     * @return \Illuminate\Http\JsonResponse Trả về phản hồi dạng JSON chứa đánh giá sản phẩm hoặc thông báo lỗi.
     */
    public function getReviewByProduct($id)
    {
        $result = $this->productService->getReviewByProductId($id);
        return jsonResponse($result ? 'success' : 'error', $result ? 'Lấy đánh giá thành công!' : 'Lấy đánh giá thất bại!', $result);
    }
    /**
     * Lấy toàn bộ đánh giá sản phẩm.
     *
     * Phương thức này trả về toàn bộ các đánh giá sản phẩm hiện có thông qua `ProductService`.
     *
     * @return \Illuminate\Http\JsonResponse Trả về phản hồi dạng JSON chứa tất cả đánh giá hoặc thông báo lỗi.
     */
    public function getReviewsAll()
    {
        $result = $this->productService->getReviewsAll();
        return jsonResponse($result ? 'success' : 'error', $result ? 'Lấy đánh giá thành công!' : 'Lấy đánh giá thất bại!', $result);
    }
}

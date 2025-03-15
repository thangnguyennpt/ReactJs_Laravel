<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Brand;

class ProductController extends Controller
{
    const IMAGE_DIR = 'images/img/';

    public function index(Request $request)
    {
        $perPage = 6;

        $list = Product::where('status', '!=', 0)
            ->select("id", "image", "name", "detail", "description", "price", "slug", "status", "category_id", "brand_id")
            ->with(['category:id,name', 'brand:id,name'])
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        $products = $list->items();

        foreach ($products as &$product) {
            if ($product->image) {
                $product->image = asset(self::IMAGE_DIR . $product->image);
            }
            // Rest of your code...
        }

        return response()->json([
            'success' => true,
            'data' => $products,
            'current_page' => $list->currentPage(),
            'last_page' => $list->lastPage(),
        ]);
    }

    public function store(Request $request)
    {
        // Add a new product
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->slug = Str::of($request->name)->slug('-');
        $product->detail = $request->detail;

        // Handle image upload
        if ($request->hasFile('image')) {
            $exten = $request->file("image")->extension();
            if (in_array($exten, ["jpg", "png", "gif", "webp"])) {
                $filename = $product->slug . "." . $exten;
                $request->image->move(public_path(self::IMAGE_DIR), $filename);
                $product->image = $filename; // Store only the filename
            }
        }

        // Save product information
        $product->status = $request->status;
        $product->price = $request->price;
        $product->pricesale = $request->pricesale;
        $product->created_at = now();
        $product->created_by = Auth::id() ?? 1;
        $product->updated_at = now();
        $product->updated_by = Auth::id() ?? 1;
        $product->save();

        // Save stock information to the Stock table
        if ($request->has('size') && $request->has('color') && $request->has('quantity')) {
            Stock::create([
                'product_id' => $product->id,
                'size' => $request->size,
                'color' => $request->color,
                'quantity' => $request->quantity,
            ]);
        }

        // Return the newly created product with the full image URL
        $product->image = asset(self::IMAGE_DIR . $product->image);

        return response()->json($product, 201);
    }

    public function show($slug)
    {
        // Find the product by slug and ensure the product is active (status = 1)
        $product = Product::where('slug', $slug)->where('status', 1)->first();

        // Check if the product was found
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Append full image URL
        if ($product->image) {
            $product->image = asset(self::IMAGE_DIR . $product->image);
        }

        // Get related products by category
        $listcaid = $this->getlistcategoryid($product->category_id);
        $relatedProducts = Product::where('status', 1)
            ->where('id', '!=', $product->id)
            ->whereIn('category_id', $listcaid)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                if ($item->image) {
                    $item->image = asset(self::IMAGE_DIR . $item->image);
                }
                return $item;
            });

        return response()->json([
            'success' => true,
            'product' => $product,
            'related_products' => $relatedProducts,
        ]);
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'brand', 'stock'])->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Append full image URL
        if ($product->image) {
            $product->image = asset(self::IMAGE_DIR . $product->image);
        }

        return response()->json(['success' => true, 'product' => $product], 200);
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
    
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'brand_id' => 'required|exists:brands,id', // Ensure brand exists
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,gif,webp|max:2048', // Validate image
        ]);
    
        // Update product fields
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->category_id = $validatedData['category_id'];
        $product->brand_id = $validatedData['brand_id'];
        $product->slug = Str::of($validatedData['name'])->slug('-');
        $product->detail = $validatedData['details'];
    
        // Handle image upload if a new file is provided
        if ($request->hasFile('image')) {
            $exten = $request->file("image")->extension();
            $filename = $product->slug . "." . $exten;
            $request->image->move(public_path(self::IMAGE_DIR), $filename);
            $product->image = $filename;
        }
    
        $product->save();
    
        return response()->json(['success' => true, 'data' => $product]);
    }
    

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Xóa sản phẩm
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully'], 200);
    }

    public function productCountByCategory()
    {
        // Lấy số lượng sản phẩm theo từng danh mục
        $categories = Category::withCount('products')->get();

        $data = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'count' => $category->products_count,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function productCountByBrand()
    {
        // Lấy số lượng sản phẩm theo từng thương hiệu
        $brands = Brand::withCount('products')->get();

        $data = $brands->map(function ($brand) {
            return [
                'name' => $brand->name,
                'count' => $brand->products_count,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

}
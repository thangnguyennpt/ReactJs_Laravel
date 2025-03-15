<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;

class SanphamController extends Controller
{
    const IMAGE_DIR = 'images/img/';

    public function index()
    {
        $list_menu = Menu::where('status', '!=', 0)->get();
        $list_product = Product::where('status', 1)
            ->select("id", "image", "name", "detail", "description", "price", "slug") // Đảm bảo có trường 'slug'
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $products = $list_product->items();

        foreach ($products as &$product) {
            if ($product->image) {
                $product->image = asset(self::IMAGE_DIR . $product->image);
            }
            // Rest of your code...
        }

        return response()->json([
            'success' => true,
            'data' => $products,
            'list_menu' => $list_menu,
            'list_product' => $list_product,
        ]);
    }


    public function product_detail($slug)
    {
        $product = Product::with(['stocks' => function($query) {
            $query->where('quantity', '>', 0); // Chỉ lấy các stock còn hàng
        }])
        ->where('status', 1)
        ->where('slug', $slug)
        ->first();
    
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


    public function category($slug)
    {
        $row = Category::where([['slug', $slug], ['status', 1]])
            ->select("id", "name", "image", "slug")
            ->first();

        if (!$row) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $listcaid = $this->getlistcategoryid($row->id);

        $list_product = Product::where('status', 1)
            ->whereIn("category_id", $listcaid)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        // Append full image URLs
        $products = $list_product->items();
        foreach ($products as &$product) {
            if ($product->image) {
                $product->image = asset(self::IMAGE_DIR . $product->image);
            }
        }

        return response()->json([
            'success' => true,
            'category' => $row,
            'list_product' => $list_product,
        ]);
    }

    public function brand($slug)
    {
        $row = Brand::where([['slug', $slug], ['status', 1]])
            ->select("id", "name", "slug")
            ->first();

        if (!$row) {
            return response()->json(['success' => false, 'message' => 'Brand not found'], 404);
        }

        $listbraid = $this->getlistbrandid($row->id);

        $list_product = Product::where('status', 1)
            ->whereIn("brand_id", $listbraid)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        // Append full image URLs
        $products = $list_product->items();
        foreach ($products as &$product) {
            if ($product->image) {
                $product->image = asset(self::IMAGE_DIR . $product->image);
            }
        }

        return response()->json([
            'success' => true,
            'brand' => $row,
            'list_product' => $list_product,
        ]);
    }

    private function getlistcategoryid($rowid)
    {
        $listcaid = [$rowid];

        $list1 = Category::where([['parent_id', $rowid], ['status', 1]])
            ->pluck("id")
            ->toArray();

        if (!empty($list1)) {
            $listcaid = array_merge($listcaid, $list1);
            foreach ($list1 as $id1) {
                $list2 = Category::where([['parent_id', $id1], ['status', 1]])
                    ->pluck("id")
                    ->toArray();
                $listcaid = array_merge($listcaid, $list2);
            }
        }

        return $listcaid;
    }

    private function getlistbrandid($rowid)
    {
        return [$rowid];
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'No search query provided'], 400);
        }
    
        $list_product = Product::where('status', 1)
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate(9);
    
        $products = $list_product->items();
        foreach ($products as &$product) {
            if ($product->image) {
                $product->image = asset(self::IMAGE_DIR . $product->image);
            }
        }
    
        return response()->json([
            'success' => true,
            'data' => $products,
            'list_product' => $list_product,
        ]);
    }    

}
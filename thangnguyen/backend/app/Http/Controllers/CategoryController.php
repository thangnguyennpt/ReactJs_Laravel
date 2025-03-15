<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class CategoryController extends Controller
{
    const IMAGE_DIR = 'images/category/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Category::where('status', '!=', 0)
            ->select("id", "image", "name", "slug", "sort_order", "status", "description")
            ->orderBy('created_at', 'DESC')
            ->get();
            
            foreach ($list as &$category) {
                if ($category->image) {
                    $category->image = asset(self::IMAGE_DIR . $category->image);
                }
                // Rest of your code...
            }
            
        return response()->json([
            'success' => true,
            'data' => $list,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $list = Menu::where('status', '!=', 0)
            ->select("id", "name", "link", "type", "position", "table_id", "parent_id")
            ->orderBy('created_at', 'DESC')
            ->get();

        $list_brand = Brand::where('status', '!=', 0)
            ->select("id", "name", "slug")
            ->orderBy('created_at', 'DESC')
            ->get();

        $list_category = Category::where('status', '!=', 0)
            ->select("id", "name", "slug")
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'list' => $list,
            'list_brand' => $list_brand,
            'list_category' => $list_category
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index()
    {
        $list = Brand::where('status', '!=', 0)
            ->select("id", "image", "name", "status", "description", "slug")
            ->orderBy('created_at', 'DESC')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $list,
        ]);
    }

    public function store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::of($request->name)->slug('-');
        $brand->description = $request->description;
        $brand->sort_order = $request->sort_order;
    
        if ($request->hasFile('image')) {
            $exten = $request->file("image")->extension();
            if (in_array($exten, ["jpg", "png", "gif", "webp"])) {
                $filename = $brand->slug . "." . $exten;
                $request->image->move(public_path('images/brands'), $filename);
                $brand->image = $filename;
            }
        }
    
        $brand->status = $request->status === 'active' ? 1 : 0;
        $brand->created_at = now(); // Use Laravel's helper
        $brand->created_by = Auth::id() ?? 1;
        $brand->save();
    
        return response()->json([
            'message' => 'Brand created successfully',
            'brand' => $brand
        ], 201); // 201 Created
    }    

    public function edit(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        return response()->json(['brand' => $brand], 200);
    }

    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $brand->name = $request->name;
        $brand->slug = Str::of($request->name)->slug('-');
        $brand->description = $request->description;
        $brand->sort_order = $request->sort_order;

        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ["png", "jpg", "jpeg", "gif", "webp"])) {
                $filename = $brand->slug . "." . $exten;
                $request->image->move(public_path('images/img'), $filename);
                $brand->image = $filename;
            }
        }

        $brand->status = $request->status === 'active' ? 1 : 0;
        $brand->updated_at = now(); // Laravel helper for current date/time
        $brand->updated_by = Auth::id() ?? 1;
        $brand->save();

        return response()->json(['message' => 'Successfully updated'], 200);
    }


    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }
        $brand->status = 0;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = Auth::id() ?? 1;
        $brand->save();
        return response()->json(null, 204);
    }

}
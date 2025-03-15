<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $productSlug)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $product = Product::where('slug', $productSlug)->firstOrFail();

        $comment = Comments::create([
            'product_id' => $product->id,
            'content' => $request->content,
        ]);

        return response()->json(['success' => true, 'comment' => $comment], 201);
    }

    public function index($productSlug)
    {
        $product = Product::where('slug', $productSlug)->firstOrFail();
        $comments = $product->comments; // Lấy bình luận liên quan đến sản phẩm

        return response()->json(['success' => true, 'comments' => $comments]);
    }

}
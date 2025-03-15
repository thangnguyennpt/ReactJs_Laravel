<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{

    public function index()
    {
        $list_cart = session('carts', []);
        return response()->json($list_cart, 200);
    }

    public function addcart($id, Request $request)
    {
        $productid = $id;
        $qty = $request->input('qty');
        $product = Product::find($productid);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.'], 404);
        }
        $cartitem = [
            'id' => $productid,
            'name' => $product->name,
            'image' => $product->image,
            'price' => ($product->pricesale) > 0 ? $product->pricesale : $product->price,
            'qty' => $qty,
        ];
        $carts = session('carts', []);
        $found = false;
        foreach ($carts as &$cart) {
            if ($cart['id'] == $productid) {
                $cart['qty'] += $qty;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $carts[] = $cartitem;
        }
        session(['carts' => $carts]);
        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng.', 'cart_count' => count($carts)]);
    }

    public function updateQuantity(Request $request)
    {
        $productid = $request->input('id');
        $qty = $request->input('qty');

        $carts = session('carts', []);

        foreach ($carts as &$cart) {
            if ($cart['id'] == $productid) {
                $cart['qty'] = $qty; // Update quantity
                break;
            }
        }

        session(['carts' => $carts]);
        return response()->json(['success' => true, 'message' => 'Cập nhật số lượng thành công.']);
    }

    public function removeItem($id)
    {
        $carts = session('carts', []);

        // Filter out the item with the specified id
        $carts = array_filter($carts, function ($cart) use ($id) {
            return $cart['id'] != $id;
        });

        session(['carts' => $carts]); // Update session
        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
    }

}
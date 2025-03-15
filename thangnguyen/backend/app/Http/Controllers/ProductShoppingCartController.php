<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductShoppingCartController extends Controller
{

    const IMAGE_DIR = 'images/img/';
    const DEFAULT_IMAGE = 'images/default.jpg'; // Đường dẫn ảnh mặc định

    public function index(Request $request) {

        $user = JWTAuth::parseToken()->authenticate();

        $cartList = $user->cartItems()
                ->with(['stock.product' => function($query) {
                    // Sử dụng default image nếu không có ảnh sản phẩm
                    $query->select('*')->get()->map(function($product) {
                        if ($product->image) {
                            $product->image = asset(self::IMAGE_DIR . $product->image);
                        } else {
                            $product->image = asset(self::DEFAULT_IMAGE); // Đường dẫn đến ảnh mặc định
                        }
                        return $product;
                    });
                }])
                ->orderBy('id', 'desc')
                ->get();

        return $cartList;
    }

    public function store(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
    
        if ($request->has('localCartList')) {
            $cartList = json_decode($request->localCartList, true);
    
            if (is_array($cartList)) {
                foreach ($cartList as $cartArrayList) {
                    foreach ($cartArrayList as $cartItem) {
                        $item = $user->cartItems()->where('stock_id', $cartItem['stock_id'])->first();
    
                        if (!$item) {
                            ShoppingCart::create([
                                'user_id' => $user->id,
                                'stock_id' => $cartItem['stock_id'],
                                'quantity' => $cartItem['quantity']
                            ]);
                        }
                    }
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid cart list format.'], 400);
            }
    
        } else {
            $item = $user->cartItems()->where('stock_id', $request->stockId)->first();
    
            if (!$item) {
                ShoppingCart::create([
                    'user_id' => $user->id,
                    'stock_id' => $request->stockId,
                    'quantity' => $request->quantity
                ]);
            } else {
                $stock = Stock::findOrFail($request->stockId);
    
                if (($item->quantity + $request->quantity) <= $stock->quantity) {
                    $item->increment('quantity', $request->quantity);
                } else {
                    $item->update(['quantity' => $stock->quantity]);
                }
            }
    
            return response()->json(['success' => true, 'message' => 'Product added to cart successfully.']);
        }
    }
    

    public function guestCart(Request $request) {

        $cartList = json_decode($request['cartList'], true);

        $data = [];
        $count = 1;
        foreach( $cartList as $cartArrayList) {
            foreach($cartArrayList as $cartItem) {
                if( $cartItem['stock_id'] != null || $cartItem['quantity'] != null) {

                    $stock = null;
                    if($cartItem['stock_id'] != null) {
                        $stock = Stock::with('product')->where('id', $cartItem['stock_id'])->first();
                    }

                    $data[] = ['id' => $count, 'stock_id' => $cartItem['stock_id'], 'quantity' => $cartItem['quantity'], 'stock' => $stock];
                    $count++;
                }
            }
        }

        return $data;
    }

    public function update(Request $request, $id) {

        $cartItem = ShoppingCart::with('stock')->where('id', $id)->get();

        $stockQty = $cartItem->pluck('stock.quantity')->pop();

        if($request->quantity <= $stockQty && $request->quantity > 0)
            ShoppingCart::where('id', $id)->update(['quantity' => $request->quantity]);
    }

    public function destroy($id) {
        $user = JWTAuth::parseToken()->authenticate();
    
        $cartItem = $user->cartItems()->find($id);
    
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true, 'message' => 'Cart item removed successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
        }
    }
    


    public function cartCount(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        return $user->cartItems()->pluck('stock_id')->toArray();
    }
}
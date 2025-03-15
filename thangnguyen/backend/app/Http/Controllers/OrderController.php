<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Get the order history for the authenticated user.
     */
    public function history(Request $request)
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->with(['address', 'stock.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedOrders = $orders->map(function ($order) {
            $total = 0;
            $items = [];

            // Kiểm tra xem order có liên kết với stock và product không
            if ($order->stock && $order->stock->product) {
                $stock = $order->stock;
                $product = $stock->product;
                
                // Tính giá: ưu tiên giá khuyến mãi nếu có
                $price = $product->pricesale > 0 ? $product->pricesale : $product->price;
                
                // Tính tổng cho sản phẩm này
                $itemTotal = $price * $order->quantity;
                $total += $itemTotal;

                $items[] = [
                    'product_name' => $product->name,
                    'size' => $stock->size,
                    'color' => $stock->color,
                    'quantity' => $order->quantity,
                    'price' => $price,
                    'subtotal' => $itemTotal
                ];
            }

            return [
                'id' => $order->id,
                'status' => $order->status,
                'total' => $total,
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                'address' => $order->address,
                'items' => $items,
            ];
        });

        return response()->json(['orders' => $formattedOrders], 200);
    }

    // Other CRUD functions (index, create, store, show, edit, update, destroy)
}
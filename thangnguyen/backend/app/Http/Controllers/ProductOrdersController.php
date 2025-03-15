<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Stripe;
use App\Models\Order;
use App\Models\Stock;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

Stripe\Stripe::setApiKey(config('values.STRIPE_SECRET'));

class ProductOrdersController extends Controller
{
    function calculateOrderAmount(array $items): int
    {
        $price = 0;
        $checkoutItems = [];

        foreach ($items as $item) {
            if ($item['quantity'] > 0) {
                $checkoutItems[] = ['stock_id' => $item['stock_id'], 'quantity' => $item['quantity']];
            } else {
                abort(500);
            }
        }

        $user = JWTAuth::parseToken()->authenticate();
        $cartList = $user->cartItems()->with('stock.product')->get();

        foreach ($cartList as $cartItem) {
            foreach ($checkoutItems as $checkoutItem) {
                if ($cartItem->stock_id == $checkoutItem['stock_id']) {
                    $price += $cartItem->stock->product->price * $checkoutItem['quantity'];
                }
            }
        }

        return $price * 100;
    }

    public function store(Request $request)
    {
        // Thêm validation để đảm bảo các trường bắt buộc được cung cấp
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.stock_id' => 'required|integer|exists:stocks,id',
            'items.*.quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:1000',
            // 'status' => 'required|string|max:50', // Loại bỏ nếu không cần nhận status từ client
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Xác thực người dùng
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Lấy ghi chú và thiết lập status mặc định
        $note = $request->input('note', '');
        $status = 'pending'; // Thiết lập mặc định

        // Bắt đầu giao dịch
        DB::beginTransaction();

        try {
            foreach ($request->items as $item) {
                $stock_id = $item['stock_id'];
                $quantity = $item['quantity'];

                // Kiểm tra sản phẩm tồn tại và đủ số lượng
                $stock = Stock::findOrFail($stock_id);
                if ($stock->quantity < $quantity) {
                    // Nếu số lượng không đủ, ném ngoại lệ để hoàn nguyên giao dịch
                    throw new \Exception("Insufficient stock for product ID: {$stock_id}");
                }

                // Tạo đơn hàng với status mặc định là 'pending'
                Order::create([
                    'user_id'  => $user->id,
                    'stock_id' => $stock_id,
                    'quantity' => $quantity,
                    'note'     => $note,
                    'status'   => $status,
                ]);

                // Giảm số lượng sản phẩm trong kho
                $stock->decrement('quantity', $quantity);

                // Xóa sản phẩm khỏi giỏ hàng của người dùng
                $user->cartItems()->where('stock_id', $stock_id)->delete();
            }

            // Hoàn tất giao dịch
            DB::commit();

            return response()->json(['message' => 'Order placed successfully'], 200);
        } catch (\Exception $e) {
            // Hoàn nguyên giao dịch trong trường hợp có lỗi
            DB::rollBack();

            // Trả về phản hồi lỗi
            return response()->json(['message' => 'Order failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function placeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'note' => 'nullable|string',
            'payment_method' => 'required|string',
            'status' => 'required|string',
            'address.firstname' => 'required|string', // Cách xác thực đúng cho trường con
            'address.lastname' => 'required|string',
            'address.address' => 'required|string',
            'address.city' => 'required|string',
            'address.country' => 'required|string',
            'address.zip' => 'required|string',
            'address.telephone' => 'required|string',
        ]);

        $products = []; // Tạo mảng để lưu thông tin sản phẩm

        foreach ($validatedData['items'] as $item) {
            if (!isset($item['stock_id'])) {
                return response()->json(['error' => 'Stock ID is required for each item.'], 400);
            }

            $stock = Stock::findOrFail($item['stock_id']); // Lấy thông tin kho

            // Thêm thông tin sản phẩm vào mảng
            $products[] = [
                'stock_id' => $stock->id,
                'quantity' => $item['quantity'],
                'note' => $validatedData['note'],
                'status' => $validatedData['status'],
            ];
        }
        $address = Address::create([
            'user_id' => $validatedData['user_id'],
            'firstname' => $validatedData['address']['firstname'],
            'lastname' => $validatedData['address']['lastname'],
            'address' => $validatedData['address']['address'],
            'city' => $validatedData['address']['city'],
            'country' => $validatedData['address']['country'],
            'zip' => $validatedData['address']['zip'],
            'telephone' => $validatedData['address']['telephone'],
        ]);
        // Lưu thông tin đơn hàng cho từng sản phẩm
        foreach ($products as $product) {
            Order::create([
                'user_id' => $validatedData['user_id'],
                'stock_id' => $product['stock_id'],
                'quantity' => $product['quantity'],
                'note' => $product['note'],
                'status' => $product['status'],
                // Thêm các trường khác nếu cần
            ]);
        }

        return response()->json(['message' => 'Order placed successfully!'], 201);
    }
}
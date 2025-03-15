<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Address;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
class UserAddressController extends Controller{
    public function createUser(Request $request){
         // Add validation to ensure required fields are provided
            $validator = Validator::make($request->all(), [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'city' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'zip' => 'required|string|max:20',
                'telephone' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
        $user=User::create([
            'name' => $request->firstName .' '. $request->lastName,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);
        $address=Address::create([
            'user_id' => $user->id,
            'firstname' => $request->firstName,
            'lastname' => $request->lastName,
            'city' =>$request->city,
            'country' => $request->country,
            'zip' => $request->zip,
            'telephone' => $request->telephone,
        ]);
        if($request->localCartList){
            $cartList=json_decode($request->localCartList,true);
            foreach($cartList as $cartArrayList){
                foreach($cartArrayList as $cartItem){
                    $item=$user->cartItems()->where('stock_id',$cartItem['stock_id'])->first();
                    if(!$item){
                        ShoppingCart::create([
                            'user_id' => $user->id,
                           'stock_id' => $cartItem['stock_id'],
                           'quantity' => $cartItem['quantity'],
                        ]);
                    }
                }
            }
        }
        $user->update(['address_id' => $address->id]);
        $token=JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }
    public function show(){
        $user=JWTAuth::parseToken()->authenticate();// sửa authenticated thành authenticate vì trong phiên bản mới authenticated không tồn tại
        return $user->addresses()->where('id',$user->address_id)->first();
    }
    public function store(Request $request){
        $user=JWTAuth::parseToken()->authenticated();
        $address=Address::create([
            'user_id' => $user->id,
            'firstname' => $request->firstName,
            'lastname' => $request->lastName,
            'city' =>$request->city,
            'country' => $request->country,
            'zip' => $request->zip,
            'telephone' => $request->telephone,
        ]);
        $user->update(['address_id' => $address->id]);
    }
}
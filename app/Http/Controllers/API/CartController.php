<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Promo_code;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_detail;
use Illuminate\Support\Facades\Hash;
use App\Core\ReturnMessage;
use App\Repository\Order\OrderRepositoryInterface;
use App\Repository\Order_detail\OrderDetailRepositoryInterface;
use App\Http\Requests\RequestAddToCartRequest;
use App\Http\Requests\RequestCheckoutRequest;

class CartController extends Controller
{ 
    private $repo;
    private $repo_detail;

    public function __construct(OrderRepositoryInterface $repo, OrderDetailRepositoryInterface $repo_detail)
    {
        $this->repo        = $repo;
        $this->repo_detail = $repo_detail;
    }

    public function addToCart(RequestAddToCartRequest $request)
    {
        
        $user_id    = $request->get('user_id');
        $qty        = $request->get('qty');
        $product_id = $request->get('product_id');
        $price      = Product::where('id',$product_id)->value('sale_price');
        
        $cartCheck = Order::where('user_id',$user_id)->where('status',0)->first();
        
        if($cartCheck){
            $id = $cartCheck->id;
            
            $order = Order::find($id);
            $order->user_id    = $user_id;
            $order->total_qty  = $order->total_qty + $qty;
            $order->cart_total = $order->cart_total + ($qty * $price);
            
            $order_detail = new Order_detail();
            $order_detail->order_id   = $id;
            $order_detail->product_id = $product_id;
            $order_detail->price      = $price;
            $order_detail->qty        = $qty;
            $order_detail->total      = $qty * $price;
            $order_detail->created_by = $user_id;

            $order_result = $this->repo->update($order);
            $order_detail_result = $this->repo_detail->create($order_detail);

            if($order_result['laravelStatusCode'] ==  ReturnMessage::OK && $order_detail_result['laravelStatusCode'] ==  ReturnMessage::OK){
    
                return response(['errorCode'=>'0','message'=>'Success','order' => $order, 'order_detail' => $order_detail], 201);
            }
            else{
                return response(['errorCode'=>'400','message' => "Failed in ordering"], ReturnMessage::BAD_REQUEST);
            }
        }
        else{
            $date = date("Y-m-d");
            
            $max_id = Order::orderBy('id', 'desc')->value('id');
            if($max_id){
                $last_id_count = $max_id + 1;
            }
            else{
                $last_id_count = 1;
            }

            $id_length = strlen($last_id_count);
            $id_total_length = 6 - $id_length;
            $last_order_id = str_replace("-", "", $date);
            for ($a = 0; $a < $id_total_length; $a++) {
                $last_order_id .= '0';
            }
            $last_order_id .= $last_id_count;

            //Creating Order
            $order = new Order();
            $order->invoice_id = $last_order_id;
            $order->order_date = $date;
            $order->user_id    = $user_id;
            $order->total_qty  = $qty;
            $order->cart_total = $qty * $price;
            $order->status     = 0; // 0 for adding
            $order->created_by = $user_id;
            
            //Creating Order Detail
            $order_detail = new Order_detail();
            $order_detail->order_id   = $last_id_count;
            $order_detail->product_id = $product_id;
            $order_detail->price      = $price;
            $order_detail->qty        = $qty;
            $order_detail->total      = $qty * $price;
            $order_detail->created_by = $user_id;

            $order_result = $this->repo->create($order);
            $order_detail_result = $this->repo_detail->create($order_detail);


            if($order_result['laravelStatusCode'] ==  ReturnMessage::OK && $order_detail_result['laravelStatusCode'] ==  ReturnMessage::OK){
    
                return response(['statusCode'=>'201','message'=>'Success','order' => $order, 'order_detail' => $order_detail], ReturnMessage::CREATED);
            }
            else{
                return response(['statusCode'=>'400','message' => "Failed in ordering"], ReturnMessage::BAD_REQUEST);
            }
        }
        
    }

    public function checkout(RequestCheckoutRequest $request)
    {
        
        $user_id               = $request->get('user_id');
        $customer_name = User::where('id',$user_id)->value('name');
        $delivery_address = User::where('id',$user_id)->value('address');
        $phone = User::where('id',$user_id)->value('phone');
        $email = User::where('id',$user_id)->value('email');
        $transaction_id        = $request->get('transaction_id');
        $payment_ss            = $request->get('payment_ss');
        $promo_code            = $request->get('promo_code');


        $cartCheck = Order::where('user_id',$user_id)->where('status',0)->first();

        if($cartCheck){
            $discountCheck = Promo_code::where('user_id', $user_id)->where('code', $promo_code)->where('end_date','>',date('Y-m-d'))->value('id');
            
            if($discountCheck && $discountCheck > 0){
                $discount = 1000;
            }
            else{
                $discount = 0;
            }
            
            $image = $request->file('payment_ss');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $image_file = "/images/" . $new_name;
            
            $id = $cartCheck->id;
            
            $order = Order::find($id);
            $gst = $order->cart_total * 7 / 100;
            $order->user_id           = $user_id;
            $order->customer_name     = $customer_name;
            $order->delivery_address  = $delivery_address;
            $order->phone             = $phone;
            $order->email             = $email;
            $order->transaction_id    = $transaction_id;
            $order->payment_ss        = $image_file;
            $order->status            = 1; // 1 for finished
            $order->final_cost        = $order->cart_total + $gst - $discount;
            $order->discount          = $discount;

            $order_result = $this->repo->update($order);

            if($order_result['laravelStatusCode'] ==  ReturnMessage::OK){
                return response(['statusCode'=>'201','message'=>'Success','order' => $order], ReturnMessage::CREATED);
            }
            else{
                return response(['statusCode'=>'400','message' => "Failed while checkout"], ReturnMessage::BAD_REQUEST);
            }

        }
        else{
            return response(['statusCode'=>'400','message' => "Cart not found"], ReturnMessage::BAD_REQUEST);
        }
    }
}
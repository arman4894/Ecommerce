<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Cart;
use App\Mail\Sendemail;
use App\Mail\Sendmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Product $product){
        if(session()->has('cart')){
           $cart = new Cart(session()->get('cart'));
        } else{
            $cart = new Cart();
        }
        $cart->add($product);
        
        session()->put('cart',$cart);
        notify()->success('Product Add to cart');
        return redirect()->back();
    }

    public function showCart(){
    
            if(session()->has('cart')){
                $cart = new Cart(session()->get('cart'));
             } else{
                 $cart = null;
             }
        
        
        return view('cart',compact('cart'));
    }

    public function updateCart(Request $request , Product $product){
        $request->validate([
            'qty'=>'required|numeric|min:1'
        ]);
        $cart = new Cart(session()->get('cart'));
        $cart->updateQty($product->id,$request->qty);
        session()->put('cart',$cart);
        notify()->success('updated Add to cart');
        return redirect()->back();
    }

    public function removeCart(Product $product){
        
        $cart = new Cart(session()->get('cart'));
        $cart->remove($product->id);
        if($cart->totalQty<=0){
            session()->forget('cart');
        }else{
            session()->put('cart',$cart);
           
        }
        notify()->success('updated Add to cart');
        return redirect()->back();
    }

    public function checkout($amount){
        if(session()->has('cart')){
            $cart = new Cart(session()->get('cart'));
         } else{
             $cart = null;
         }
    return view('checkout',compact('amount','cart'));
    }
    

public function charge(Request $request){
    
    $validator = Validator::make($request->all(),[
        'card_number'=>'required',
        'exp_month'=>'required',
        'exp_year'=>'required',
        'cvc'=>'required'
    ]);

    
    if (!session()->has('cart')) {
        return redirect()->route('cart');
    }
    $oldCart = session()->get('cart');
    $cart = new Cart($oldCart);
    
    $input = $request->all();
   
    if($validator->passes()){
       
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        
        try{
            $charge = null;
            $token = $stripe->tokens->create([
                'card'=> [
                    'number'=>$request->get('card_number'),
                    'exp_month'=>$request->get('exp_month'),
                    'exp_year'=>$request->get('exp_year'),
                    'cvc'=>$request->get('cvc')
                ],
            ]);
           
       \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

          $charge = $stripe->charges->create([
                
                'amount' => $request->amount*100,
                'currency' => 'INR',
                'source' =>$token->id,
                'description' => 'My First Test Charge',
            ]);
            
            $chargeId = $charge['id'];
            // if(session()->has('cart')){
            //     $cart = new Cart(session()->get('cart'));
            // }else{
            //     $cart = null;
            // } 
            Mail::to(auth()->user()->email)->send(new Sendmail($cart));

            if($chargeId){
                $order = new Order();
                $order->cart = serialize($cart);
                $order->user_id = auth()->user()->id;
        
                Auth::user()->orders()->save($order);
                
                session()->forget('cart');

                notify()->success(' Transaction completed!');
               
                return redirect()->to('/');
               
    
            }else{
                return redirect()->back();
            }
             
       
           
        } catch (\Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
        }
    }
}

//for loggedIn user
public function order(){

    $orders = auth()->user()->orders;
    $carts = $orders->transform(function($cart,$key){
        return unserialize($cart->cart);
    });

    return view('order',compact('carts'));
}

//for Admin
public function userOrder(){
    $orders = Order::latest()->get();
    return view ('admin.order.index',compact('orders'));
}

public function viewUserOrder($userid,$orderid){
    
    $user = User::find($userid);
    $orders = $user->orders->where('id',$orderid);
    $carts = $orders->transform(function($cart,$key){
        return unserialize($cart->cart);
    });
    return view('admin.order.show',compact('carts'));
}

}
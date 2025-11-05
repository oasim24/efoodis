<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Osinfo;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function addToCart(Request $request)
{
    $product_id = $request->id;
    $name = $request->name;
    $price = $request->price;
    $image = $request->image;
    $quantity = (int) ($request->quantity );

    $cart = session()->get('cart', []);

    if (isset($cart[$product_id])) {
        $cart[$product_id]['quantity'] += $quantity;
    } else {
       
        $cart[$product_id] = [
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'image' => $image,
        ];
    }

   
    session()->put('cart', $cart);

    return response()->json([
        'status' => true,
        'message' => 'Product added to cart successfully!',
        'cart_count' => count($cart)
    ]);
}


   
    public function orderNow(Request $request)
{
    $product_id = $request->id;
    $name = $request->name;
    $price = $request->price;
    $image = $request->image;
    $quantity = $request->quantity ?? 1;

   
    $cart = session()->get('cart', []);

  
    if (isset($cart[$product_id])) {
        
        return response()->json([
            'status' => true,
            'message' => 'Product already in cart. Redirecting to checkout...',
            'redirect_url' => route('checkout')
        ]);
    }

   
    $cart[$product_id] = [
        'name' => $name,
        'quantity' => $quantity,
        'price' => $price,
        'image' => $image
    ];

   
    session()->put('cart', $cart);

   
    return response()->json([
        'status' => true,
        'message' => 'Product added and redirecting to checkout...',
        'redirect_url' => route('checkout')
    ]);
}


  
    public function checkout()
    {
        $cart = session()->get('cart', []);
$dhakaCharge = Osinfo::where('type', 'indhaka')->value('value'); 
$outDhakaCharge = Osinfo::where('type', 'outdhaka')->value('value'); 


$delivaries = [
    $dhakaCharge => 'In Side Of Dhaka ' . $dhakaCharge . ' Bdt',
    $outDhakaCharge => 'Out Side Of Dhaka ' .$outDhakaCharge . ' Bdt'
];
$selecteddlivaries = $dhakaCharge;
$payments = [
    'Cash-on-delivary' => 'Cash On Delivery',
    'Bkash' => 'BKash',
];
$selectedPayment = 1;
        return view('frontend.page.checkout', compact('cart', 'selecteddlivaries', 'delivaries', 'payments' , 'selectedPayment'));
    }




public function remove(Request $request)
{
    $id = $request->id;
    $cart = session()->get('cart', []);

    if(isset($cart[$id])){
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

  
    $total = collect($cart)->sum(function($item) {
        return $item['price'] * $item['quantity'];
    });

    return response()->json([
        'status' => true,
        'cart_count' => collect($cart)->sum('quantity'),
        'net_total' => $total
    ]);
}


public function update(Request $request)
{
    $id = $request->id;
    $quantity = (int) $request->quantity;
    $cart = session()->get('cart', []);

    if(isset($cart[$id])){
        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);
    }

    $subtotal = $cart[$id]['price'] * $quantity;
    $total = collect($cart)->sum(function($item){
        return $item['price'] * $item['quantity'];
    });

    return response()->json([
        'status' => true,
        'subtotal' => $subtotal,
        'net_total' => $total,
        'grand_total' => $total + 60, 
        'cart_count' => collect($cart)->sum('quantity')
    ]);
}


public function confirm(Request $request)
{
    try {
       
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'delivary_id' => 'required|string',
            'payment_id' => 'required|string',
        ]);

       
        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => 'customer' . strtoupper(Str::random(3)) . '@gmail.com',
            'image' => 'assets/image/customars/photo.png'
        ]);
 $totalAmount = 0;

 foreach ($cart as $item) {
         $totalAmount += $item['price'] * $item['quantity'];
        }


        $order = Order::create([
            'customer_id' => $customer->id,
            'invoice' => 'INV-' . strtoupper(Str::random(6)),
            'delivary' => $request->delivary_id,
            'payment' => $request->payment_id,
            'amount' => $totalAmount,
            'status' => 'Pending',
        ]);

        
       
        

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'name' => $item['name'],
                'price' => $item['price'],
                'image' => $item['image'],
                'quantity' => $item['quantity'],
                'amount' => $item['price'] * $item['quantity'],
            ]);
        }

        

       
        session()->forget('cart');

        Log::info('✅ Order created successfully', [
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'amount' => $totalAmount,
            'invoice' => $order->invoice,
        ]);

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Your order has been placed successfully!');

    } catch (\Throwable $e) {
       
        Log::error('❌ Order creation failed', [
            'error_message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->back()->with('error', 'Something went wrong! Please try again.');
    }


}

public function success($id)
{
    $order = Order::with(['items', 'customer'])->findOrFail($id);
    return view('frontend.page.success', compact('order'));
}













}

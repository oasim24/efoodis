@extends('frontend.layouts.master')

@section('content')
<style>
    .order-success-container {
        background: #f9fafb;
        min-height: 100vh;
        padding: 40px 0;
    }
    .order-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }
   
    .order-header {
        background: linear-gradient(135deg, #00b09b, #96c93d);
        color: #fff;
        text-align: center;
    }
    .order-header h2 {
        font-weight: 700;
        margin-bottom: 2px;
    }
   
    .order-info span, .customer-info span {
        display: block;
        font-size: 15px;
        color: #555;
        margin-bottom: 6px;
    }
    .table th {
        background: #f1f5f9;
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .thankyou-text {
        font-size: 20px;
        font-weight: 600;
        color: #2e7d32;
        margin-top: 20px;
    }
    .btn-home {
        background: linear-gradient(135deg, #00b09b, #96c93d);
        border: none;
        color: #fff;
        padding: 10px 25px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-home:hover {
        background: linear-gradient(135deg, #0ac3a0, #a1da52);
        color: #fff;
    }
</style>

<div class="order-success-container d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="order-card mx-auto col-lg-8 col-md-10 col-12">
            <div class="order-header">
                <i class="bi bi-check-circle-fill fs-1"></i>
                <h2>Order Placed Successfully!</h2>
                <p>Your order has been received and is now being processed.</p>
            </div>
<div class="row  p-3">


            <div class="order-info col-md-6">
                <h5 class="mb-3 fw-bold text-primary">🧾 Order Details</h5>
                <span><strong>Invoice ID:</strong> {{ $order->invoice }}</span>
                <span><strong>Payment Method:</strong> {{ $order->payment }}</span>
                <span><strong>Order Status:</strong> {{ ucfirst($order->status) }}</span>
            </div>

            <div class="customer-info  col-md-6">
                <h5 class="mb-3  fw-bold text-primary">👤 Customer Information</h5>
                <span><strong>Name:</strong> {{ $order->customer->name }}</span>
                <span><strong>Phone:</strong> {{ $order->customer->phone }}</span>
                <span><strong>Address:</strong> {{ $order->customer->address }}</span>
            </div>
</div>
            <div class="p-3">
                <h5 class="fw-bold text-primary mt-3">🛍️ Ordered Items</h5>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td><img src="{{$item->image}}" width="50px" height="50px"></td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->price, 2) }}৳</td>
                                    <td class="text-end">{{ number_format($item->amount, 2) }}৳</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Net Total</th>
                                <th class="text-end">{{ number_format($order->items->sum('amount'), 2) }}৳</th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-end">Shipping</th>
                                <th class="text-end">{{ number_format($order->delivary , 2) }}৳</th>
                            </tr>
                           <tr>
                                <th colspan="4" class="text-end">Grand Total</th>
                                <th class="text-end">
                                    {{ number_format($order->items->sum('amount') + (float) $order->delivary, 2) }}৳
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="text-center pb-4">
                <p class="thankyou-text">Thank you for shopping with us!</p>
                <a href="{{ route('home') }}" class="btn-home mt-3">
                    <i class="bi bi-house-door"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

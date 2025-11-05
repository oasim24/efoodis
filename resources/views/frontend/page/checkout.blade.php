@extends('frontend.layouts.master')

@section('content')
<form action="{{ route('checkout.confirm') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <x-input name="name" label="Name" placeholder="Enter Your Name" required="true" col="col-12" />
            <x-input name="phone" label="Phone" placeholder="Enter Your Phone" required="true" col="col-12" />
            <x-input name="address" label="Address" placeholder="Enter Your Address" required="true" col="col-12" />

            <div class="col-12 row">
                <x-select name="delivary_id" label="Delivary Area" :options="$delivaries" :selected="$selecteddlivaries" :required="true" col="col-md-6" />
                <x-select name="payment_id" label="Payment Method" :options="$payments" :selected="$selectedPayment" :required="true" col="col-md-6" />
            </div>
        </div>

        <div class="col-md-7"> @if(count($cart) > 0) <table class="table table-bordered"> <thead> <tr> <th>Action</th> <th>Image</th> <th>Product</th> <th>Qty</th> <th>Price</th> <th>Subtotal</th> </tr> </thead> <tbody> @php $total = 0; $shipping = 60; // Fixed shipping @endphp @foreach($cart as $id => $item) @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp <tr id="cartItem-{{ $id }}"> <td> <button class="btn btn-sm btn-danger remove-from-cart" data-id="{{ $id }}">Delete</button> </td> <td><img src="{{ $item['image'] }}" width="30"></td> <td>{{ $item['name'] }}</td> <td> <input type="number" min="1" class="form-control qty-update" data-id="{{ $id }}" value="{{ $item['quantity'] }}" style="width:70px;"> </td> <td>৳{{ $item['price'] }}</td> <td id="subtotal-{{ $id }}">৳{{ $subtotal }}</td> </tr> @endforeach </tbody> <tfoot> <tr> <td colspan="5" class="text-end">Net Total</td> <td id="netTotal">৳{{ $total }}</td> </tr> <tr> <td colspan="5" class="text-end">Shipping</td> <td>৳{{ $shipping }}</td> </tr> <tr> <td colspan="5" class="text-end">Grand Total</td> <td id="grandTotal">৳{{ $total + $shipping }}</td> </tr> </tfoot> </table> @else <p>Your cart is empty!</p> @endif </div>
    </div>

    <button class="btn btn-success mt-3" type="submit">Confirm Order</button>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Remove Item
    $('.remove-from-cart').click(function(){
        let id = $(this).data('id');

        $.ajax({
            url: "{{ route('cart.remove') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", id: id},
            success: function(res){
                if(res.status){
                    $('#cartItem-' + id).remove();
                    $('#cartCount').text(res.cart_count);
                    $('#netTotal').text('৳'+res.net_total);
                    $('#grandTotal').text('৳'+(res.net_total + 60));
                }
            }
        });
    });

    // Update Quantity
    $('.qty-update').on('change', function(){
        let id = $(this).data('id');
        let quantity = $(this).val();

        $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", id: id, quantity: quantity},
            success: function(res){
                if(res.status){
                    $('#subtotal-' + id).text('৳'+res.subtotal);
                    $('#netTotal').text('৳'+res.net_total);
                    $('#grandTotal').text('৳'+res.grand_total);
                    $('#cartCount').text(res.cart_count);
                }
            }
        });
    });

});
</script>
@endpush

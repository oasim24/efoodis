<h2>Your Cart</h2>

@if(count($cart) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                <tr>
                    <td><img src="{{ $item['image'] }}" width="60"></td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>৳{{ $item['price'] }}</td>
                    <td>৳{{ $subtotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: ৳{{ $total }}</h4>
@else
    <p>Your cart is empty!</p>
@endif

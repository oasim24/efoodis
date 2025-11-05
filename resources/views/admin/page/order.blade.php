@extends('admin.layouts.app')

@section('title', 'Home Page')

@push('styles')
<style>
    .Model {
        width: 70%;
        height: auto;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background-color: white;
        transition: all 0.3s ease-in-out;
        z-index: 9999;
    }

    .status-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    color: #fff;
}

.status-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.status-card .card-title {
    font-size: 2rem;
    font-weight: 700;
}

.status-card .card-text {
    font-size: 1rem;
    font-weight: 500;
    margin-top: 0.5rem;
}
</style>
@endpush

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Orders</li>
    </ol>
</nav>
<div class="my-4 m-0 row p-0">

       @foreach($statusList as $value => $text)
    <a href="{{route('orders.status', $value)}}" class="col-md-3 my-3">
    <div class="card status-card text-center shadow-sm" style=" cursor: pointer;">
        <div class="card-body">
             <h2 class="card-title count">{{ $statusCounts[$value] }}</h2>
            <p class="card-text">{{ $text }}</p>
        </div>
    </div>
    </a>
    @endforeach
</div>
@php
   
    $statusKeys = array_keys($statusList);

    
    $currentIndex = array_search($currentStatus, $statusKeys);
@endphp

<div class="my-3 d-flex align-items-center gap-2">
    <button class="btn btn-primary d-none" id="multiUpdateBtn">Update Selected Status</button>
    <select id="multiStatusSelect" class="form-select w-auto">
        <option value="">Select Status</option>

        @foreach($statusList as $value => $text)
            @php
                $index = array_search($value, $statusKeys);
            @endphp

         
            @if($index >= $currentIndex)
                <option value="{{ $value }}" {{ $currentStatus == $value ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endif
        @endforeach
    </select>
</div>



<table id="commonTable">
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>#</th>
            <th>Invoice ID</th>
            <th>Customer Info</th>
            <th>Products</th>
            <th>Status</th>
            <th>Order Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $index => $order)
            <tr data-id="{{ $order->id }}">
                <td><input type="checkbox" class="orderCheckbox"></td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->invoice }}</td>
                <td>
                    <strong>Name:</strong> {{ $order->customer->name }}<br>
                    <strong>Mobile:</strong> {{ $order->customer->phone }}<br>
                    <strong>Address:</strong> {{ $order->customer->address }}
                </td>

                <td>
                    <button class="btn btn-outline-primary product_btn">See Details</button>

                    <div class="Model">
                        <div class="d-flex align-items-center justify-content-between border-2 border-bottom px-3 bg-primary">
                            <h5 class="text-white">Product Details</h5>
                            <button class="btn btn-sm btn-danger close_modal">X</button>
                        </div>
                        <div class="Data p-3">
                            <table class="w-100">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td><img src="{{ asset($item->image) }}" width="30" height="30"></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $order->amount }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Delivery Charge</td>
                                        <td>{{ $order->delivary }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Grand Total</td>
                                        <td>{{ $order->items->sum('amount') + $order->delivary }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>

                <td>
                    <select name="status" class="form-select statusSelect">
                      @foreach($statusList as $value => $text)
            @php
                $index = array_search($value, $statusKeys);
            @endphp

         
            @if($index >= $currentIndex)
                <option value="{{ $value }}" {{ $currentStatus == $value ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endif
        @endforeach
                    </select>
                </td>

                <td>{{ $order->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


@push('scripts')
<script>
$(document).ready(function() {

    
    $('.product_btn').on('click', function() {
        $(this).siblings('.Model').css('transform', 'translate(-50%, -50%) scale(1)');
    });
    $('.close_modal').on('click', function() {
        $(this).closest('.Model').css('transform', 'translate(-50%, -50%) scale(0)');
    });

  
    $('.statusSelect').on('change', function() {
        let newStatus = $(this).val();
        let orderId = $(this).closest('tr').data('id');

        $.ajax({
            url: "{{ route('orders.updateStatus') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: orderId,
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    alert('✅ Order status updated successfully!');
                } else {
                    alert('⚠️ Failed to update status.');
                }
            },
            error: function() {
                alert('❌ Something went wrong.');
            }
        });
    });

   
    $('#selectAll').on('change', function() {
        $('.orderCheckbox').prop('checked', $(this).prop('checked'));
    });
$('#multiStatusSelect').on('change', function() {
    $('#multiUpdateBtn').click();
})
    
    $('#multiUpdateBtn').on('click', function() {
        let selectedIds = [];
        let newStatus = $('#multiStatusSelect').val();

        if(!newStatus) {
            alert('⚠️ Please select a status to update.');
            return;
        }

        $('.orderCheckbox:checked').each(function() {
            selectedIds.push($(this).closest('tr').data('id'));
        });

        if(selectedIds.length === 0) {
            alert('⚠️ Please select at least one order.');
            return;
        }

        $.ajax({
            url: "{{ route('orders.updateMultipleStatus') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ids: selectedIds,
                status: newStatus
            },
            success: function(response) {
                if(response.success) {
                    alert('✅ Status updated for selected orders!');
                   
                    selectedIds.forEach(id => {
                        $('tr[data-id="'+id+'"] .statusSelect').val(newStatus);
                    });
                } else {
                    alert('⚠️ Failed to update selected orders.');
                }
            },
            error: function() {
                alert('❌ Something went wrong.');
            }
        });
    });
});
</script>
@endpush

@endsection

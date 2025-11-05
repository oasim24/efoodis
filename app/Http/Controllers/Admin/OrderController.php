<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

public function index()
{
    return redirect()->route('orders.status', ['status' => 'Pending']);
}


public function updateStatus(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:orders,id',
        'status' => 'required|string',
    ]);

    $order = Order::find($request->id);
    $order->status = $request->status;
    $order->save();

    return response()->json(['success' => true]);
}

public function updateMultipleStatus(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'integer|exists:orders,id',
        'status' => 'required|string',
    ]);

    Order::whereIn('id', $request->ids)->update(['status' => $request->status]);

    return response()->json(['success' => true]);
}

public function status($status)
{



 $orders = Order::with('items', 'customer')->where('status', $status)->get();

     $total = Order::count();
    $statusList = [
        'Pending' => 'Pending',
        'Processing' => 'Processing',
        'InCurier' => 'In Curier',
        'OnTheWay' => 'On The Way',
        'Delivary' => 'Delivary',
        'Confirm' => 'Confirm',
        'Paid' => 'Paid',
    ];

  $currentStatus = $status;
    $statusCounts = Order::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();


    foreach ($statusList as $key => $value) {
        if (!isset($statusCounts[$key])) {
            $statusCounts[$key] = 0;
        }
    }




return view('admin.page.order', compact('orders', 'statusList', 'statusCounts' , 'total' , 'currentStatus'));


}


}

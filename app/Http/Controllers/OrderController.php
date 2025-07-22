<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Eager load relationships to reduce queries
        $orders = Order::with(
            [
                'customer', 
                'items'=>function($query){
                    $query->orderByDesc('created_at');
                },
                'items.product'
            ]
        )->withCount(['items'])
        ->get();

        $orderData = [];
        foreach($orders as $key=>$order)
        {
            $customer = $order->customer;
            $items = $order->items;
            $totalAmount = 0;
            $itemsCount = count($order->items);   
            $completedOrderExists = [];

            foreach($items as $keyItem=>$item)
            {
                $product = $item->product;
                $totalAmount += $item->price * $item->quantity;

                if($keyItem === 0) {
                    // Get the last added to cart time for the first item
                    $lastAddedToCart = $item->created_at;
                }
            }

            // Check if the order is completed
            if($order->status === 'completed') {
                $completedOrderExists = true;
            }
            else {
                $completedOrderExists = false;
            }

            $orderData[] = [
                'order_id' => $order->id,
                'customer_name' => $customer->name,
                'total_amount' => $totalAmount,
                'items_count' => $itemsCount,
                'last_added_to_cart' => $lastAddedToCart,
                'completed_order_exists' => $completedOrderExists,
                'created_at' => $order->created_at,
                'completed_at'=> $completedOrderExists ? $order->completed_at : null,
            ];
        }

        
        // Sort by completed_at descending, nulls last
        usort($orderData, function($a, $b) {
            $aCompletedAt = $a['completed_at'] ? strtotime($a['completed_at']) : 0;
            $bCompletedAt = $b['completed_at'] ? strtotime($b['completed_at']) : 0;
            return strtotime($bCompletedAt) - strtotime($aCompletedAt);
        });

        return view('orders.index', ['orders' => $orderData]);
    }
}


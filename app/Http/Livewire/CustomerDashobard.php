<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerDashobard extends Component {
    public function render() {

        $orders = Order::where( 'user_id', Auth::user()->id )->orderBy( 'created_at', 'desc' )->get()->take( 10 );
        $totalCost = Order::where( 'user_id', Auth::user()->id )->where( 'status', '!=', 'canceled' )->sum( 'total' );
        $totalPurchase = Order::where( 'user_id', Auth::user()->id )->where( 'status', '!=', 'canceled' )->count();
        $totalDelivered = Order::where( 'user_id', Auth::user()->id )->where( 'status', 'delivered' )->count();
        $totalCanceled = Order::where( 'user_id', Auth::user()->id )->where( 'status', 'canceled' )->count();

        return view( 'livewire.customer-dashobard', array(
            'orders'         => $orders,
            'totalCost'      => $totalCost,
            'totalPurchase'  => $totalPurchase,
            'totalDelivered' => $totalDelivered,
            'totalCanceled'  => $totalCanceled,
        ) )
            ->layout( 'layouts.base' );
    }
}

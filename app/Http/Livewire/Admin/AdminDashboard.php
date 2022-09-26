<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboard extends Component {
    public function render() {

        $orders = Order::orderBy( 'id', 'desc' )->get()->take( 10 );
        $totalRevenue = Order::where( 'status', 'delivered' )->sum( 'total' );
        $totalSales = Order::where( 'status', 'delivered' )->count();
        $todaySales = Order::where( 'status', 'delivered' )->whereDate( 'created_at', Carbon::today() )->count();
        $todayRevenue = Order::where( 'status', 'delivered' )->whereDate( 'created_at', Carbon::today() )->sum( 'total' );

        return view( 'livewire.admin.admin-dashboard', array(
            'orders'       => $orders,
            'totalRevenue' => $totalRevenue,
            'totalSales'   => $totalSales,
            'todaySales'   => $todaySales,
            'todayRevenue' => $todayRevenue,
        ) )
            ->layout( 'layouts.base' );
    }
}

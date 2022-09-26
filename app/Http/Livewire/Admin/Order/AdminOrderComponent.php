<?php

namespace App\Http\Livewire\Admin\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminOrderComponent extends Component {

    use WithPagination;

    public function updateOrderStatus( $order_id, $status ) {
        $order = Order::findOrFail( $order_id );

        if ( $status == 'delivered' ) {

            if ( $order->status == 'canceled' ) {
                session()->flash( 'order_error_message', 'This order is already canceled!' );
                return;
            }

            $order->delivered_date = DB::raw( 'CURRENT_DATE' );
        } elseif ( $status == 'canceled' && $order->delivered_date == null ) {
            $order->canceled_date = DB::raw( 'CURRENT_DATE' );
        } else {
            session()->flash( 'order_error_message', 'This order is already delivered!' );
            return;
        }

        $order->status = $status;
        $order->save();
        session()->flash( 'order_message', 'Order status has been updated successfully' );
    }

    public function render() {
        $orders = Order::orderBy( 'created_at', 'desc' )->paginate( 12 );
        return view( 'livewire.admin.order.admin-order-component', array( 'orders' => $orders ) )
            ->layout( 'layouts.base' );
    }

}

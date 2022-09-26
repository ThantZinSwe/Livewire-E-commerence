<?php

namespace App\Http\Livewire\User\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserOrderDetailsComponent extends Component {

    public $order_id;

    public function mount( $order_id ) {
        $this->order_id = $order_id;
    }

    public function cancelOrder() {
        $order = Order::findOrFail( $this->order_id );

        if ( $order->status != "delivered" ) {
            $order->status = 'canceled';
            $order->canceled_date = DB::raw( 'CURRENT_DATE' );
            $order->save();
            session()->flash( 'order_message', 'Order has been canceled successfully!' );
        } else {
            session()->flash( 'order_error_message', 'Order already has been delivered!' );
        }

    }

    public function render() {

        $order = Order::where( 'user_id', Auth::user()->id )
            ->where( 'id', $this->order_id )
            ->first();

        return view( 'livewire.user.order.user-order-details-component', array( 'order' => $order ) )
            ->layout( 'layouts.base' );
    }

}

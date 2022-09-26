<?php

namespace App\Http\Livewire\Admin\Order;

use App\Models\Order;
use Livewire\Component;

class AdminOrderDetailsComponent extends Component {

    public $order_id;

    public function mount( $order_id ) {
        $this->order_id = $order_id;
    }

    public function render() {

        $order = Order::findOrFail( $this->order_id );

        return view( 'livewire.admin.order.admin-order-details-component', array('order' => $order) )
            ->layout( 'layouts.base' );
    }
}

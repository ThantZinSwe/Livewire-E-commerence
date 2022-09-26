<?php

namespace App\Http\Livewire\User\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserOrderComponent extends Component {

    use WithPagination;

    public function render() {
        $orders = Order::where( 'user_id', Auth::user()->id )
            ->paginate( 12 );
        return view( 'livewire.user.order.user-order-component', array( 'orders' => $orders ) )
            ->layout( 'layouts.base' );
    }
}

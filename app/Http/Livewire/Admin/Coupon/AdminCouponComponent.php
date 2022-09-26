<?php

namespace App\Http\Livewire\Admin\Coupon;

use App\Models\Coupon;
use Livewire\Component;

class AdminCouponComponent extends Component {

    public function deleteCoupon( $coupon_id ) {
        $coupon = Coupon::findOrFail( $coupon_id );
        $coupon->delete();
        session()->flash( 'success_message', 'Coupon has been deleted successfully!' );
    }

    public function render() {
        $coupons = Coupon::paginate( 5 );
        return view( 'livewire.admin.coupon.admin-coupon-component', array( 'coupons' => $coupons ) )
            ->layout( 'layouts.base' );
    }
}

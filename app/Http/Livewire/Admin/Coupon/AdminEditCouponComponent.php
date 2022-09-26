<?php

namespace App\Http\Livewire\Admin\Coupon;

use App\Models\Coupon;
use Livewire\Component;

class AdminEditCouponComponent extends Component {

    public $coupon_id;
    public $code;
    public $type;
    public $value;
    public $cart_value;
    public $expiry_date;

    protected $rules = array(
        'code'        => 'required',
        'type'        => 'required',
        'value'       => 'required',
        'cart_value'  => 'required',
        'expiry_date' => 'required',
    );

    public function mount( $coupon_id ) {
        $coupon = Coupon::findOrFail( $coupon_id );

        $this->coupon_id = $coupon->id;
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->cart_value = $coupon->cart_value;
        $this->expiry_date = $coupon->expiry_date;
    }

    public function updated() {
        $this->validate( array( 'code' => 'unique:coupons,code,' . $this->coupon_id ) );
    }

    public function updateCoupon() {
        $this->validate();
        $coupon = Coupon::findOrFail( $this->coupon_id );

        $coupon->update( array(
            'code'        => $this->code,
            'type'        => $this->type,
            'value'       => $this->value,
            'cart_value'  => $this->cart_value,
            'expiry_date' => $this->expiry_date,
        ) );

        session()->flash( 'success_message', 'Coupon has been updated successfully!' );
    }

    public function render() {
        return view( 'livewire.admin.coupon.admin-edit-coupon-component' )
            ->layout( 'layouts.base' );
    }
}

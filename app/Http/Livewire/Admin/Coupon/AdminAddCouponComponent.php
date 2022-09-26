<?php

namespace App\Http\Livewire\Admin\Coupon;

use App\Models\Coupon;
use Livewire\Component;

class AdminAddCouponComponent extends Component {

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

    public function updated() {
        $this->validate( array( 'code' => 'unique:coupons' ) );
    }

    public function storeCoupon() {
        $this->validate();

        Coupon::create( array(
            'code'        => $this->code,
            'type'        => $this->type,
            'value'       => $this->value,
            'cart_value'  => $this->cart_value,
            'expiry_date' => $this->expiry_date,
        ) );

        session()->flash( 'success_message', 'Coupon has been created successfully!' );
    }

    public function render() {
        return view( 'livewire.admin.coupon.admin-add-coupon-component' )
            ->layout( 'layouts.base' );
    }
}

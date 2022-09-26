<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartComponent extends Component {

    public $use_coupon;
    public $coupon_code;
    public $discount;
    public $subtotalAfterDiscount;
    public $taxAfterDiscount;
    public $totalAfterDiscount;

    public function increaseQty( $rowId ) {
        $product = Cart::instance( 'cart' )->get( $rowId );
        $qty = $product->qty + 1;
        Cart::instance( 'cart' )->update( $rowId, $qty );
        $this->emitTo( 'render.cart-count-component', 'refreshComponent' );
    }

    public function decreaseQty( $rowId ) {
        $product = Cart::instance( 'cart' )->get( $rowId );
        $qty = $product->qty - 1;
        Cart::instance( 'cart' )->update( $rowId, $qty );
        $this->emitTo( 'render.cart-count-component', 'refreshComponent' );
    }

    public function destroy( $rowId ) {
        Cart::instance( 'cart' )->remove( $rowId );
        $this->emitTo( 'render.cart-count-component', 'refreshComponent' );
        session()->flash( 'success_message', 'Item has been removed' );
    }

    public function destroyAll() {
        Cart::instance( 'cart' )->destroy();
        $this->emitTo( 'render.cart-count-component', 'refreshComponent' );
        session()->flash( 'success_message', 'All items has been cleared' );
    }

    public function applyCoupon() {
        $coupon = Coupon::where( 'code', $this->coupon_code )
            ->where( 'expiry_date', '>', Carbon::today() )
            ->where( 'cart_value', '<=', Cart::instance( 'cart' )->subtotal() )
            ->first();

        if ( !$coupon ) {
            session()->flash( 'coupon_error_message', 'Invalid coupon. Please check and try again!' );
            return;
        }

        session()->put( 'coupon', array(
            'code'       => $coupon->code,
            'type'       => $coupon->type,
            'value'      => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ) );
    }

    //Calculate Coupon
    public function calculateDiscount() {

        if ( session()->has( 'coupon' ) ) {

            if ( session()->get( 'coupon' )['type'] == 'fixed' ) {
                $this->discount = session()->get( 'coupon' )['value'];
            } else {
                $this->discount = ( session()->get( 'coupon' )['value'] * Cart::instance( 'cart' )->subtotal() ) / 100;
            }

            $this->subtotalAfterDiscount = Cart::instance( 'cart' )->subtotal() - $this->discount;
            $this->taxAfterDiscount = ( $this->subtotalAfterDiscount * config( 'cart.tax' ) ) / 100;
            $this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;
        }

    }

    public function removeCoupon() {
        session()->forget( 'coupon' );
    }

    public function checkout() {

        if ( Auth::check() ) {
            return to_route( 'checkout' );
        } else {
            return to_route( 'login' );
        }

    }

    //Checkout Amount
    public function setAmountForCheckout() {

        if ( !Cart::instance( 'cart' )->count() > 0 ) {
            session()->forget( 'checkout' );
            return;
        }

        if ( session()->has( 'coupon' ) ) {
            session()->put( 'checkout', array(
                'discount' => $this->discount,
                'subtotal' => $this->subtotalAfterDiscount,
                'tax'      => $this->taxAfterDiscount,
                'total'    => $this->totalAfterDiscount,
            ) );
        } else {
            session()->put( 'checkout', array(
                'discount' => 0,
                'subtotal' => Cart::instance( 'cart' )->subtotal(),
                'tax'      => Cart::instance( 'cart' )->tax(),
                'total'    => Cart::instance( 'cart' )->total(),
            ) );
        }

    }

    public function render() {

        if ( session()->has( 'coupon' ) ) {

            if ( session()->get( 'coupon' )['cart_value'] > Cart::instance( 'cart' )->subtotal ) {
                session()->forget( 'coupon' );
            } else {
                $this->calculateDiscount();
            }

        }

        $this->setAmountForCheckout();

        if ( Auth::check() ) {
            Cart::instance( 'cart' )->store( Auth::user()->email );
        }

        return view( 'livewire.cart-component' )
            ->layout( 'layouts.base' );
    }

}

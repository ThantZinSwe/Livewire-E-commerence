<?php

namespace App\Http\Livewire;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Transaction;
use Cartalyst\Stripe\Stripe;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CheckoutComponent extends Component {

    public $shipping_different;

    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $line1;
    public $line2;
    public $city;
    public $province;
    public $country;
    public $zipcode;

    public $s_firstname;
    public $s_lastname;
    public $s_email;
    public $s_mobile;
    public $s_line1;
    public $s_line2;
    public $s_city;
    public $s_province;
    public $s_country;
    public $s_zipcode;

    public $payment_method;
    public $thankyou;

    public $card_number;
    public $expiry_month;
    public $expiry_year;
    public $cvc;

    public function placeOrder() {
        $this->validate( array(
            'firstname'      => 'required',
            'lastname'       => 'required',
            'email'          => 'required|email',
            'mobile'         => 'required|numeric',
            'line1'          => 'required',
            'city'           => 'required',
            'province'       => 'required',
            'country'        => 'required',
            'zipcode'        => 'required',
            'payment_method' => 'required',
        ) );

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = session()->get( 'checkout' )['subtotal'];
        $order->discount = session()->get( 'checkout' )['discount'];
        $order->tax = session()->get( 'checkout' )['tax'];
        $order->total = session()->get( 'checkout' )['total'];
        $order->firstname = $this->firstname;
        $order->lastname = $this->lastname;
        $order->email = $this->email;
        $order->mobile = $this->mobile;
        $order->line1 = $this->line1;
        $order->line2 = $this->line2;
        $order->city = $this->city;
        $order->province = $this->province;
        $order->country = $this->country;
        $order->zipcode = $this->zipcode;
        $order->status = 'ordered';
        $order->is_shipping_different = $this->shipping_different ? 1 : 0;
        $order->save();

        foreach ( Cart::instance( 'cart' )->content() as $item ) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }

        if ( $this->shipping_different ) {
            $this->validate( array(
                's_firstname' => 'required',
                's_lastname'  => 'required',
                's_email'     => 'required|email',
                's_mobile'    => 'required|numeric',
                's_line1'     => 'required',
                's_city'      => 'required',
                's_province'  => 'required',
                's_country'   => 'required',
                's_zipcode'   => 'required',
            ) );

            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->firstname = $this->s_firstname;
            $shipping->lastname = $this->s_lastname;
            $shipping->email = $this->s_email;
            $shipping->mobile = $this->s_mobile;
            $shipping->line1 = $this->s_line1;
            $shipping->line2 = $this->s_line2;
            $shipping->city = $this->s_city;
            $shipping->province = $this->s_province;
            $shipping->country = $this->s_country;
            $shipping->zipcode = $this->s_zipcode;
            $shipping->save();
        }

        if ( $this->payment_method == 'cod' ) {

            $this->makeTransaction( $order->id, 'pending' );
            $this->resetCart();

        } elseif ( $this->payment_method == 'card' ) {

            $this->validate( array(
                'card_number'  => 'required',
                'expiry_year'  => 'required',
                'expiry_month' => 'required',
                'cvc'          => 'required',
            ) );

            $stripe = Stripe::make( env( 'STRIPE_KEY' ) );

            try {
                $token = $stripe->tokens()->create( array(
                    'card' => array(
                        'number'    => $this->card_number,
                        'exp_month' => $this->expiry_month,
                        'exp_year'  => $this->expiry_year,
                        'cvc'       => $this->cvc,
                    ),
                ) );

                if ( !isset( $token['id'] ) ) {
                    session()->flash( 'stripe_error', 'The stripe token was not generated correctly!' );
                    $this->thankyou = 0;
                }

                $customer = $stripe->customers()->create( array(
                    'name'    => $this->firstname . ' ' . $this->lastname,
                    'email'   => $this->email,
                    'phone'   => $this->mobile,
                    'address' => array(
                        'line1'       => $this->line1,
                        'postal_code' => $this->zipcode,
                        'city'        => $this->city,
                        'state'       => $this->province,
                        'country'     => $this->country,
                    ),
                    'source'  => $token['id'],
                ) );

                if ( $this->shipping_different ) {
                    $customer->create( array(
                        'shipping' => array(
                            'name'    => $this->s_firstname . ' ' . $this->s_lastname,
                            'address' => array(
                                'line1'       => $this->s_line1,
                                'postal_code' => $this->s_zipcode,
                                'city'        => $this->s_city,
                                'state'       => $this->s_province,
                                'country'     => $this->s_country,
                            ),
                        ),
                    ) );
                }

                $charge = $stripe->charges()->create( array(
                    'customer'    => $customer['id'],
                    'currency'    => 'USD',
                    'amount'      => session()->get( 'checkout' )['total'],
                    'description' => 'Payment for order no ' . $order->id,
                ) );

                if ( $charge['status'] == 'succeeded' ) {
                    $this->makeTransaction( $order->id, 'approved' );
                    $this->resetCart();
                } else {
                    session()->flash( 'stripe_error', 'Error in Transaction!' );
                    $this->thankyou = 0;
                }

            } catch ( Exception $e ) {
                session()->flash( 'stripe_error', $e->getMessage() );
                $this->thankyou = 0;
            }

        }

        $this->sendOrderConfirmation( $order );

    }

    public function resetCart() {
        $this->thankyou = 1;
        Cart::instance( 'cart' )->destroy();
        session()->forget( 'checkout' );
    }

    public function makeTransaction( $order_id, $status ) {
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->order_id = $order_id;
        $transaction->mode = $this->payment_method;
        $transaction->status = $status;
        $transaction->save();
    }

    public function sendOrderConfirmation( $order ) {
        Mail::to( $order->email )->send( new OrderMail( $order ) );
    }

    public function verifyForCheckout() {

        if ( !Auth::check() ) {
            return to_route( 'login' );
        } elseif ( $this->thankyou ) {
            return to_route( 'thankyou' );
        } elseif ( !session()->get( 'checkout' ) ) {
            return to_route( 'product.cart' );
        }

    }

    public function render() {
        $this->verifyForCheckout();
        return view( 'livewire.checkout-component' )
            ->layout( 'layouts.base' );
    }

}
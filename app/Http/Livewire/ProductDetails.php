<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetails extends Component {

    public $slug;
    public $product_qty = 1;
    public $satt = array();

    public function mount( $slug ) {
        $this->slug = $slug;
    }

    public function increase() {
        $qty = Product::where( 'slug', $this->slug )->first();

        if ( $qty->quantity > $this->product_qty ) {
            $this->product_qty++;
        }

    }

    public function decrease() {

        if ( $this->product_qty > 1 ) {
            $this->product_qty--;
        }

    }

    public function store( $product_id, $product_name, $product_price ) {

        $cart = collect( Cart::instance( 'cart' )->content() )->pluck( 'id' )->contains( $product_id );
        $wishlist = Cart::instance( 'wishlist' )->content()->pluck( 'id' )->contains( $product_id );
        dd( $this->satt );

        if ( $cart ) {
            session()->flash( 'error_message', 'Item already added in cart' );
            return back();
        } else {
            $c_item = Cart::instance( 'cart' )->add( $product_id, $product_name, $this->product_qty, $product_price, $this->satt )->associate( 'App\Models\Product' );

            if ( $wishlist ) {
                Cart::instance( 'wishlist' )->remove( $c_item->rowId );
            }

            session()->flash( 'success_message', 'Item added in Cart' );
            return to_route( 'product.cart' );
        }

    }

    public function addToWishList( $product_id, $product_name, $product_price ) {

        $cart = collect( Cart::instance( 'cart' )->content() )->pluck( 'id' )->contains( $product_id );

        if ( $cart ) {
            session()->flash( 'error_message', 'Item already exists in cart' );
            return back();
        } else {
            Cart::instance( 'wishlist' )->add( $product_id, $product_name, 1, $product_price )->associate( 'App\Models\Product' );
            $this->emitTo( 'render.wishlist-count-component', 'refreshComponent' );
        }

    }

    public function removeToWishlist( $product_id ) {
        $w_items = Cart::instance( 'wishlist' )->content();

        foreach ( $w_items as $w_item ) {

            if ( $w_item->id == $product_id ) {
                Cart::instance( 'wishlist' )->remove( $w_item->rowId );
                $this->emitTo( 'render.wishlist-count-component', 'refreshComponent' );
            }

        }

    }

    public function render() {
        $product_details = Product::where( 'slug', $this->slug )->first();
        $related_products = Product::where( 'category_id', $product_details->category_id )->inRandomOrder()->limit( 8 )->get();

        if ( Auth::check() ) {
            Cart::instance( 'wishlist' )->store( Auth::user()->email );
            Cart::instance( 'cart' )->store( Auth::user()->email );
        }

        return view( 'livewire.product-details', array( 'product_details' => $product_details, 'related_products' => $related_products ) )
            ->layout( 'layouts.base' );
    }

}

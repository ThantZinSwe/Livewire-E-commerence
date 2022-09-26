<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class WishlistComponent extends Component {

    public function moveToCart( $product_id, $product_name, $product_price ) {

        $cart = Cart::instance( 'cart' )->add( $product_id, $product_name, 1, $product_price )->associate( 'App\Models\Product' );
        Cart::instance( 'wishlist' )->remove( $cart->rowId );
        $this->emitTo( 'render.cart-count-component', 'refreshComponent' );
        $this->emitTo( 'render.wishlist-count-component', 'refreshComponent' );
        session()->flash( 'success_message', 'Item has been moved to Cart successfully!' );
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
        return view( 'livewire.wishlist-component' )
            ->layout( 'layouts.base' );
    }

}

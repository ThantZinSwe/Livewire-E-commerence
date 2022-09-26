<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class SearchComponent extends Component {

    use WithPagination;

    public $sorting;
    public $perpage;
    public $min_price;
    public $max_price;

    public $search;
    public $product_cat;
    public $product_cat_id;

    public function mount() {
        $this->sorting = "default";
        $this->perpage = 12;
        $this->min_price = 1;
        $this->max_price = 1000;
        $this->fill( request()->only( 'search', 'product_cat', 'product_cat_id' ) );
    }

    public function store( $product_id, $product_name, $product_price ) {

        $cart = collect( Cart::instance( 'cart' )->content() )->pluck( 'id' )->contains( $product_id );
        $wishlist = Cart::instance( 'wishlist' )->content()->pluck( 'id' )->contains( $product_id );

        if ( $cart ) {
            session()->flash( 'error_message', 'Item already added in cart' );
            return back();
        } else {
            $c_item = Cart::instance( 'cart' )->add( $product_id, $product_name, 1, $product_price )->associate( 'App\Models\Product' );

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
        $product_cat = $this->product_cat;
        $products = Product::with( 'category' )
            ->where( 'name', 'like', '%' . $this->search . '%' )
            ->whereBetween( 'regular_price', array( $this->min_price, $this->max_price ) );

// ->where( 'category_id', 'like', '%' . $this->product_cat_id . '%' );

        if ( $this->sorting == "date" ) {
            $products->orderBy( 'created_at', 'desc' );
        }

        if ( $this->sorting == "price-asc" ) {
            $products->orderBy( 'regular_price', 'asc' );
        }

        if ( $this->sorting == "price-desc" ) {
            $products->orderBy( 'regular_price', 'desc' );
        }

        $products = $products->paginate( $this->perpage );

        $categories = Category::all();

        return view( 'livewire.search-component', array( 'products' => $products, 'categories' => $categories ) )
            ->layout( 'layouts.base' );
    }

}

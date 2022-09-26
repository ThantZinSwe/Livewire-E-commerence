<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component {

    use WithPagination;

    public $sorting;
    public $perpage;
    public $min_price;
    public $max_price;
    public $category_slug;
    public $scategory_slug;

    public function mount( $category_slug, $scategory_slug = null ) {
        $this->sorting = "default";
        $this->perpage = 12;
        $this->min_price = 1;
        $this->max_price = 1000;
        $this->category_slug = $category_slug;
        $this->scategory_slug = $scategory_slug;
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

    public function render() {
        $category_id = "";
        $category_name = null;
        $filter = "";

        if ( $this->scategory_slug ) {
            $scategory = Subcategory::where( 'slug', $this->scategory_slug )->first();
            $category_id = $scategory->id;
            $category_name = $scategory->name;
            $filter = "sub";
        } else {
            $category = Category::where( 'slug', $this->category_slug )->first();
            $category_id = $category->id;
            $category_name = $category->name;
            $filter = "";
        }

        $products = Product::where( $filter . 'category_id', $category_id )
            ->whereBetween( 'regular_price', array( $this->min_price, $this->max_price ) );

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

        return view( 'livewire.category-component', array( 'products' => $products, 'categories' => $categories, 'category_name' => $category_name ) )
            ->layout( 'layouts.base' );
    }

}

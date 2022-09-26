<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Profile;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeComponent extends Component {
    public function render() {
        $sliders = HomeSlider::where( 'status', 1 )->get();
        $latest_products = Product::orderBy( 'created_at', 'desc' )->get()->take( 8 );

        $homeCategory = HomeCategory::find( 1 );
        $no_of_products = $homeCategory->no_of_products;
        $categories_id = explode( ',', $homeCategory->sel_categories );
        $categories = Category::whereIn( 'id', $categories_id )->get();

        $sale_products = Product::where( 'sale_price', '>', 0 )->inRandomOrder()->get()->take( 8 );

        if ( Auth::check() ) {
            $userProfile = Profile::where( 'user_id', Auth::user()->id )->first();

            if ( !$userProfile ) {
                $profile = new Profile();
                $profile->user_id = Auth::user()->id;
                $profile->image = 'default.png';
                $profile->save();
            }

            Cart::instance( 'cart' )->restore( Auth::user()->email );
            Cart::instance( 'wishlist' )->restore( Auth::user()->email );
        }

        return view( 'livewire.home-component',
            array( 'sliders'   => $sliders,
                'latest_products' => $latest_products,
                'categories'      => $categories,
                'no_of_products'  => $no_of_products,
                'sale_products'   => $sale_products ) )
            ->layout( 'layouts.base' );
    }

}

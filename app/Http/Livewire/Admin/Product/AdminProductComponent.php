<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductComponent extends Component {
    use WithPagination;

    public $searchTerm;

    public function deleteProduct( $product_id ) {
        $product = Product::findOrFail( $product_id );
        $image = $product->image;

        if ( File::exists( public_path() . '/assets/images/products/' . $image ) ) {
            File::delete( public_path() . '/assets/images/products/' . $image );
        }

        $product->delete();
        session()->flash( 'success_message', 'Product has been deleted successfully!' );

    }

    public function render() {
        $search = $this->searchTerm;
        $products = Product::with( 'category' )
            ->orWhere( 'name', 'like', '%' . $search . '%' )
            ->orWhereHas( 'category', function ( $q ) use ( $search ) {
                $q->where( 'name', 'like', '%' . $search . '%' );
            } )
            ->orWhereHas( 'category.subCategories', function ( $q ) use ( $search ) {
                $q->where( 'name', 'like', '%' . $search . '%' );
            } )
            ->orWhere( 'stock_status', 'like', '%' . $search . '%' )
            ->orWhere( 'regular_price', 'like', '%' . $search . '%' )
            ->orWhere( 'sale_price', 'like', '%' . $search . '%' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 10 );
        return view( 'livewire.admin.product.admin-product-component', array( 'products' => $products ) )
            ->layout( 'layouts.base' );
    }

}

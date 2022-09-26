<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminAddProductComponent extends Component {

    use WithFileUploads;

    public $name;
    public $slug;
    public $short_description;
    public $description;
    public $regular_price;
    public $sale_price;
    public $SKU;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $category_id;
    public $scategory_id;

    public $attr;
    public $attribute_arr = array();
    public $inputs = array();
    public $attribute_values;

    public function mount() {
        $this->featured = 0;
        $this->stock_status = "instock";
    }

    public function addAttribute() {

        if ( !in_array( $this->attr, $this->attribute_arr ) ) {
            array_push( $this->attribute_arr, $this->attr );
            array_push( $this->inputs, $this->attr );
        }

    }

    public function removeAttribute( $attr, $attr_value ) {
        unset( $this->inputs[$attr] );
        unset( $this->attribute_arr[$attr] );
        $this->attribute_values[$attr_value] = null;
    }

    public function generateSlug() {
        $this->slug = Str::slug( $this->name );
    }

    public function updated() {
        $this->validate( array( 'name' => 'unique:products' ) );
    }

    protected $rules = array(
        'name'              => 'required',
        'slug'              => 'required',
        'short_description' => 'required',
        'description'       => 'required',
        'regular_price'     => 'required',
        'SKU'               => 'required',
        'image'             => 'required',
        'category_id'       => 'required',
    );

    public function changeSubcategory() {
        $this->scategory_id = 0;
    }

    public function storeProduct() {
        $this->validate();

        $imageName = uniqid() . '-' . $this->image->getClientOriginalName();
        $this->image->storeAs( 'products', $imageName );

        $product = Product::create( array(
            'name'              => $this->name,
            'slug'              => $this->slug,
            'short_description' => $this->short_description,
            'description'       => $this->description,
            'regular_price'     => $this->regular_price,
            'sale_price'        => $this->sale_price,
            'SKU'               => $this->SKU,
            'stock_status'      => $this->stock_status,
            'featured'          => $this->featured,
            'quantity'          => $this->quantity,
            'image'             => $imageName,
            'category_id'       => $this->category_id,
        ) );

        if ( $this->scategory_id ) {
            $product->subcategory_id = $this->scategory_id;
            $product->save();
        }

        if ( $this->attribute_values != null ) {

            foreach ( $this->attribute_values as $key => $attribute_value ) {
                $avalues = explode( ',', $attribute_value );

                if ( $attribute_value != null ) {

                    foreach ( $avalues as $avalue ) {
                        $attr_value = new AttributeValue();
                        $attr_value->product_attribute_id = $key;
                        $attr_value->value = $avalue;
                        $attr_value->product_id = $product->id;
                        $attr_value->save();
                    }

                }

            }

        }

        session()->flash( 'success_message', 'Product has been created successfully!' );
    }

    public function render() {
        $categories = Category::all();
        $scategories = Subcategory::where( 'category_id', $this->category_id )->get();
        $pattributes = ProductAttribute::all();
        return view( 'livewire.admin.product.admin-add-product-component', array( 'categories' => $categories, 'scategories' => $scategories, 'pattributes' => $pattributes ) )
            ->layout( 'layouts.base' );
    }

}

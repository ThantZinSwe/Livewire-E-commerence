<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditProductComponent extends Component {

    use WithFileUploads;

    public $product_id;
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
    public $newImage;
    public $category_id;
    public $scategory_id;

    public $attr;
    public $inputs = array();
    public $attribute_arr = array();
    public $attribute_values = array();
    public $attr_value;

    protected $rules = array(
        'name'              => 'required',
        'slug'              => 'required',
        'short_description' => 'required',
        'description'       => 'required',
        'regular_price'     => 'required',
        'SKU'               => 'required',
        'category_id'       => 'required',
    );

    public function mount( $product_slug ) {

        $product = Product::where( 'slug', $product_slug )->first();

        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->regular_price = $product->regular_price;
        $this->sale_price = $product->sale_price;
        $this->SKU = $product->SKU;
        $this->stock_status = $product->stock_status;
        $this->featured = $product->featured;
        $this->quantity = $product->quantity;
        $this->image = $product->image;
        $this->category_id = $product->category_id;
        $this->scategory_id = $product->subcategory_id;

        $this->inputs = $product->attributeValues->where( 'product_id', $product->id )->unique( 'product_attribute_id' )->pluck( 'product_attribute_id' );
        $this->attribute_arr = $product->attributeValues->where( 'product_id', $product->id )->unique( 'product_attribute_id' )->pluck( 'product_attribute_id' );

        foreach ( $this->attribute_arr as $a_arr ) {
            $allAttributeValue = AttributeValue::where( 'product_id', $product->id )
                ->where( 'product_attribute_id', $a_arr )
                ->get()
                ->pluck( 'value' );
            $valueString = "";

            foreach ( $allAttributeValue as $value ) {
                $valueString = $valueString . $value . ',';
            }

            $this->attribute_values[$a_arr] = rtrim( $valueString, ',' );

        }

    }

    public function addAttribute() {

        if ( !$this->attribute_arr->contains( $this->attr ) ) {
            $this->attribute_arr->push( $this->attr );
            $this->inputs->push( $this->attr );
        }

    }

    public function removeAttribute( $attr, $attr_value ) {
        unset( $this->inputs[$attr] );
        unset( $this->attribute_arr[$attr] );
        $this->attribute_values[$attr_value] = null;
        $this->attr_value = $attr_value;
    }

    public function updated() {
        $this->validate( array( 'name' => 'unique:products,name,' . $this->product_id ) );
    }

    public function generateSlug() {
        $this->slug = Str::slug( $this->name );
    }

    public function changeSubcategory() {
        $this->scategory_id = 0;
    }

    public function updateProduct() {
        $this->validate();

        $product = Product::findOrFail( $this->product_id );

        if ( $this->newImage ) {
            $imageName = uniqid() . '-' . $this->newImage->getClientOriginalName();
            $this->newImage->storeAs( 'products', $imageName );

            if ( File::exists( public_path() . '/assets/images/products/' . $product->image ) ) {
                File::delete( public_path() . '/assets/images/products/' . $product->image );
            }

        } else {
            $imageName = $product->image;
        }

        if ( $this->scategory_id ) {
            $product->subcategory_id = $this->scategory_id;
            $product->save();
        }

        $product->update( array(
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

        AttributeValue::where( 'product_id', $product->id )->delete();

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

        session()->flash( 'success_message', 'Product has been updated successfully!' );
    }

    public function render() {
        $categories = Category::all();
        $scategories = Subcategory::where( 'category_id', $this->category_id )->get();
        $pattributes = ProductAttribute::all();
        return view( 'livewire.admin.product.admin-edit-product-component', array( 'categories' => $categories, 'scategories' => $scategories, 'pattributes' => $pattributes ) )
            ->layout( 'layouts.base' );
    }

}

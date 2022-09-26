<?php

namespace App\Http\Livewire\Admin\Attribute;

use App\Models\ProductAttribute;
use Livewire\Component;

class AdminAttributeComponent extends Component {

    public function deleteAttribute( $attribute_id ) {
        $attribute = ProductAttribute::findOrFail( $attribute_id );
        $attribute->delete();
        session()->flash( 'success_message', 'Attribute has been deleted successfully' );
    }

    public function render() {

        $attributes = ProductAttribute::paginate( 10 );

        return view( 'livewire.admin.attribute.admin-attribute-component', array( 'attributes' => $attributes ) )
            ->layout( 'layouts.base' );
    }
}

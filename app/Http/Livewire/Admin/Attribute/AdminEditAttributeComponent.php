<?php

namespace App\Http\Livewire\Admin\Attribute;

use App\Models\ProductAttribute;
use Livewire\Component;

class AdminEditAttributeComponent extends Component {

    public $attribute_id;
    public $name;

    public function mount( $attribute_id ) {
        $attribute = ProductAttribute::findOrFail( $attribute_id );
        $this->attribute_id = $attribute->id;
        $this->name = $attribute->name;
    }

    public function editAttribute() {
        $this->validate( array( 'name' => 'required' ) );

        $attribute = ProductAttribute::findOrFail( $this->attribute_id );
        $attribute->update( array(
            'name' => $this->name,
        ) );

        session()->flash( 'success_message', 'Attribute has benn updated successfully' );
    }

    public function render() {
        return view( 'livewire.admin.attribute.admin-edit-attribute-component' )
            ->layout( 'layouts.base' );
    }
}

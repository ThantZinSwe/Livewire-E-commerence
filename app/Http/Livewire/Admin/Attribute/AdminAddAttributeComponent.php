<?php

namespace App\Http\Livewire\Admin\Attribute;

use App\Models\ProductAttribute;
use Livewire\Component;

class AdminAddAttributeComponent extends Component {

    public $name;

    public function store() {
        $this->validate( array( 'name' => 'required' ) );

        ProductAttribute::create( array(
            'name' => $this->name,
        ) );

        session()->flash( 'success_message', 'Attribute has been added successfully' );
    }

    public function render() {
        return view( 'livewire.admin.attribute.admin-add-attribute-component' )
            ->layout( 'layouts.base' );
    }
}

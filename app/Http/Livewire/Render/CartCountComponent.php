<?php

namespace App\Http\Livewire\Render;

use Livewire\Component;

class CartCountComponent extends Component {
    protected $listeners = array('refreshComponent' => '$refresh');
    public function render() {
        return view( 'livewire.render.cart-count-component' );
    }
}

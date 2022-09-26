<?php

namespace App\Http\Livewire\Render;

use Livewire\Component;

class WishlistCountComponent extends Component {
    protected $listeners = array('refreshComponent' => '$refresh');
    public function render() {
        return view( 'livewire.render.wishlist-count-component' );
    }
}

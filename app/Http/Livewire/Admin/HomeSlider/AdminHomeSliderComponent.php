<?php

namespace App\Http\Livewire\Admin\HomeSlider;

use App\Models\HomeSlider;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHomeSliderComponent extends Component {

    use WithPagination;

    public function deleteSlider( $slider_id ) {
        $slider = HomeSlider::findOrFail( $slider_id );
        $image = $slider->image;

        if ( File::exists( public_path() . '/assets/images/sliders/' . $image ) ) {
            File::delete( public_path() . '/assets/images/sliders/' . $image );
        }

        $slider->delete();

        session()->flash( 'success_message', 'HomeSlider has been deleted sucessfully!' );
    }

    public function render() {
        $sliders = HomeSlider::paginate( 5 );
        return view( 'livewire.admin.home-slider.admin-home-slider-component', array( 'sliders' => $sliders ) )
            ->layout( 'layouts.base' );
    }

}

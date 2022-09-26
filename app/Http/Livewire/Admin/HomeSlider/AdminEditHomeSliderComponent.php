<?php

namespace App\Http\Livewire\Admin\HomeSlider;

use App\Models\HomeSlider;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditHomeSliderComponent extends Component {

    use WithFileUploads;

    public $slider_id;
    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $image;
    public $newImage;
    public $status;

    protected $rules = array(
        'title'    => 'required',
        'subtitle' => 'required',
        'price'    => 'required',
        'link'     => 'required',
        'status'   => 'required',
    );

    public function mount( $slider_id ) {
        $slider = HomeSlider::findOrFail( $slider_id );

        $this->slider_id = $slider->id;
        $this->title = $slider->title;
        $this->subtitle = $slider->subtitle;
        $this->price = $slider->price;
        $this->link = $slider->link;
        $this->image = $slider->image;
        $this->status = $slider->status;
    }

    public function editSlider() {
        $this->validate();

        $slider = HomeSlider::findOrFail( $this->slider_id );

        if ( $this->newImage ) {
            $imageName = $this->newImage->getClientOriginalName();
            $this->newImage->storeAs( 'sliders', $imageName );

            if ( File::exists( public_path() . '/assets/images/sliders/' . $slider->image ) ) {
                File::delete( public_path() . '/assets/images/sliders/' . $slider->image );
            }

        } else {
            $imageName = $slider->image;
        }

        $slider->update( array(
            'title'    => $this->title,
            'subtitle' => $this->subtitle,
            'price'    => $this->price,
            'link'     => $this->link,
            'image'    => $imageName,
            'status'   => $this->status,
        ) );

        session()->flash( 'success_message', 'HomeSlider has been updated successfully!' );

    }

    public function render() {
        return view( 'livewire.admin.home-slider.admin-edit-home-slider-component' )
            ->layout( 'layouts.base' );
    }

}

<?php

namespace App\Http\Livewire\Admin\HomeSlider;

use App\Models\HomeSlider;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminAddHomeSliderComponent extends Component {

    use WithFileUploads;

    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $image;
    public $status;

    protected $rules = array(
        'title'    => 'required',
        'subtitle' => 'required',
        'price'    => 'required',
        'link'     => 'required',
        'image'    => 'required',
        'status'   => 'required',
    );

    public function mount() {
        $this->status = 0;
    }

    public function storeSlide() {
        $this->validate();

        $imageName = uniqid() . '-' . $this->image->getClientOriginalName();
        $this->image->storeAs( 'sliders', $imageName );

        HomeSlider::create( array(
            'title'    => $this->title,
            'subtitle' => $this->subtitle,
            'price'    => $this->price,
            'link'     => $this->link,
            'image'    => $imageName,
            'status'   => $this->status,
        ) );

        session()->flash( 'success_message', 'HomeSlider has been added successfully!' );
    }

    public function render() {
        return view( 'livewire.admin.home-slider.admin-add-home-slider-component' )
            ->layout( 'layouts.base' );
    }
}

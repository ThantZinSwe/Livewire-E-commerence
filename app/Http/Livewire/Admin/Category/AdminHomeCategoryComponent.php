<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use App\Models\HomeCategory;
use Livewire\Component;

class AdminHomeCategoryComponent extends Component {

    public $selected_categories = array();
    public $number_of_products;

    protected $rules = array(
        'number_of_products' => 'required',
    );

    public function mount() {
        $homeCategory = HomeCategory::find( 1 );
        $this->selected_categories = explode( ',', $homeCategory->sel_categories );
        $this->number_of_products = $homeCategory->no_of_products;
    }

    public function updateHomeCategories() {
        $this->validate();

        $homeCategory = HomeCategory::find( 1 );
        $homeCategory->sel_categories = implode( ',', $this->selected_categories );
        $homeCategory->no_of_products = $this->number_of_products;
        $homeCategory->save();
        session()->flash( 'success_message', 'HomeCategory has been updated successfully!' );
    }

    public function render() {
        $categories = Category::all();
        return view( 'livewire.admin.category.admin-home-category-component', array( 'categories' => $categories ) )
            ->layout( 'layouts.base' );
    }
}

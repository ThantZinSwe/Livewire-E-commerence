<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminAddSubcategory extends Component {

    public $name;
    public $slug;
    public $category_id;

    public function generateSlug() {
        $this->slug = Str::slug( $this->name );
    }

    protected $rules = array(
        'name'        => 'required',
        'slug'        => 'required',
        'category_id' => 'required',
    );

    public function store() {
        $this->validate();

        Subcategory::create( array(
            'name'        => $this->name,
            'slug'        => $this->slug,
            'category_id' => $this->category_id,
        ) );

        session()->flash( 'success_message', 'Subcategory has benn created successfully!' );
    }

    public function render() {
        $categories = Category::all();
        return view( 'livewire.admin.category.admin-add-subcategory', array( 'categories' => $categories ) )
            ->layout( 'layouts.base' );
    }
}

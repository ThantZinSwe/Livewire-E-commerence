<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminAddCategoryComponent extends Component {

    public $name;
    public $slug;

    public function generateSlug() {
        $this->slug = Str::slug( $this->name );
    }

    protected $rules = array(
        'name' => 'required',
        'slug' => 'required',
    );

    public function store() {
        $this->validate();

        Category::create( array(
            'name' => $this->name,
            'slug' => $this->slug,
        ) );

        session()->flash( 'success_message', 'Category has benn created successfully!' );
    }

    public function updated() {
        $this->validate( array( 'name' => 'unique:categories' ) );
    }

    public function render() {
        return view( 'livewire.admin.category.admin-add-category-component' )
            ->layout( 'layouts.base' );
    }
}

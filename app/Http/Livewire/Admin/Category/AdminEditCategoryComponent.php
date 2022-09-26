<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminEditCategoryComponent extends Component {

    public $category_id;
    // public $category_slug;
    public $name;
    public $slug;

    public function mount( $category_slug ) {
        // $this->category_slug = $category_slug;
        $category = Category::where( 'slug', $category_slug )->first();
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
    }

    protected $rules = array(
        'name' => 'required',
        'slug' => 'required',
    );

    public function generateSlug() {
        $this->slug = Str::slug( $this->name );
    }

    public function updateCategory() {
        $this->validate();

        $category = Category::findOrFail( $this->category_id );
        $category->update( array(
            'name' => $this->name,
            'slug' => $this->slug,
        ) );
        session()->flash( 'success_message', 'Category has benn updated successfully!' );
    }

    public function updated() {
        $this->validate( array( 'name' => 'unique:categories,name,' . $this->category_id ) );
    }

    public function render() {
        return view( 'livewire.admin.category.admin-edit-category-component' )
            ->layout( 'layouts.base' );
    }
}

<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminEditSubcategory extends Component {

    public $scategory_id;
    public $scategory_slug;
    public $name;
    public $slug;
    public $category_id;

    protected $rules = array(
        'name'        => 'required',
        'slug'        => 'required',
        'category_id' => 'required',
    );

    public function generateSlug() {
        $this->slug = Str::slug( $this->name );
    }

    public function mount( $scategory_slug ) {
        $scategory = Subcategory::where( 'slug', $scategory_slug )->first();
        $this->scategory_id = $scategory->id;
        $this->scategory_slug = $scategory_slug;
        $this->name = $scategory->name;
        $this->slug = $scategory->slug;
        $this->category_id = $scategory->category_id;
    }

    public function updateSubcategory() {
        $this->validate();

        $scategory = Subcategory::findOrFail( $this->scategory_id );
        $scategory->update( array(
            'name'        => $this->name,
            'slug'        => $this->slug,
            'category_id' => $this->category_id,
        ) );

        session()->flash( 'success_message', 'SubCategory has benn updated successfully!' );
    }

    public function render() {

        $categories = Category::all();

        return view( 'livewire.admin.category.admin-edit-subcategory', array( 'categories' => $categories ) )
            ->layout( 'layouts.base' );
    }
}

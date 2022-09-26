<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryComponent extends Component {
    use WithPagination;

    public function deleteCategory( $category_id ) {
        $category = Category::findOrFail( $category_id );

        foreach ( $category->subCategories->where( 'category_id', $category->id ) as $cid ) {
            $cid->first()->delete();
        }

        $category->delete();
        session()->flash( 'success_message', 'Category has been deleted successfully!' );
    }

    public function deleteSubCategory( $scategory_id ) {
        $scategory = Subcategory::findOrFail( $scategory_id );
        $scategory->delete();
        session()->flash( 'success_message', 'Sub Category has been deleted successfully!' );
    }

    public function render() {
        $categories = Category::paginate( 5 );
        return view( 'livewire.admin.category.admin-category-component', array( 'categories' => $categories ) )
            ->layout( 'layouts.base' );
    }

}

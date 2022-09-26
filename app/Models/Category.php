<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasFactory;

    protected $fillable = array( 'name', 'slug' );

    public function product() {
        return $this->hasMany( Product::class );
    }

    public function subCategories() {
        return $this->hasMany( Subcategory::class );
    }

    public function getRouteKeyName() {
        return 'slug';
    }
}

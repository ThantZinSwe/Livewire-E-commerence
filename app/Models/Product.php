<?php

namespace App\Models;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = array(
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'featured',
        'quantity',
        'image',
        'images',
        'category_id',
        'subcategory_id',
    );

    public function category() {
        return $this->belongsTo( Category::class );
    }

    public function orderItems() {
        return $this->hasMany( OrderItem::class );
    }

    public function subCategories() {
        return $this->belongsTo( Subcategory::class, 'subcategory_id' );
    }

    public function attributeValues() {
        return $this->hasMany( AttributeValue::class, 'product_id' );
    }
}

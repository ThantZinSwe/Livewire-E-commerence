<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model {
    use HasFactory;

    protected $fillable = array(
        'name',
        'slug',
        'category_id',
    );

    public function category() {
        return $this->belongsTo( Category::class );
    }
}

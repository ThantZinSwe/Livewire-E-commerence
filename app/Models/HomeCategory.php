<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCategory extends Model {
    use HasFactory;

    protected $fillable = array('sel_categories', 'no_of_products');
}

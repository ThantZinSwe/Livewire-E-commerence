<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model {
    use HasFactory;

    protected $fillable = array('title', 'subtitle', 'price', 'link', 'image', 'status');
}

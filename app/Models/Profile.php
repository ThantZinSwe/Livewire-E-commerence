<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model {
    use HasFactory;

    protected $fillable = array(
        'user_id',
        'image',
        'mobile',
        'line1',
        'line2',
        'city',
        'province',
        'country',
        'zipcode',
    );
}

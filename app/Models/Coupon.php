<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
    use HasFactory;

    protected $fillable = array( 'code', 'type', 'value', 'cart_value', 'expiry_date' );
}

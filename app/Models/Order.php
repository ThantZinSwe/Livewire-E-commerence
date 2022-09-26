<?php

namespace App\Models;

use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = array(
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'firstname',
        'lastname',
        'mobile',
        'email',
        'line1',
        'line2',
        'city',
        'province',
        'country',
        'zipcode',
        'status',
        'is_shipping_different',
        'delivered_date',
        'canceled_date',
    );

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function orderItems() {
        return $this->hasMany( OrderItem::class );
    }

    public function shipping() {
        return $this->hasOne( Shipping::class );
    }

    public function transaction() {
        return $this->hasOne( Transaction::class );
    }
}

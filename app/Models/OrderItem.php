<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    use HasFactory;

    protected $fillable = array(
        'product_id',
        'order_id',
        'price',
        'quantity',
        'rstatus',
    );

    public function order() {
        return $this->belongsTo( Order::class );
    }

    public function product() {
        return $this->belongsTo( Product::class );
    }

    public function review() {
        return $this->hasOne( Review::class, 'order_item_id' );
    }
}

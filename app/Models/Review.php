<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    use HasFactory;

    protected $fillable = array(
        'order_item_id',
        'rating',
        'comment',
    );

    public function orderItem() {
        return $this->belongsTo( OrderItem::class );
    }
}

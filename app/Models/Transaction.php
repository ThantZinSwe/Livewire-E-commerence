<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    use HasFactory;

    protected $fillable = array(
        'user_id',
        'order_id',
        'mode',
        'status',
    );

    public function order() {
        return $this->belongsTo( Order::class );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model {
    use HasFactory;

    protected $fillable = array(
        'product_attribute_id',
        'value',
        'product_id',
    );

    public function productAttribute() {
        return $this->belongsTo( productAttribute::class, 'product_attribute_id' );
    }
}

<?php

namespace App\Models;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model {
    use HasFactory;

    protected $fillable = array( 'name' );

    public function attributeValues() {
        return $this->hasMany( AttributeValue::class );
    }
}

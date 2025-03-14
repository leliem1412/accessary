<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'product_stock';

    public function product(): HasOne {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function user(): HasOne {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    public static $codePrefix = 'SP0000';
    protected $fillable = [
        'product_name',
        'image',
        'product_category',
        'price',
        'quantity',
        'product_code',
    ];

    public function getQuantityAttribute() {
        $productId = $this->id;

        $importStock = ProductStock::where('product_id', $productId)
            ->where('stock_type', 'import')
            ->sum('quantity');

        $exportStock = ProductStock::where('product_id', $productId)
            ->where('stock_type', 'export')
            ->sum('quantity');

        $quantity = $importStock - $exportStock;

        return $quantity;
    }
}

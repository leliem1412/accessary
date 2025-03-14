<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'salesorder';
    public static $codePrefix = 'DH0000';
    
    public function customer(): HasOne 
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function user(): HasOne 
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }

    public function paymentHistory(): HasMany 
    {
        return $this->hasMany(OrderPaymentHistory::class, 'salesorder_id', 'id');
    }

    public function getTotalPaymentAmountAttribute() 
    {
        $totalPaymentAmount = OrderPaymentHistory::where('salesorder_id', $this->id)
            ->where('customer_id', $this->customer_id)
            ->sum('amount');

        return $totalPaymentAmount;
    }

    public function getInventoyAttribute() 
    {
        $productInventory = Inventory::join('products', 'products.id', '=', 'inventory.lineitem_id')
            ->where('inventory.module', 'SalesOrder')
            ->where('inventory.module_id', $this->id)
            ->where('inventory.lineitem_type', 'product')
            ->get(['inventory.id', 'products.product_code as entry_code', 'products.product_name as entry_name', 'inventory.quantity', 'inventory.price as order_price', 'products.price', 'inventory.lineitem_type as entry_type'])
            ->toArray();
        
        $serviceInventory = Inventory::join('services', 'services.id', '=', 'inventory.lineitem_id')
            ->where('inventory.module', 'SalesOrder')
            ->where('inventory.module_id', $this->id)
            ->where('inventory.lineitem_type', 'service')
            ->get(['inventory.id', 'services.service_code as entry_code', 'services.service_name as entry_name', 'inventory.quantity', 'inventory.price as order_price', 'services.price', 'inventory.lineitem_type as entry_type'])
            ->toArray();

        $inventory = array_merge($productInventory, $serviceInventory);

        return $inventory;
    }
}
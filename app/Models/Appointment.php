<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointment';

    protected $fillable = [
        'notified'  
    ];

    public function customer(): HasOne {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function service(): HasOne {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function employee(): HasOne {
        return $this->hasOne(Employee::class, 'id', 'created_by_id');
    }
}

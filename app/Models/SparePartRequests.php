<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePartRequests extends Model
{
    use HasFactory;
    protected $table = 'spare_part_requests';
    protected $fillable = ['request_no', 'customer_id', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function items()
    {
        return $this->hasMany(SparePartRequestItems::class, 'spare_part_request_id');
    }
}

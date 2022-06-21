<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePartRequestItems extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'spare_part_request_items';
    protected $fillable = ['spare_part_request_id', 'customer_lineup_machine_id', 'spare_part_id', 'quantity', 'price'];

    public function sparePartRequest()
    {
        return $this->belongsTo(SparePartRequests::class, 'spare_part_request_id');
    }
    public function customerLineupMachine()
    {
        return $this->belongsTo(CustomerLineupMachines::class, 'customer_lineup_machine_id')->with('machine');
    }
    public function sparePart()
    {
        return $this->belongsTo(SpareParts::class, 'spare_part_id');
    }
}

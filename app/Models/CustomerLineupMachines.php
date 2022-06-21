<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLineupMachines extends Model
{
    use HasFactory;

    protected $table = 'customer_lineup_machines';
    public $timestamps = false;
    protected $fillable = ['customer_lineup_id', 'machine_id', 'serial_number', 'register_date'];

    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machine_id');
    }
    public function customerLineup()
    {
        return $this->belongsTo(CustomerLineups::class, 'customer_lineup_id');
    }
}

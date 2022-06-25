<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLineups extends Model
{
    use HasFactory;

    protected $table = 'customer_lineups';
    public $timestamps = false;
    protected $fillable = ['customer_id', 'lineup_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function lineups() {
        return $this->belongsTo(Lineups::class, 'lineup_id');
    }
    public function machines()
    {
        return $this->belongsToMany(Machines::class, 'customer_lineup_machines', 'customer_lineup_id', 'machine_id')->withPivot('id', 'serial_number', 'register_date')->orderBy('serial_number', 'asc');
    }
}

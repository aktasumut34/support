<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineSpareParts extends Model
{
    use HasFactory;

    protected $table = 'machine_spare_parts';
    public $timestamps = false;
    protected $fillable = ['machine_id', 'spare_part_id'];

    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machine_id');
    }
    public function sparePart()
    {
        return $this->belongsTo(SpareParts::class, 'spare_part_id');
    }
}

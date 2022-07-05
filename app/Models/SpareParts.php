<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpareParts extends Model
{
    use HasFactory;

    protected $table = 'spare_parts';
    public $timestamps = false;
    protected $fillable = ['name', 'name_english', 'code', 'machine_id', 'size' ,'image'];

    public function machine()
    {
        return $this->belongsToMany(Machines::class, 'machine_spare_parts', 'spare_part_id', 'machine_id');
    }
}

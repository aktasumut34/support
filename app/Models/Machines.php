<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machines extends Model
{
    use HasFactory;

    protected $table = 'machines';
    public $timestamps = false;
    protected $fillable = ['name', 'name_english' , 'code', 'image'];

    public function spare_parts()
    {
        return $this->belongsToMany(SpareParts::class, 'machine_spare_parts', 'machine_id', 'spare_part_id');
    }
    public function documents()
    {
        return $this->hasMany(MachineDocuments::class, 'machine_id');
    }
}

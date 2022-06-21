<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineDocuments extends Model
{
    use HasFactory;

    protected $table = 'machine_documents';
    public $timestamps = false;

    protected $fillable = ['machine_id', 'type', 'name', 'path'];

    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machine_id');
    }
}

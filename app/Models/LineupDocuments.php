<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineupDocuments extends Model
{
    use HasFactory;

    protected $table = 'lineup_documents';
    public $timestamps = false;

    protected $fillable = ['lineup_id', 'type', 'name', 'path'];

    public function lineup()
    {
        return $this->belongsTo(Lineups::class, 'lineup_id');
    }
}

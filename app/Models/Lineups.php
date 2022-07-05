<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lineups extends Model
{
    use HasFactory;
    protected $table = 'lineups';
    public $timestamps = false;
    protected $fillable = ['name', 'name_english', 'code'];
}

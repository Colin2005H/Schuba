<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiateur extends Model
{
    use HasFactory;

    protected $fillable = ['uti_id'];

    protected $table = 'PLO_INITIATEUR';
    public $timestamps = false;
    protected $primaryKey = 'uti_id';
}

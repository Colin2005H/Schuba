<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = ['uti_id'];

    protected $table = 'plo_eleve';
    public $timestamps = false;
    protected $primaryKey = 'uti_id';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $table = 'plo_eleve';
    public $timestamps = false;

    protected $primaryKey = "UTI_ID";
}

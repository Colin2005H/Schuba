<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $table = 'plo_eleve';
    public $timestamps = false;

    //  NE PAS METTRE DE CLE PRIMAIRE
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;
    protected $table = 'PLO_FORMATION';
    protected $primarykey = 'FORM_NIVEAU';
}

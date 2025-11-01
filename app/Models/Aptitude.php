<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aptitude extends Model
{
    use HasFactory;

    protected $table = 'PLO_APTITUDE';
    public $timestamps = false;

    public $incrementing = false;
    protected $primaryKey = "APT_CODE";
    protected $keyType = 'string';


}

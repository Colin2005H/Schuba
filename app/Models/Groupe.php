<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $table = 'GROUPER';
    public $timestamps = false;

    //  NE PAS METTRE DE CLE PRIMAIRE

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'SEA_ID',
        'UTI_ID_INITIATEUR',
        'UTI_ID',
        'GRP_PRESENCE'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Eleve extends Model
{
    use HasFactory;

    protected $table = 'plo_eleve';
    public $timestamps = false;

    protected $primaryKey = "UTI_ID";

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'UTI_ID', 'UTI_ID');
    }
}

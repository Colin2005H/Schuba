<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Initiator extends Model
{
    use HasFactory;
    protected $table = 'PLO_INITIATEUR';
    protected $primarykey = 'UTI_ID';

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'UTI_ID', 'UTI_ID');
    }
}

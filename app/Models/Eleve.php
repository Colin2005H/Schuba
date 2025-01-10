<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;


class Eleve extends Model
{
    use HasFactory;


    protected $fillable = ['uti_id'];

    protected $table = 'PLO_ELEVE';
    public $timestamps = false;
    protected $primaryKey = "UTI_ID";

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'UTI_ID', 'UTI_ID');
    }

    public function getInitiator(int $seance_id) {
        $id = DB::table('PLO_INITIATEUR') 
            ->join('GROUPER', 'PLO_INITIATEUR.UTI_ID', '=', 'GROUPER.UTI_ID_INITIATEUR') 
            ->join('PLO_ELEVE', 'GROUPER.UTI_ID', '=', 'PLO_ELEVE.UTI_ID') 
            ->join('PLO_SEANCE', 'GROUPER.SEA_ID', '=', 'PLO_SEANCE.SEA_ID') 
            ->where('PLO_ELEVE.UTI_ID', '=', $this->UTI_ID)
            ->where('PLO_SEANCE.SEA_ID', '=', $seance_id)
            ->pluck('PLO_INITIATEUR.UTI_ID');

        $initiator = Initiator::whereIn('UTI_ID', $id)->get();

        return $initiator;
    }

}

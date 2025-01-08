<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $fillable = ['clu_id', 'uti_id','uti_nom','uti_prenom', 'uti_mail', 'uti_mdp', 'uti_niveau', 'uti_date_naissance', 'uti_date_creation', 
                           'uti_date_certificat', 'uti_code_postal', 'uti_adresse', 'uti_ville'];

    use HasFactory;
    protected $table = 'plo_utilisateur';
    public $timestamps = false;
    protected $primaryKey = 'uti_id';
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uti_nom',
        'uti_mail',
        'uti_mdp',
    ];

//table //primary key

    protected $table = 'PLO_UTILISATEUR';

    protected $primaryKey = 'uti_id';


     
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'uti_mdp',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

public function getAuthPassword()
{
    return $this->UTI_MDP;
}




    public function getRole(){

        $countELEVE = DB::table('PLO_UTILISATEUR') ->join('PLO_ELEVE', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_ELEVE.UTI_ID') 
            ->where('PLO_UTILISATEUR.UTI_MAIL', '=', $this->UTI_MAIL) ->count();

            if($countELEVE > 0){
                return 'eleve';
            }

        $countINIT = DB::table('PLO_UTILISATEUR') 
            ->join('PLO_INITIATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
            ->join('GERER_LA_FORMATION', 'PLO_UTILISATEUR.UTI_ID', '=', 'GERER_LA_FORMATION.UTI_ID') 
            ->where('PLO_UTILISATEUR.UTI_MAIL', '=', $this->UTI_MAIL) ->count();


            if($countINIT > 0){
                return 'initiateur';
            }

        $countDT = DB::table('PLO_UTILISATEUR') 
            ->join('PLO_INITIATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
            ->join('DIRIGER_LE_CLUB', 'PLO_UTILISATEUR.UTI_ID', '=', 'GERER_LA_FORMATION.UTI_ID') 
            ->where('PLO_UTILISATEUR.UTI_MAIL', '=', $this->UTI_MAIL) ->count();

            if($countDT > 0){
                return 'directeur_technique';
            }
       

        return 'inconnu';

    }


}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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




    public function getRole($email){

        $countINIT = DB::table('PLO_UTILISATEUR') 
            ->join('PLO_INITIATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
            ->join('GERER_LA_FORMATION', 'PLO_UTILISATEUR.UTI_ID', '=', 'GERER_LA_FORMATION.UTI_ID') 
            ->where('PLO_UTILISATEUR.UTI_MAIL', '=', $email) ->count();

        $countDT = DB::table('PLO_UTILISATEUR') 
            ->join('PLO_INITIATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
            ->join('DIRIGER_LE_CLUB', 'PLO_UTILISATEUR.UTI_ID', '=', 'GERER_LA_FORMATION.UTI_ID') 
            ->where('PLO_UTILISATEUR.UTI_MAIL', '=', $email) ->count();

        $countELEVE = DB::table('PLO_UTILISATEUR') ->join('PLO_ELEVE', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_ELEVE.UTI_ID') 
            ->where('PLO_UTILISATEUR.UTI_MAIL', '=', $email) ->count();

        if($countINIT > 0){
            return 'initiateur';
        }
        if($countDT > 0){
            return 'directeur_technique';
        }
        if($countELEVE > 0){
            return 'eleve';
        }

        

    }


}

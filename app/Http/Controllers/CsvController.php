<?php

namespace App\Http\Controllers;

use App\Models\PloUtilisateur;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function createCsvUser() {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sample.csv"');
        $query = PloUtilisateur::query();
        $users = $query->get();//json_decode(file_get_contents('http://127.0.0.1:8000/api/user'), true);
        $csv = fopen('php://output', 'wb');
    
        $headers = ['uti_id', 'clu_id', 'uti_nom', 'uti_prenom', 'uti_mail', 'uti_niveau', 'uti_date_creation', 'uti_date_naissance'];
        fputcsv($csv, $headers);
        
        foreach ($users as $user) {
            $row = [
                $user['UTI_ID'],
                $user['CLU_ID'],
                $user['UTI_NOM'],
                $user['UTI_PRENOM'],
                $user['UTI_MAIL'],
                $user['UTI_NIVEAU'],
                $user['UTI_DATE_CREATION'],
                $user['UTI_DATE_NAISSANCE']
            ];
            fputcsv($csv, $row);
        }
        fclose($csv);
    }
}

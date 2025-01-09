<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PloUtilisateur;
use Illuminate\Support\Facades\DB;

class CsvController extends Controller {
    /*
    public function createCsvUser() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user'])) {
            $id_user = 1;
        } else {
            $id_user = $_SESSION['user']->UTI_ID;
        }   

        $query = PloUtilisateur::query();
        $query->where('UTI_ID', $id_user);
        $club = $query->get()->first()->CLU_ID;

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="user.csv"');
        $query = DB::table('utilisateur_aptitude');
        $query->where('club', $club);
        $users = $query->get();
        $csv = fopen('php://output', 'wb');
    
        $headers = ['id', 'id_aptitude', 'aptitude', 'valide', 'nom', 'prenom', 'mail', 'date_creation_compte', 'date_naissance', 'niveau'];
        fputcsv($csv, $headers);
        
        foreach ($users as $user) {
            $row = [
                $user['id'],
                $user['id_aptitude'],
                $user['aptitude'],
                $user['valide'],
                $user['nom'],
                $user['prenom'],
                $user['mail'],
                $user['date_creation_compte'],
                $user['date_naissance'],
                $user['niveau']
            ];
            fputcsv($csv, $row);
        }
        fclose($csv);
    }*/

    public function createCsvUser() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if the 'user' session exists and set user ID accordingly
        if (!isset($_SESSION['user'])) {
            $id_user = 1; // Default user ID if session doesn't exist
        } else {
            $id_user = $_SESSION['user']->UTI_ID; // Assuming 'user' is an object with 'UTI_ID'
        }   
    
        // Query to get the club associated with the user
        $query = PloUtilisateur::query();
        $query->where('UTI_ID', $id_user);
        $club = $query->get()->first()->CLU_ID;
    
        // Set CSV headers for file download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="user.csv"');
    
        // Query to get users based on the club ID
        $query = DB::table('utilisateur_aptitude');
        $query->where('CLUB', $club);
        $users = $query->get();
    
        // Open PHP output stream for writing CSV
        $csv = fopen('php://output', 'wb');
    
        // Define CSV headers
        $headers = ['id', 'id_aptitude', 'aptitude', 'valide', 'nom', 'prenom', 'mail', 'date_creation_compte', 'date_naissance', 'niveau'];
        fputcsv($csv, $headers);
    
        // Loop through the users and write each one to the CSV
        foreach ($users as $user) {
            $row = [
                $user->id, // Access the properties of the object with -> (not $user['id'])
                $user->id_aptitude,
                $user->aptitude,
                $user->valide,
                $user->nom,
                $user->prenom,
                $user->mail,
                $user->date_creation_compte,
                $user->date_naissance,
                $user->niveau
            ];
            fputcsv($csv, $row);
        }
    
        // Close the CSV stream
        fclose($csv);
    }
    
}

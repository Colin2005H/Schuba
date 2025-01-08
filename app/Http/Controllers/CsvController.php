<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function createCsvUsersFromApi()
    {
        $users = json_decode(file_get_contents('http://127.0.0.1:8000/api/user'), true);
        $csv = fopen('users.csv', 'w');
    
        $headers = ['u_id', 'c_id', 'name', 'firstname', 'email', 'level', 'creation_date', 'birth_date'];
        fputcsv($csv, $headers);
        
        foreach ($users as $user) {
            $row = [
                $user['u_id'],
                $user['c_id'],
                $user['name'],
                $user['firstname'],
                $user['email'],
                $user['level'],
                $user['creation_date'],
                $user['birth_date']
            ];
            fputcsv($csv, $row);
        }
        fclose($csv);
        return response()->download('users.csv');
    }
}

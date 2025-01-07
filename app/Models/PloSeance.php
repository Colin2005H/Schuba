<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PloSeance extends Model
{
    use HasFactory;

    /**
     * Stock une nouvelle séance dans la BDD
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request...

        $seance = new PloSeance;

        $seance->form_niveau = $request->name;

        $seance->save();

        return redirect('/flights');
    }
}

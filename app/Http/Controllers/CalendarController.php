<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getGroupByIdSession($id){

        const response = await fetch(`/api/location?id=${id}`);





    }
}

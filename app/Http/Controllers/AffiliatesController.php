<?php

namespace App\Http\Controllers;

use App\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AffiliatesController extends Controller
{
    /**
     * Display the specified resource.
     * 
     * @return array
     */
    public function show()
    {
        //Check to see if we have the file in our system
        $data = str_replace('\n', ',', json_encode(Storage::get('affiliates.txt'), true));
        $affiliates = json_decode($data, true);

        return $affiliates;
        //Read the file and save in a Collection Array

        //
    }
}

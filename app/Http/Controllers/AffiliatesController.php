<?php

namespace App\Http\Controllers;

use App\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AffiliatesController extends Controller
{
    /**
     * Display the specified resource.
     * 
     * @return array
     */
    public function show()
    {
        $affiliatesArray = [];

        // Get the contents of the JSON file and return an array of Objects
        $affiliatesArrayFromFile = $this->getAffiiatesFromFile();

        //Check to see if we have something returned from the file. If not, stop running the code. 
        if (!isset($affiliatesArrayFromFile) || empty($affiliatesArrayFromFile) || !is_array($affiliatesArrayFromFile)) {
            //Using an abort here. Under normal circumstances, would be returning a customized error messagel 
            Log::error("Nothing was returned from the file");
            abort(404);
        }

        //Loop Over the array, check distance from office, instantiate Affiliate object and store in array. 
        if (isset($affiliatesArrayFromFile) && !empty($affiliatesArrayFromFile) && is_array($affiliatesArrayFromFile)) {
            $affiliatesArray[] = array_map(function ($affiliate) {
                //exeute calculation and return true/false 
                $isWithinDistance = $this->checkDistanceFromOffice(config('app.dublin_office_latitude'), config('app.dublin_office_longitude'), $affiliate->latitude, $affiliate->longitude);
                
                //create new instance of Affiliate if within Distance and add to the array
                if ($isWithinDistance) {
                    $affiliateObject = new Affiliate($affiliate->affiliate_id, $affiliate->name, $affiliate->latitude, $affiliate->longitude);
                    return $affiliateObject;
                }
            }, $affiliatesArrayFromFile);            
        }

        //Remove null values from the Array then sort the array
        if (isset($affiliatesArray[0]) && !empty($affiliatesArray[0]) && is_array($affiliatesArray[0])) {
            return view('affiliate', ['affiliates' => $this->sortArray(array_filter($affiliatesArray[0]))]);
        }

        //Return nothing
        return abort(404);
    }

    /**
     * Get Affiliates fron the file by reading each line individually. 
     * Then filter, decode and save in an array
     * 
     * @return array
     */
    public function getAffiiatesFromFile() {

        $data = [];
        if ($file = fopen(base_path() . config('app.file'), "r")) {
            while(!feof($file)) {
                $line = fgets($file);

                //remove unwanted chars from the line returned
                $filteredData = $this->removeSpecialChar($line);

                //decode filtered line to json object and add to the end of the array
                $jsonObject = json_decode(trim($filteredData));
                $data[] = $jsonObject;
            }
            fclose($file);
        }

        if (empty($data)) {
            return '/';
        }
        return $data;
    }

    /**
     * Function to remove the spacial chars in the string e.g  '[', ']', '\n'
     * 
     * @return array
     */
    public function removeSpecialChar($str) {
      
        $res = str_replace( array( '\n', '[',  ']'), '', $str);
        
        // Returning the result 
        return $res;
    }

    /**
     * Check that affiliatae is within 100km of the office
     * Returns true if it is, or false if it isn't. 
     * 
     * @return boolean
     */
    public function checkDistanceFromOffice($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'kilometers') {
        $theta = $longitude1 - $longitude2; 
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
        $distance = acos($distance); 
        $distance = rad2deg($distance); 
        $distance = $distance * 60 * 1.1515; 
        switch($unit) { 
            case 'miles': 
            break; 
            case 'kilometers' : 
            $distance = $distance * 1.609344; 
        } 

        if (round($distance,2) <= 100) {
            return true;
        }

        return false;
    }

    /**
     * Function to sort the Array by Affiliate_id in an ascending manner
     * 
     * @return array
     */
    private function sortArray($affiliates) {
        $temp = 0;
        $reindexedArray = array_values($affiliates);

        for ($i = 0; $i < count($reindexedArray); $i++) {
            for ($j = 0; $j < count($reindexedArray) - 1; $j++) {
                if($reindexedArray[$j] > $reindexedArray[$j + 1]) {
                    $temp = $reindexedArray[$j];
                    $reindexedArray[$j] = $reindexedArray[$j + 1];
                    $reindexedArray[$j+1] = $temp;
                }
            }
        }

        //returns the array sorted in asc order for the affiliate_id
        return $reindexedArray;
    }
}

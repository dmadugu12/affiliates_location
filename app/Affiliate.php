<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    //
    public $affiliate_id;
    public $name;
    public $longitude;
    public $latitude;

    public function __construct($affiliate_id, $name, $latitude, $longitude) {
        $this->affiliate_id = $affiliate_id;
        $this->name = $name;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }


}

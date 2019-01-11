<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait

class Clarion extends Model
{
    //
	protected $start_date = '1801-01-01'; 

    public function getCurrentDate($datenow){ //Carbon $datenow
    	$start = Carbon::parse($this->start_date);
    	$diff = $datenow->diffInDays($start) + 4;
    	return $diff;
    }
}

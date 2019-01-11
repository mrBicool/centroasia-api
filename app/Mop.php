<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait

class Mop extends Model
{
	use Eloquence, Mappable;
    //
    protected $table 		= 'mop';
    public $timestamps 		= false; 

    //mapping
     protected $maps = [
      	// simple alias
      	''    => ''
    ];
}

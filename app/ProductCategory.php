<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait
use Sofa\Eloquence\Mutable; // extension trait


class ProductCategory extends Model
{
    use Eloquence, Mappable, Mutable;
    // 
    protected $table 		= 'category';
    protected $primaryKey 	= 'CATCODE';

    //mapping
    protected $maps = [ 
      // simple alias
      'category_code'       => 'CATCODE',
      'category_name'       => 'CATNAME',
      'category_abbr'       => 'CATABBR'
    ];

    /**
     * Attributes getter mutators @ Eloquence\Mutable
     *
     * @var array
     */
    protected $getterMutators = [
        'category_name'     => 'trim'
    ];


    /*----------  logic  ----------*/
    public static function getProductCategories(){
    	return static::select(
    		'category_code',
    		'category_name',
    		'category_abbr'
    	)->orderBy('category_name')->get();
    }
}

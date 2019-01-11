<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait

class Cart extends Model
{
    use Eloquence, Mappable;
    // 

    //mapping
     protected $maps = [
      // simple alias
      //''    => ''
    ];

    /*----------  relationship  ----------*/
    public function part(){
        return $this->belongsTo('App\Product','product_id')->select('PRODCODE','UNITPRICE','DESCRIPTION');
    }
    

    /*----------  logic  ----------*/
    public static function findByUserAndProduct($user_id,$product_id){
    	return  static::where('account_id',$user_id) 
    				->where('product_id',$product_id) 
                    ->first();
    }

    public static function findByUser($user_id){
    	return  static::with('part')
                    ->where('account_id',$user_id)  
                    ->get();
    }

    public static function removeCartByUserID($user_id){
    	return static::where('account_id', $user_id)->delete();
    }

}

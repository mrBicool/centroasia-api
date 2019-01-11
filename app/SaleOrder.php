<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait

class SaleOrder extends Model
{
	use Eloquence, Mappable;
    //
    protected $table        =   'salesord';
    protected $primaryKey   =   'ORDNUM';
    public $timestamps = false;

    //mapping
    protected $maps = [ 
      // simple alias
        'reference_date'    => 'REFDATE',
        'account_code'      => 'ACCTCODE',
        'account_name'      => 'ACCTNAME',
        'order_number'      => 'ORDNUM',
        'net_amount' 		=> 'NETAMOUNT',
        'created_at'		=> 'CREATED_AT',
        'status' 			=> 'STATUS', 
        'ware_code' 		=> 'WARECODE',
        'area_code'         => 'AREACODE',
        'emp_code'          => 'EMPCODE',
        'emp_name'          => 'EMPNAME',
        'terms'             => 'TERMS',
        'mop_id'            => 'MOP_ID'
    ];

    /*----------  logic  ----------*/
    public static function findByUserID($user_id){  //return list of products
    	return static::select(
    		'order_number',
    		'net_amount',
    		'created_at',
    		'status'
    	)  
    			->where('account_code',$user_id)
    			->orderBy('created_at','desc') 
		        ->simplePaginate(10);
    }

    public static function findByUserIDAndID($user_id,$order_id){  //return list of products
    	return static::select(
    		'ORDNUM',
    		'NETAMOUNT',
    		'CREATED_AT',
    		'STATUS'
    	)  
    			->where('ACCTCODE',$user_id)
    			->where('ORDNUM',$order_id) 
		        ->first(); 
    }
 
}

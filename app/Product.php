<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait

class Product extends Model
{
    use Eloquence, Mappable;
    //
    protected $table        =   'products';
    protected $primaryKey   =   'PRODCODE';
    public $timestamps = false;
 
    //mapping
    protected $maps = [ 
      // simple alias
      'unit_price'      => 'UNITPRICE',
      'description'     => 'DESCRIPTION',
      'product_code'    => 'PRODCODE',
      'part_number'     => 'PARTNUM',
      'bar_code'        => 'BARCODE',
      'category_code'   => 'CATCODE',
      'bin_number'      => 'BINNUMBER',
      'qty_reserve'     => 'QTYRES',
      'qty_balance'     => 'QTYBAL',
      'qty_available'   => 'QTYAVAILABLE'
    ];


    /*----------  logic  ----------*/
    public static function scopeGetProductByDescriptionAndCategoryId($query,$description,$category_id){  //return list of products
        if($category_id == '' || $category_id == null || $category_id == 0){
            return $query->select(
                'products.PRODCODE',
                DB::raw('LTRIM(RTRIM(products.DESCRIPTION)) as DESCRIPTION'), 
                'prodbar.UNITPRICE',
                'products.IMG_PATH')
                    ->join('prodbar', 'products.PRODCODE', '=', 'prodbar.PRODCODE')
                    ->where('products.DESCRIPTION','like', '%'.$description.'%')
                    ->where('prodbar.CONTENTS',1)
                    ->orderBy('products.DESCRIPTION');
        }

        return $query->select(
                'products.PRODCODE',
                DB::raw('LTRIM(RTRIM(products.DESCRIPTION)) as DESCRIPTION'), 
                'prodbar.UNITPRICE',
                'products.IMG_PATH')
                    ->join('prodbar', 'products.PRODCODE', '=', 'prodbar.PRODCODE')
                    ->where('products.DESCRIPTION','like', '%'.$description.'%')
                    ->where('products.CATCODE',$category_id)
                    ->where('prodbar.CONTENTS',1) 
                    ->orderBy('products.DESCRIPTION');
    }

    public static function findById($id){  //return list of products
    	return static::select(
            'products.PRODCODE',
            'products.PARTNUM',
            'products.CATCODE',
            'products.DESCRIPTION',
            'products.BINNUMBER',
            'products.QTYBAL',
            'products.QTYRES',
            'products.QTYAVAILABLE',
            'prodbar.UNITPRICE',
            'prodbar.BARCODE'
        )
    			->join('prodbar', 'products.PRODCODE', '=', 'prodbar.PRODCODE')
    			->where('products.PRODCODE',$id)
    			->where('prodbar.CONTENTS',1)
    			->first();
    }
}

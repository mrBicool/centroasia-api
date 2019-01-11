<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait

class SaleOrderDetail extends Model
{
      use Eloquence, Mappable;
    //
    protected $table        =   'sordet'; 
    public $timestamps = false;

    protected $maps = [ 
      // simple alias
      'transaction_number'    => 'TRANNUM',
      'reference_number'      => 'REFERENCENO', 
      'order_number'          => 'ORDNUM',
      'description'           => 'DESCRIPTION',
      'unit_price'            => 'UNITPRICE',
      'order_qty'             => 'ORDQTY',
      'net_price'             => 'NETPRICE',
      'part_number'           => 'PARTNUM',
      'line_number'           => 'LINENUM',
      'reference_date'        => 'REFDATE',
      'account_code'          => 'ACCTCODE',
      'product_code'          => 'PRODCODE',
      'category_code'         => 'CATCODE',
      'unit_code'             => 'UNITCODE',
      'bar_code'              => 'BARCODE',
      'unit_measurement'      => 'UNITMEAS',
      'contents'              => 'CONTENTS',
      'warehouse_code'        => 'WARECODE',
      'bin_number'            => 'BINNUMBER',
      'area_code'             => 'AREACODE',
      'supp_code'             => 'SUPPCODE',
      'year_number'           => 'YEARNO',
      'month_number'          => 'MONTHNO',

    ];

    public static function findByOrdnum($sales_order_id){  //return Sales Order Details
      return static::where('ORDNUM',$sales_order_id) 
                  ->get([
                        'DESCRIPTION',
                        'UNITPRICE',
                        'ORDQTY',
                        'NETPRICE',
                        'PARTNUM' 
                  ]); 
    }
}

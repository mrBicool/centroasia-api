<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use App\Transformers\ProductCategoryTransformer;

class ProductCategoryController extends Controller
{
    //
    public function list(Request $request){
    	$product_category = ProductCategory::getProductCategories();

    	if($product_category->isEmpty()){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'No Product category.'
    		],200);
    	}

        $pct = new ProductCategoryTransformer;
        $pct->categories($product_category); 
        
    	return response()->json([
    			'success'		=> 		true, 
    			'message'		=> 		'Product list.',
    			'data'			=> 		$product_category
    		],200);
    }
}

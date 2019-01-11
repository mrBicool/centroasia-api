<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;

class ProductController extends Controller
{
    //
    public function list(Request $request){ 
    	$desc      = $request->description; //if null display all
        $category  = $request->category_id;

    	$token = $request->header('token');
    	$user  = User::findByToken($token);  

    	$products = Product::GetProductByDescriptionAndCategoryId($desc,$category);

        //------------------------------
        //SANDBOX
        $start = ($request->current_page * $request->per_page) - $request->per_page;
        $total_count = $products->get()->count();

        if($total_count>0){ 

            $total_page = intval($total_count / $request->per_page);
            $remainder =  $total_count % $request->per_page; 
            $total_master_page = $total_page;
            if($remainder > 0){ $total_master_page += 1; }
            $result_products = $products->skip($start)->take($request->per_page)->get();

             
            return response()->json([
                    'success'           =>  true, 
                    'message'           =>  'Results found',
                    'product_name'      =>  $request->description,
                    'total_count'       =>  $total_count,
                    'total_page'        =>  $total_master_page,
                    'first'             =>  1,
                    'last'              =>  $total_master_page,
                    'current_page'      =>  $request->current_page,
                    'base_url'          =>  url("/"),
                    'default_img'       =>  '/storage/products/default.png',
                    'surcharge'         =>  $user->sc,
                    'data'              =>  $result_products
            ],200); 
        }else{
            return response()->json([
                    'success'       =>   false, 
                    'message'       =>  'No Result found.', 
            ],200); 
        }
        // 
    }
}

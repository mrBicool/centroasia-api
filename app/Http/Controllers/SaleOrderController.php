<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use SoapBox\Formatter\Formatter;
use App\Cart;
use App\Product;
use App\SaleOrder;
use App\SaleOrderDetail;
use Carbon\Carbon;
use App\Clarion;
use App\User;
use Response;
use App\Mop;

class SaleOrderController extends Controller
{
    //
    public function create(Request $request){
        $mop_id= $request->mop_id;
    	$token = $request->header('token');
    	$user  = User::findByToken($token); 

    	$my_carts = Cart::findByUser($user->account_code); 

    	if($my_carts->isEmpty()){
    		return response()->json([
    			'success'		=> 		false, 
    			'message'		=> 		'You have no item in your cart.'
    		],200);
    	}

    	$c = array(); 
    	$total_amount = 0;
    	$counter = 0;
    	foreach($my_carts as $cart){
    		$p = Product::findById($cart->product_id);
            $unit_price = ($p->unit_price + $user->sc);

    		$amount = $cart->qty* $unit_price;
    		$total_amount +=  $amount;
    		$counter++;
    		$data = [
    			'counter'		=> $counter,
    			'product_id' 	=> $p->product_code,
    			'part_number'	=> trim($p->part_number),
    			'barcode' 		=> trim($p->bar_code),
    			'category_code'	=> trim($p->category_code),
    			'description'	=> trim($p->description),
    			'bin_number' 	=> trim($p->bin_number),
    			'qty' 			=> $cart->qty, 
    			'price'			=> $unit_price,
    			'amount'		=> $amount,
    		];
    		array_push($c , $data);
    	}  


        $now        = Carbon::now();
        $clarion    = new Clarion;
        $clarion    = $clarion->getCurrentDate($now);

    	//save to SaleOrder
    	$so = new SaleOrder;
    	$so->reference_date = $clarion;
    	$so->account_code 	= $user->account_code;
    	$so->account_name 	= $user->account_name;
    	$so->area_code 	    = $user->area_code;
    	$so->ware_code 	    = 'MAIN';
    	$so->emp_code	    = 0;
    	$so->emp_name 	    = '1 1';
    	$so->terms 		    = $user->terms;
    	$so->net_amount 	= $total_amount;
    	$so->created_at     = $now;
        $so->status         = '';
        $so->mop_id         = $mop_id;
    	$so->save();

    	if(!$so || is_null($so)){
    		return response()->json([
    			'success'		=> 	false, 
    			'message'		=> 	'Sale order saving failed.'
    		],200);
    	}


    	foreach ($c as $soi){ // $soi = Sale Order Item
    		# code...

            //mam cris given formula...
            $p = Product::findById((int)$soi['product_id']);
            $p->qty_reserve         = $p->qty_reserve + $soi['qty'];
            $p->qty_available       = $p->qty_balance - $p->qty_reserve; 
            $p->save();
            //

    		$sod = new SaleOrderDetail;
    		$sod->transaction_number 		= 0;
    		$sod->reference_number 	        = 0;
    		$sod->order_number 		        = $so->order_number;
    		$sod->line_number 		        = $soi['counter'];
    		$sod->reference_date 		    = $clarion;
    		$sod->product_code 		        = $soi['product_id'];
    		$sod->part_number 		        = $soi['part_number'];
    		$sod->category_code 		    = $soi['category_code'];
    		$sod->unit_code 		        = 0;
    		$sod->description 	            = $soi['description'];
    		$sod->bar_code 		            = $soi['barcode'];
    		$sod->unit_measurement 		    = 'PIECE';
    		$sod->contents 		            = 1;
    		$sod->order_qty 		        = $soi['qty'];
    		$sod->unit_price  	            = $soi['price'];
    		$sod->net_price 		        = $soi['amount'];
    		$sod->account_code 		        = $user->account_code; 
		    $sod->warehouse_code 		    = 'MAIN';
		    $sod->bin_number 	            = $soi['bin_number']; 
	      	$sod->area_code 		        = $user->area_code;
	      	$sod->supp_code 		        = 0;//ask ms cris for this if what table is this connected 
	      	$sod->year_number 		        = $now->year;
	      	$sod->month_number 		        = $now->month; 
	      	$sod->save();
    	}
        
        //remove items from cart
    	Cart::removeCartByUserID($user->account_code);

    	return response()->json([
    			'success'		=> 		true, 
    			'message'		=> 		'Order Success.'
    	],200);
    }

    public function salesOrderHistory(Request $request){
    	$token = $request->header('token');
    	$user  = User::findByToken($token); 
    	$so_history = SaleOrder::findByUserID($user->account_code);

    	if( $so_history->isEmpty() ){
    		return response()->json([
	    			'success'		=> 	false, 
	    			'message'		=> 	'No Record.'
	    	],200);
    	}

    	return response()->json([
    			'success'		=> 	true, 
    			'message'		=> 	'Sales History.',
    			'data'			=>	$so_history
    	],200); 
    }

    public function salesOrderDetailHistory(Request $request){

        $so_id = $request->sales_order_id;

        $so = SaleOrder::find($so_id);

        $mop= Mop::find($so->mop_id); 
        if($mop){
            $mode_of_payment = $mop->title;
        }else{
            $mode_of_payment = 'Nothing to display.';
        }

        $so_details_history = SaleOrderDetail::findByOrdnum($so_id);

        return response()->json([
                'success'       =>  true, 
                'message'       =>  'Sales Order History.',
                'data'          =>  $so_details_history,
                'mop'           =>  $mode_of_payment
        ],200); 
    }

    public function clarion_salesOrderHistory($customer_id){

        if(!is_numeric($customer_id)){
            $data = json_encode([
                'success'       =>  false, 
                'message'       =>  'Customer ID is not valid format. Please ask the administrator for more details.'
            ]); 
            return $this->response_json_to_xml($data); 
        }

        $user = User::find($customer_id);
        if(!$user){
            $data = json_encode([
                'success'       =>  false, 
                'message'       =>  'Customer ID not found.'
            ]);
            return $this->response_json_to_xml($data); 
        }

        $so_history = SaleOrder::findByUserID($customer_id);

        if( $so_history->isEmpty() ){
            $data = json_encode([
                    'success'       =>  false, 
                    'message'       =>  'No record found.'
            ]);
            return $this->response_json_to_xml($data); 
        }

        $data = json_encode([
                'success'       =>  true,
                'message'       =>  'Sales History.',
                'data'          =>  $so_history
        ]);
        return $this->response_json_to_xml($data);
    }

    public function clarion_singleSalesOrderHistory($customer_id,$order_id){
        
        if(!is_numeric($customer_id)){
            $data = [
                'success'       =>  false, 
                'message'       =>  'Customer ID is not a valid format. Please ask the administrator for more details.'
            ]; 
            return $this->response_json_to_xml($data); 
        }

        if(!is_numeric($order_id)){
            $data = [
                'success'       =>  false, 
                'message'       =>  'Order ID is not a valid format. Please ask the administrator for more details.'
            ]; 
            return $this->response_json_to_xml($data); 
        }

        $user = User::find($customer_id);
        if(!$user){
            $data = [
                'success'       =>  false, 
                'message'       =>  'Customer ID not found.'
            ];
            return $this->response_json_to_xml($data); 
        }

        $so = SaleOrder::findByUserIDAndID($customer_id,$order_id);

        if( is_null($so) ){
            $data = [
                    'success'       =>  false, 
                    'message'       =>  'No record found.'
            ];
            return $this->response_json_to_xml($data); 
        }

        $data = [
                'success'       =>  true,
                'message'       =>  'Sales Order.',
                'data'          =>  $so
        ];
        return $this->response_json_to_xml($data);
    }

    public function response_json_to_xml($json_data){
        // $formatter  = Formatter::make($json_data, Formatter::JSON);
        // $xml        = $formatter->toXml();
        // return response($xml,200)->header('Content-Type', 'text/xml');
        //dd($json_data['success']);
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Header/></soapenv:Envelope>');
        //header('Content-Type: text/xml'); 
        $xml->addAttribute('version', '1.0');
        $body = $xml->addChild('soapenv:Body');  
        $body->addChild('success', $json_data['success']);
        $body->addChild('message', $json_data['message']);
        if($json_data['success'] == true){
            $body->addChild('ORDNUM', $json_data['data']['ORDNUM']);
            $body->addChild('NETAMOUNT', $json_data['data']['NETAMOUNT']);
            $body->addChild('CREATED_AT', $json_data['data']['CREATED_AT']);
            $body->addChild('STATUS', $json_data['data']['STATUS']); 
        } 
        $response = Response::make($xml->asXML(), 200);
        $response->header('Content-Type', 'application/xml');

        return $response; 
    }
}

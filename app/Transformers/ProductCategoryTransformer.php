<?php 

namespace App\Transformers;

class ProductCategoryTransformer {

	public function categories($data){
		$data->transform(function($val){
            return [
                'code'              => $val->category_code,
                'name'              => $val->category_name,
                'abbr'              => $val->category_abbr
                // 'CATCODE'              => $val->category_code,
                // 'CATNAME'              => $val->category_name,
                // 'CATABBR'              => $val->category_abbr
            ];
        });

        return $data;
	}

}
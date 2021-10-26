<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public $guarded = [];
	
    public static function order_status(){
    	return [
    		'1' => 'Approved',
    		'2' => 'Rejected',
    		'3' => 'Processing',
    		'4' => 'Shipped',
    		'5' => 'Delivered'
   		];
    }

    public static function get_order_status_by_key($key){
    	if(array_key_exists($key, self::order_status()){
    		return self::order_status()[$key];
    	}
    	return null;
    }
    
}

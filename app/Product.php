<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image;

class Product extends Model
{
    protected $guarded = [];
    protected $upload_path = '/uploads/products'

    public function scopeFilterSearch($query){
    	$search_keyword = request('keyword');
    	if($search_keyword){ 
    		$query->where('name','LIKE','%'.$search_keyword.'%');
        }
        return $query;
    }

    public function scopeFilterId($query){
    	$search_id = request('id');
    	if($search_id){ 
    		$query->where('name','LIKE','%'.$search_id.'%')
        }
        return $query;
    }

    public function uploadFile($field_or_field_with_request, $save_title='', $path=null, $request_method = false){
        $path = $path ? $path : $this->upload_path;

        $has_image = $request_method ? $field_or_field_with_request : request($field_or_field_with_request);

        if($has_image){
            $extension = $has_image->getClientOriginalExtension(); // getting image extension
            $filename =  remove_space_dots_replace_underscore($save_title) . '_' . time() . mt_rand(1000, 9999) . '.'.$extension;

            Image::make($has_image)->save(public_path($path).$filename);
            return $filename;
        }
        return null;
    } 
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = []; 
    protected $table = 'products';
    
    public function subcategory() {

        return $this->belongsTo('App\SubCategory' , 'subcategory_id');
    }
    public function category() {

        return $this->belongsTo('App\Category' , 'category_id');
    }
    public function productimages() {

        return $this->hasMany('App\ProductImages' , 'product_id');
    }

    public function productdetails() {

        return $this->hasOne('App\ProductDetails' , 'product_id');
    }


}

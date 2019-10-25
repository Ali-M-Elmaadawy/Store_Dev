<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    protected $guarded = []; 
    protected $table = 'product_details' ; 

    public function productid() {

        return $this->belongsTo('App\Product' , 'product_id');
    }



}

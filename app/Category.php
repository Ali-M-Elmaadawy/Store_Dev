<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = []; 
    protected $table = 'categories' ; 

    public function subcategory() {

        return $this->hasMany('App\SubCategory' , 'category_id');
    }
}

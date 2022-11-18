<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\SubCategory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','image','description','category_id','additional_info','subcategory_id'];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function subcategory(){
        return $this->hasOne(SubCategory::class,'id','subcategory_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','name'];

    public function category(){
       return $this->hasOne(Category::class,'id','category_id');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class FrontProductListController extends Controller
{
    public function index(){
        $products = Product::latest()->limit(9)->get();
        //for dynamic carousel
        $randomActiveProducts = Product::inRandomOrder()->limit(3)->get();
        $randomActiveProductIds = [];
        foreach($randomActiveProducts as $product){
            array_push($randomActiveProductIds,$product->id);
        }
        $randomItemProducts = Product::whereNotIn('id',$randomActiveProductIds)
        ->limit(3)->get();
       $sliders = Slider::get();
        return view('product',compact('products','randomActiveProducts','randomItemProducts','sliders'));
    }
    public function show($id){
        $product = Product::find($id);
        $productFromSameCategories = Product::inRandomOrder()
        ->where('category_id',$product->category_id)
        ->where('id','!=',$product->id)->limit(3)->get();
         
        return view('show',compact('product','productFromSameCategories'));
    }

    public function allProduct($name,Request $request){
        $category = Category::where('slug',$name)->first();
        $categoryId = $category->id;
        $filterSubCategories = null;
        if($request->subcategory){
            //filter product
            $products = $this->filterProducts($request);
            $filterSubCategories = $this->getSubcategoriesId($request);
            
        } elseif($request->min||$request->max){
            $products = $this->filterByPrice($request);
        }
        else{
        $products = Product::where('category_id',$category->id)->get();
        }
        $subcategories = SubCategory::where('category_id',$category->id)->get();
        $slug = $name;
        return view('category',compact('filterSubCategories','products','subcategories',
        'categoryId','slug'));
    }

    public function filterProducts(Request $request){
        $subId = [];
        $subcategory = SubCategory::whereIn('id',$request->subcategory)->get();
        foreach($subcategory as $sub){
            array_push($subId,$sub->id);
        }
        $products = Product::whereIn('subcategory_id',$subId)->get();
        return $products;
    }

    public function getSubcategoriesId(Request $request){
        $subId = [];
        $subcategory = SubCategory::whereIn('id',$request->subcategory)->get();
        foreach($subcategory as $sub){
            array_push($subId,$sub->id);
        }
        
        return $subId;
    }

    public function filterByPrice(Request $request){
        $categoryId = $request->categoryId;
        $products = Product::whereBetween('price',[$request->min,$request->max])
        ->where('category_id',$categoryId)->get();
        return $products;
    }

    public function moreProducts(Request $request){
        if($request->search){
            $products = Product::where('name','like','%'.$request->search.'%')
            ->orWhere('description','like','%'.$request->search.'%')
            ->orWhere('additional_info','like','%'.$request->search.'%')
            ->paginate(50);
            return view('all-product',compact('products'));    
        }
        $products = Product::latest()->paginate(50);
        return view('all-product',compact('products'));
    }
}

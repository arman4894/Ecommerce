<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'description'=>'required|min:3',
            'image'=>'required|mimes:png,jpeg,jpg',
            'additional_info'=>'required',
            'category'=>'required'
        ]);
        $image = $request->file('image')->store('public/files');

        Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'image'=>$image,
            'additional_info'=>$request->additional_info,
            'category_id'=>$request->category,
            'subcategory_id'=>$request->subcategory

        ]);
        notify()->success('Product Created Successfully');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'description'=>'required|min:3',
            'additional_info'=>'required',
            'category'=>'required'
        ]);
        $product = Product::find($id);
        $image = $product->image;
        if($request->file('image')){
            $image = $request->file('image')->store('public/files');
            \Storage::delete($product->image);
        }
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->additional_info = $request->additional_info;
        $product->image = $image;
        $product->category_id = $request->category;
        $product->subcategory_id = $request->subcategory;
        $product->save();
        notify()->success('Product Created Successfully');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $filename = $product->image;
        $product->delete();
        \Storage::delete($filename);
        notify()->success('Product Created Successfully');
        return redirect()->route('product.index');

    }

    public function loadSubCategories(Request $request,$id){
        
        $subcategory = SubCategory::where('category_id',$id)->pluck('name','id');
        return response()->json($subcategory);
    }

   
}

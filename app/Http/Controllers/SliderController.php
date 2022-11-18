<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::get();
        return  view('admin.slider.index',compact('sliders'));
    }
    public function create(){
        return view('admin.slider.create');
    }
    public function store(Request $request){
        $request->validate([
            'image'=>'required|mimes:png.jpg,jpeg'
        ]);
        $image = $request->file('image')->store('public/slider');
        Slider::create([
            'image'=>$image
        ]);
        notify()->success('Slider created Successfully');
        return redirect()->back();
    }

    public function destroy($id){
        
        $slider =Slider::find($id);
        $filename = $slider->image;
        $slider->delete();
        \Storage::delete($filename);
        notify()->success('Slider deleted Successfully');
        return redirect()->back();
    }
}

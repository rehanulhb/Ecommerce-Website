<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Image;


class SliderController extends Controller
{
    //

    public function AllSlider(){
        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_all', compact('sliders'));
    }

    public function AddSlider(){
        return view('backend.slider.slider_add');
    }


    public function StoreSlider(Request $request){

        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;

        Slider::insert([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $save_url, 
        ]);

       $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification); 

    }

    public function EditSlider($id){
        $sliders = Slider::findOrFail($id);
        return view('backend.slider.slider_edit', compact('sliders'));
    }

    public function UpdateSlider(Request $request){

        $slider_id=$request->id;
        $old_img=$request->old_img;

        if($request->file('slider_image'))
        {
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
            $save_url = 'upload/slider/'.$name_gen;

            if(file_exists($old_img)){
                unlink($old_img);
            }
    
            Slider::findOrFail($slider_id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
                'slider_image' => $save_url,  
            ]);
    
           $notification = array(
                'message' => 'Slider Updated with Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.slider')->with($notification); 
        }

        else{
                Slider::findOrFail($slider_id)->update([
                    'slider_title' => $request->slider_title,
                    'short_title' => $request->short_title,
                    
                 
            ]);
    
           $notification = array(
                'message' => 'Slider Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.slider')->with($notification);
        }
    }

    public function DeleteSlider($id){

        $sliders = Slider::findOrFail($id);
        $img=$sliders->slider_image;
        unlink($img);

        Slider::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    
    }


}

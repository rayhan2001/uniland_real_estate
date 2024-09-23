<?php

namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function allData()
    {
        $slider = Slider::all();

        return response()->json(['data'=> $slider], 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'slider_text'=> 'required',
            'slider_image'=> 'required|image|mimes:png,jpeg,jpg',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $slider = new Slider();
        $slider->slider_text = $request->slider_text;
        $slider->button = json_encode($request->button);
        if ($request->hasFile('slider_image')) { 
            $image = $request->file('slider_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/sliders');
            $image->move($destinationPath, $name);
            $slider->slider_image = $name;
        }
        $slider->save();

        return response()->json(['message'=> 'Slider updated successfully'],200);
    }

    public function update(Request $request)
    {
        $slider = Slider::find($request->id);
        $slider->slider_text = $request->slider_text;
        $slider->button = json_encode($request->button);
        if ($request->hasFile('slider_image')) {
            $oldImage = $slider->slider_image;
            $image = $request->file('slider_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/sliders');
            $image->move($destinationPath, $name);
            $slider->slider_image = $name;
            if (file_exists(public_path('images/sliders/' . $oldImage))) {
                unlink(public_path('images/sliders/' . $oldImage));
            }
        }
        $slider->status = $request->status;
        $slider->save();

        return response()->json(['message'=> 'Slider updated successfully'],200);
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        if ($slider->slider_image){
            unlink($slider->slider_image);
        }
        $slider->delete();
        return response()->json(['message' => 'Slider deleted successfully'], 200);
    }

}

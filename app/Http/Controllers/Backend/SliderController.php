<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sliders = Slider::all();
        return view('backend.sliders.list',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sliders.create-update');   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validateData = $request->validate([
            "title" => 'required|max:255',
        ]);
        
       
        $insertArray = array("title" => $request->title, 
                             "url" => $request->url,
                             "display" =>$request->display,
                             "created_by" => Auth::user()->name
                            );

        $path = public_path() . '/storage/sliders/';
        $folderPath = 'public/sliders/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);
        }

        if ($request->hasFile('image')) {

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $folderPath = "public/sliders/";
            ModelHelper::resize_crop_images(1920, 800, $image, $folderPath . "/" . $filename);
            $insertArray['image'] = $filename;
        }
        $create_slider = Slider::create($insertArray);

        if ($create_slider) {
            return redirect()->route('admin.sliders.index')->with('status','Slider has been Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
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
        //
        $slider = Slider::find(base64_decode($id));
        return view('backend.sliders.create-update', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
        $updateArray =array(
            "title"=>$request->title,
            "url"=>$request->url,
            "display"=>$request->display,
            "updated_by" => Auth::user()->name,
            "updated_at" => date('Y-m-d h:i:s')
          
        );

        $path = public_path() .'/storage/sliders/';
        $folder_path = 'public/sliders/';
        if (!file_exists($path)){
            Storage::makeDirectory($folder_path, 0777, true, true);
        }

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time().'.'. $image->getClientOriginalExtension();
            ModelHelper::resize_crop_images(1920, 800, $image, $folder_path . '/'. $filename);

            $updateArray['image'] = $filename;
            $oldImage = $slider->image;

            Storage::delete($folder_path.'/'.$oldImage);
        }

        $slider_updated = $slider->update($updateArray);

        if ($slider_updated) {

            return redirect()->route('admin.sliders.index')->with('status','Slider has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $id = base64_decode($id);
        $slider = Slider::where('id',$id)->firstOrFail();
        if($slider){

            if($slider->delete()){
                $folder_path="public/sliders";
                Storage::delete($folder_path .'/'.$slider->image);
                return redirect()->back()->with('status', "Slider Successfully Deleted");
            }
            
        }
        else{
            return redirect()->back()->with('status', 'Something Went Wrong');
        }
        
    }


    public function delete_slider($id)
    {
        $slide = Slider::findOrFail(base64_decode($id));

        if ($slide) {

            $oldImage = $slide->image;
            $folderPath = "public/sliders";

            Storage::delete($folderPath .'/'. $oldImage);
            Storage::delete($folderPath .'/'. $oldImage);

            $slide->image = NULL;
            $slide->save();

            return redirect()->back()->with('status', ' Image Deleted Successfully!');
        }
        return redirect()->back()->with('error', 'Something Went Wrong!');

    }
}

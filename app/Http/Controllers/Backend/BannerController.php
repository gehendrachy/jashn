<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('backend.banners.list',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back()->with('error', 'Access Denied');
        // return view('backend.banners.create-update');   
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
        
       
        $insertArray = array(
                                "title" => $request->title, 
                                "url" => $request->url,
                            );

        $path = public_path() . '/storage/banners/';
        $folderPath = 'public/banners/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);
        }

        if ($request->hasFile('image')) {
            

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $folderPath = "public/banners/";
            ModelHelper::resize_crop_images(1920, 800, $image, $folderPath . "/" . $filename);
            $insertArray['image'] = $filename;
        }
        $create_banner = Banner::create($insertArray);

        if ($create_banner) {
            return redirect()->route('admin.banners.index')->with('status','Banner has been Added Successfully!');

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
        $banner = Banner::find(base64_decode($id));
        return view('backend.banners.create-update', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        
        $validateData = $request->validate([
            "title" => 'required|max:191',
            'url' => 'required|max:191'
        ]);

        $updateArray =array(
            "title"=>$request->title,
            "url"=>$request->url,
            "updated_at" => date('Y-m-d h:i:s')
          
        );

        $path = public_path() .'/storage/banners/';
        $folder_path = 'public/banners/';

        if (!file_exists($path)){
            Storage::makeDirectory($folder_path, 0777, true, true);
        }

        if($request->hasFile('image')){

            $validateData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $image = $request->file('image');
            $filename = time().'.'. $image->getClientOriginalExtension();

            if($banner->id == 1 || $banner->id == 2){
                ModelHelper::resize_crop_images(1920, 510, $image, $folder_path . "/" . $filename);
            }

            if($banner->id == 3 || $banner->id == 4){
                ModelHelper::resize_crop_images(655, 350, $image, $folder_path . "/" . $filename);
            }


            if($banner->id == 5 || $banner->id == 6 || $banner->id == 7 || $banner->id == 8){
                ModelHelper::resize_crop_images(325, 350, $image, $folder_path . "/" . $filename);
            }


            $updateArray['image'] = $filename;
            $oldImage = $banner->image;

            Storage::delete($folder_path.'/'.$oldImage);
        }

        $banner_updated = $banner->update($updateArray);

        if ($banner_updated) {

            return redirect()->route('admin.banners.index')->with('status','Bannner has been Updated Successfully!');

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
        // $id = base64_decode($id);
        // $banner = Banner::where('id',$id)->firstOrFail();
        // if($banner){

        //     if($banner->delete()){
        //         $folder_path="public/banners";
        //         Storage::delete($folder_path .'/'.$banner->image);
        //         return redirect()->back()->with('status', "Banner Successfully Deleted");
        //     }
            
        // }
        // else{
        //     return redirect()->back()->with('status', 'Something Went Wrong');
        // }
        return redirect()->back()->with('error', 'Access Denied');
        
    }


    public function delete_banner($id)
    {
        $banner = Banner::findOrFail(base64_decode($id));

        if ($banner) {

            $oldImage = $banner->image;
            $folderPath = "public/banners";

            Storage::delete($folderPath .'/'. $oldImage);
            Storage::delete($folderPath .'/'. $oldImage);

            $banner->image = NULL;
            $banner->save();

            return redirect()->back()->with('status', ' Image Deleted Successfully!');
        }
        return redirect()->back()->with('error', 'Something Went Wrong!');

    }
}

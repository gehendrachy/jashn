<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Occassion;
use Illuminate\Http\Request;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreOccassionRequest;
use App\Http\Requests\UpdateOccassionRequest;

class OccassionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:occassion-list|occassion-create|occassion-edit|occassion-delete', ['only' => ['index','show']]);
        $this->middleware('permission:occassion-create', ['only' => ['create','store']]);
        $this->middleware('permission:occassion-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:occassion-delete', ['only' => ['destroy']]);
        
    }

    public function index()
    {
        
        $occassions = Occassion::all();
        return view('backend.occassions.list-occassions',compact('occassions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.occassions.create-update-occassions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOccassionRequest $request)
    {
        $validateData = $request->validate([
            "title" => 'required|max:255',
        ]);
        
        $slug = ModelHelper::createSlug('\App\Models\Occassion', $request->title);
        
        $insertArray = array("title" => $request->title, 
                             "slug" => $slug,
                             "display" => isset($request->display) ? $request->display : 0,
                             "created_by" => Auth::user()->name
                            );

        $path = public_path() . '/storage/occassions/';
        $folderPath = 'public/occassions/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

            if (!is_dir($path . "/thumbs")) {
                Storage::makeDirectory($folderPath . '/thumbs', 0777, true, true);
            }
        }

        if ($request->hasFile('image')) {

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $folderPath = "public/occassions/";
            $thumbPath = "public/occassions/thumbs";

            if (!file_exists($thumbPath)) {
                
                Storage::makeDirectory($thumbPath, 0777, true, true);
            }

            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(1200, 1200, $image, $folderPath . "/" . $filename);
            ModelHelper::resize_crop_images(1200, 900, $image, $folderPath . "/thumbs/medium_" . $filename);
            ModelHelper::resize_crop_images(800, 800, $image, $folderPath . "/thumbs/small_" . $filename);

            //Update the database
            $insertArray['image'] = $filename;

        }

        $occassion_created = Occassion::create($insertArray);

        if ($occassion_created) {
            
            ModelHelper::update_child_status('\App\Models\Occassion', $request->parent_id);

            return redirect()->route('admin.occassions.index')->with('status','New Occassion has been Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Occassion  $occassion
     * @return \Illuminate\Http\Response
     */
    public function show(Occassion $occassion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Occassion  $occassion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $occassion = Occassion::find(base64_decode($id));
        return view('backend.occassions.create-update-occassions',compact('occassion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Occassion  $occassion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOccassionRequest $request, Occassion $occassion)
    {
        $slug = ModelHelper::createSlug('\App\Models\Occassion', $request->title, $occassion->id);
        // dd($occassion);

        $updateArray = array(
                                "title" => $request->title, 
                                "slug" => $slug,
                                "display" => isset($request->display) ? $request->display : 0,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        $path = public_path() . '/storage/occassions/';
        $folderPath = 'public/occassions/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

            if (!is_dir($path . "/thumbs")) {
                Storage::makeDirectory($folderPath . '/thumbs', 0777, true, true);
            }
        }

        if ($request->hasFile('image')) {

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $folderPath = "public/occassions/";
            $thumbPath = "public/occassions/thumbs";

            if (!file_exists($thumbPath)) {
                
                Storage::makeDirectory($thumbPath, 0777, true, true);
            }

            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(1200, 1200, $image, $folderPath . "/" . $filename);
            ModelHelper::resize_crop_images(1200, 900, $image, $folderPath . "/thumbs/medium_" . $filename);
            ModelHelper::resize_crop_images(800, 800, $image, $folderPath . "/thumbs/small_" . $filename);

            //Update the database
            $updateArray['image'] = $filename;

        }

        $old_parent_id = $occassion->parent_id;
        $new_parent_id = $request->parent_id;
        // ModelHelper::update_child_status('\App\Models\Occassion', $new_parent_id, $old_parent_id);
        // dd($old_parent_id."--new---".$new_parent_id);

        $occassion_updated = $occassion->update($updateArray);

        if ($occassion_updated) {
            
            ModelHelper::update_child_status('\App\Models\Occassion', $new_parent_id, $old_parent_id);
            // dd('test');
            return redirect()->route('admin.occassions.index')->with('status','Occassion Details has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Occassion  $occassion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $occassion = Occassion::where('id' , $id)->firstOrFail();

        

        if ($occassion) {

            $oldImage = $occassion->image;
            
            // dd(count($occassion->products));
            if (count($occassion->products) > 0) {

                return redirect()->back()->with('parent_status' , array('type' => 'danger', 'primary' => 'Sorry, Occassion has Products!', 'secondary' => 'Currently, It cannot be deleted.'));
                exit();
            }

            // exit();
            if ($occassion->delete()) {

                $folderPath = "public/occassions";

                Storage::delete($folderPath ."/".$oldImage);
                Storage::delete($folderPath ."/thumbs/small_".$oldImage);
                Storage::delete($folderPath ."/thumbs/medium_".$oldImage);

            }

            return redirect()->back()->with('status', 'Occassion Deleted Successfully!');
        }

        return redirect()->back()->with('error', 'Something Went Wrong!');
    }

    public static function set_order(Request $request)
    {
        $has_child = $request['has_child'];
        $model = $request['model'];
        $list_order = $request['list_order'];

        $data = ModelHelper::set_order($list_order, $model, $has_child);
            
        echo json_encode($data);
        exit;
    }
}

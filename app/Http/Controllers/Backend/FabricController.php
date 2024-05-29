<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fabric;
use Illuminate\Http\Request;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreFabricRequest;
use App\Http\Requests\UpdateFabricRequest;

class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:fabric-list|fabric-create|fabric-edit|fabric-delete', ['only' => ['index','show']]);
        $this->middleware('permission:fabric-create', ['only' => ['create','store']]);
        $this->middleware('permission:fabric-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:fabric-delete', ['only' => ['destroy']]);
        
    }

    public function index()
    {
        
        $fabrics = Fabric::all();
        return view('backend.fabrics.list-fabrics',compact('fabrics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.fabrics.create-update-fabrics');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFabricRequest $request)
    {
        $validateData = $request->validate([
            "title" => 'required|max:255',
        ]);
        
        $slug = ModelHelper::createSlug('\App\Models\Fabric', $request->title);
        
        $insertArray = array("title" => $request->title, 
                             "slug" => $slug,
                             "display" => isset($request->display) ? $request->display : 0,
                             "created_by" => Auth::user()->name
                            );

        $path = public_path() . '/storage/fabrics/';
        $folderPath = 'public/fabrics/';

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
            $folderPath = "public/fabrics/";
            $thumbPath = "public/fabrics/thumbs";

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

        $fabric_created = Fabric::create($insertArray);

        if ($fabric_created) {
            
            ModelHelper::update_child_status('\App\Models\Fabric', $request->parent_id);

            return redirect()->route('admin.fabrics.index')->with('status','New Fabric has been Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function show(Fabric $fabric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fabric = Fabric::find(base64_decode($id));
        return view('backend.fabrics.create-update-fabrics',compact('fabric'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFabricRequest $request, Fabric $fabric)
    {
        $slug = ModelHelper::createSlug('\App\Models\Fabric', $request->title, $fabric->id);
        // dd($fabric);

        $updateArray = array(
                                "title" => $request->title, 
                                "slug" => $slug,
                                "display" => isset($request->display) ? $request->display : 0,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        $path = public_path() . '/storage/fabrics/';
        $folderPath = 'public/fabrics/';

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
            $folderPath = "public/fabrics/";
            $thumbPath = "public/fabrics/thumbs";

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

        $old_parent_id = $fabric->parent_id;
        $new_parent_id = $request->parent_id;
        // ModelHelper::update_child_status('\App\Models\Fabric', $new_parent_id, $old_parent_id);
        // dd($old_parent_id."--new---".$new_parent_id);

        $fabric_updated = $fabric->update($updateArray);

        if ($fabric_updated) {
            
            ModelHelper::update_child_status('\App\Models\Fabric', $new_parent_id, $old_parent_id);
            // dd('test');
            return redirect()->route('admin.fabrics.index')->with('status','Fabric Details has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $fabric = Fabric::where('id' , $id)->firstOrFail();

        

        if ($fabric) {

            
            // dd(count($fabric->products));
            if (isset($fabric->products)) {

                return redirect()->back()->with('parent_status' , array('type' => 'danger', 'primary' => 'Sorry, Fabric has Products!', 'secondary' => 'Currently, It cannot be deleted.'));
                exit();
            }

            // exit();
            if ($fabric->delete()) {

                $folderPath = "public/fabrics";

                Storage::delete($folderPath ."/".$oldImage);
                Storage::delete($folderPath ."/thumbs/small_".$oldImage);
                Storage::delete($folderPath ."/thumbs/medium_".$oldImage);

            }

            return redirect()->back()->with('status', 'Fabric Deleted Successfully!');
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

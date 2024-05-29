<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('permission:content-list|content-create|content-edit|content-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:content-create', ['only' => ['create','store']]);
        // $this->middleware('permission:content-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:content-delete', ['only' => ['destroy']]);
        
    }

    public function index()
    {
        
        $contents = ModelHelper::getFullListFromDB('contents');
        
        // dd($contents);
        return view('backend.contents.list-contents',compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $id = 0;
        $parent_contents = Content::orderBy('order_item')->get();
        $categories = Category::all();
        return view('backend.contents.create-update-contents',compact('parent_contents','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentRequest $request)
    {
        $validateData = $request->validate([
            "title" => 'required|max:255',
        ]);

        // dd($request);
        
        $slug = ModelHelper::createSlug('\App\Models\Content', $request->title);
        
        $max_order = Content::max('order_item');
        $insertArray = array("title" => $request->title, 
                             "slug" => $slug,
                             "content" => $request->content,
                             "order_item" => $max_order + 1,
                             "parent_id" => 0,
                             "created_by" => Auth::user()->name
                            );

        $path = public_path() . '/storage/contents/';
        $folderPath = 'public/contents/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

            if (!is_dir($path . "/thumbs")) {
                Storage::makeDirectory($folderPath . '/thumbs', 0777, true, true);
            }
        }

        if ($request->hasFile('image')) {

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.webp';
            $folderPath = "public/contents/";
            $thumbPath = "public/contents/thumbs";

            if (!file_exists($thumbPath)) {
                
                Storage::makeDirectory($thumbPath, 0777, true, true);
            }

            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(760, 960, $image, $folderPath . "/" . $filename);
            ModelHelper::resize_crop_images(380, 480, $image, $folderPath . "/thumbs/small_" . $filename);

            //Update the database
            $insertArray['image'] = $filename;

        }

        $content_created = Content::create($insertArray);

        if ($content_created) {

            return redirect()->route('admin.contents.index')->with('status','New Content has been Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = Content::find(base64_decode($id));

        return view('backend.contents.create-update-contents', compact('content'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        
        $slug = ModelHelper::createSlug('\App\Models\Content', $request->title, $content->id);
        

        $updateArray = array(
                                "slug" => $slug,
                                "content" => $request->content,
                                // "parent_id" => 0,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        // dd($updateArray);

        $path = public_path() . '/storage/contents/';
        $folderPath = 'public/contents/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

            if (!is_dir($path . "/thumbs")) {
                Storage::makeDirectory($folderPath . '/thumbs', 0777, true, true);
            }
        }

        if ($request->hasFile('image')) {

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.webp';
            $folderPath = "public/contents/";
            $thumbPath = "public/contents/thumbs";

            if (!file_exists($thumbPath)) {
                
                Storage::makeDirectory($thumbPath, 0777, true, true);
            }

            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(760, 960, $image, $folderPath . "/" . $filename);
            ModelHelper::resize_crop_images(380, 480, $image, $folderPath . "/thumbs/small_" . $filename);

            $OldFilename = $content->image;
            //Update the database
            $updateArray['image'] = $filename;

            Storage::delete($folderPath ."/".$OldFilename);
            Storage::delete($folderPath ."/thumbs/small_".$OldFilename);

        }

        $old_parent_id = $content->parent_id;
        $new_parent_id = $request->parent_id;

        $content_updated = $content->update($updateArray);

        if ($content_updated) {

            return redirect()->back()->with('status','Content Details has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $content = Content::where('id' , $id)->firstOrFail();

        if ($content) {

            $oldImage = $content->image;

            // exit();
            if ($content->delete()) {

                $folderPath = "public/contents";

                Storage::delete($folderPath ."/".$oldImage);
                Storage::delete($folderPath ."/thumbs/small_".$oldImage);

            }

            return redirect()->back()->with('status', 'Content Deleted Successfully!');
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

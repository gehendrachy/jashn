<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //     $this->middleware('permission:Blog-list|Blog-create|Blog-edit|Blog-delete', ['only' => ['index','show']]);
    //     $this->middleware('permission:Blog-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:Blog-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:Blog-delete', ['only' => ['destroy']]);
        
    // }

    public function index()
    {
        $blogs = Blog::all();
        return view('backend.blogs.list',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.create-update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validateData = $request->validate([
            "title" => 'required|max:255',
            "short_content" => 'required'
        ]);
        
        $slug = ModelHelper::createSlug('\App\Models\Blog', $request->title);
        
        $insertArray = array("title" => $request->title, 
                             "slug" => $slug,
                             "short_content" => $request->short_content,
                             "long_content" => $request->long_content,
                             "display" => isset($request->display) ? $request->display : 0,
                             "featured" => isset($request->featured) ? $request->featured : 0,
                             "created_by" => Auth::user()->name
                            );

        $path = public_path() . '/storage/blogs/';
        $folderPath = 'public/blogs/';

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
            $folderPath = "public/blogs/";
            $thumbPath = "public/blogs/thumbs";

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

        $blog_created = Blog::create($insertArray);

        if ($blog_created) {
            return redirect()->route('admin.blogs.index')->with('status','Blogs has been Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find(base64_decode($id));
        return view('backend.blogs.create-update',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $slug = ModelHelper::createSlug('\App\Models\Blog', $request->title, $blog->id);
        // dd($blog);

        $updateArray = array(
                                "title" => $request->title, 
                                "slug" => $slug,
                                "display" => isset($request->display) ? $request->display : 0,
                                "featured" => isset($request->featured) ? $request->featured : 0,
                                "short_content" => $request->short_content,
                                "long_content" => $request->long_content,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        $path = public_path() . '/storage/blogs/';
        $folderPath = 'public/blogs/';

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
            $folderPath = "public/blogs/";
            $thumbPath = "public/blogs/thumbs";

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

       

        $blog_updated = $blog->update($updateArray);

        if ($blog_updated) {
            
            return redirect()->route('admin.blogs.index')->with('status','Blog Details has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $blog = Blog::where('id' , $id)->firstOrFail();

        if ($blog) {
            $oldImage = $blog->image;
            if ($blog->delete()) {

                $folderPath = "public/blogs";

                Storage::delete($folderPath ."/".$oldImage);
                Storage::delete($folderPath ."/thumbs/small_".$oldImage);
                Storage::delete($folderPath ."/thumbs/medium_".$oldImage);
            }
            return redirect()->back()->with('status', 'Blogs Deleted Successfully!');
        }
        return redirect()->back()->with('error', 'Something Went Wrong!');
    }

    public function delete_blog($id)
    {
        $blog = Blog::findOrFail(base64_decode($id));

        if ($blog) {

            $oldImage = $blog->image;
            $folderPath = "public/blogs";

            Storage::delete($folderPath .'/thumbs/small_'. $oldImage);
            Storage::delete($folderPath .'/thumbs/large_'. $oldImage);
            Storage::delete($folderPath .'/'. $oldImage);

            $blog->image = NULL;
            $blog->save();

            return redirect()->back()->with('status', ' Image Deleted Successfully!');
        }
        return redirect()->back()->with('error', 'Something Went Wrong!');

    }

}

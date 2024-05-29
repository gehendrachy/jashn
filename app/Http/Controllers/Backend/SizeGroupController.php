<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SizeGroup;
use App\Models\Size;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreSizeGroupRequest;
use App\Http\Requests\UpdateSizeGroupRequest;

class SizeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $size_groups = SizeGroup::all();
        return view('backend.size-groups.list-size-groups',compact('size_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.size-groups.create-update-size-groups');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSizeGroupRequest $request)
    {
        // dd($_POST);
        $size_group = SizeGroup::create([
                                            'name' => $request->name, 
                                            'display' => isset($request->display) ? $request->display : 0,
                                            'created_by' => Auth::user()->name
                                        ]);
        $sizes = $request->size_group;
        $sizeArray = [];

        foreach ($sizes as $size) {
            
            $size_group->sizes()->updateOrCreate(['name' => $size['name']]);
        }

        // dd($sizeArray);

        

        return redirect()->route('admin.size-groups.index')->with('status','New Size Group has been Added Successfully!');
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
        $size_group = SizeGroup::findOrFail(base64_decode($id));
        return view('backend.size-groups.create-update-size-groups',compact('size_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSizeGroupRequest $request, SizeGroup $size_group)
    {
        // dd($_POST);
        $size_group->update([
                                'name' => $request->name, 
                                'display' => isset($request->display) ? $request->display : 0,
                                'updated_by' => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            ]);

        $sizes = $request->size_group;
        $sizeArray = [];

        foreach ($sizes as $size) {
            if (isset($size['id'])) {
                
                $sizeExists = Size::where('name',$size['name'])->exists();
                
                if (!$sizeExists) {
                    Size::where('id',$size['id'])->update(['name' => $size['name']]);
                }

            }else{

                $size_group->sizes()->updateOrCreate(['name' => $size['name']]);
            } 
        }

        // dd($sizeArray);

        

        return redirect()->route('admin.size-groups.index')->with('status','Size Group has been Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $size_group = SizeGroup::where('id', $id)->firstOrFail();

        if ($size_group) {
            
            $size_group->delete();
            return redirect()->back()->with('status','Size Group Deleted Successfully!');

        }else{

            return redirect()->back()->with('error','Size Group Not Found!');
        }
    }

    public function delete_size(Request $request)
    {
        if (isset($request->id)) {
            
            $db_size = Size::find($request->id);
            $db_size->delete();

        }else{
            echo "error";
        }
    }
}

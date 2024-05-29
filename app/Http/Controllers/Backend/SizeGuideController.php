<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SizeGroup;
use App\Models\SizeGuide;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreSizeGuideRequest;
use App\Http\Requests\UpdateSizeGuideRequest;

class SizeGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $size_guides = SizeGuide::all();
        return view('backend.size-guides.list-size-guides',compact('size_guides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $size_groups = SizeGroup::where('display', 1)->get();
        return view('backend.size-guides.create-update-size-guides',compact('size_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSizeGuideRequest $request)
    {
        // dd($_POST);

        $size_guide_created = SizeGuide::create([
                                    'name' => $request->name,
                                    'size_group_id' => $request->size_group_id,
                                    'display' => isset($request->display) ? $request->display : 0,
                                    'units' => json_encode($request->unit),
                                    'sizes' => json_encode($request->size),
                                    'created_by' => Auth::user()->name
                                ]);

        if ($size_guide_created) {

            return redirect()->route('admin.size-guides.index')->with('status','New Size Guide has been Created Successfully!');
        }else{

            return redirect()->back()->with('error','Something went Wrong!');
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
        $id = base64_decode($id);
        $size_guide = SizeGuide::find($id);
        $size_groups = SizeGroup::where('display',1)->get();
        // dd(json_decode($size_guide->sizes));
        return view('backend.size-guides.create-update-size-guides',compact('size_guide','size_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }

    public function get_sizes(Request $request)
    {
        $size_group_id = $request->id;
        $size_group = SizeGroup::find($request->id);

        if (isset($size_group)) {
            $sizes = $size_group->sizes;
            $responeText = '<table class="table table-bordered">
                <thead>
                    <tr class="unit-row">
                        <th class="text-center">Sizes</th>
                        <th>
                            <div class="input-group mb-0">
                                <input class="form-control unit-name-input" type="text" name="unit[1][name]" required placeholder="Unit Name">
                            </div>
                        </th>
                        
                    </tr>
                </thead>
                <tbody>';

                foreach ($sizes as $key => $size) {
                    $responeText .= '<tr class="value-row">
                        <td class="text-center">
                            '.$size->name.'
                            <input type="hidden" name="size['.$key.'][id]" value="'.$size->id.'">
                            <input type="hidden" name="size['.$key.'][name]" value="'.$size->name.'">
                        </td>
                        <td>
                            <input class="form-control" type="text" name="unit[1][value][]" required placeholder="Enter Value">
                        </td>
                        
                    </tr>';
                }

                $responeText .= '</tbody>
            </table>';

            return $responeText;
        }else{
            return 'error';
        }
    }

    public function view_size_guide(Request $request)
    {
        $id = $request->id;

        $size_guide = SizeGuide::find($id);

        $size_guide_units = json_decode($size_guide->units);
        $size_guide_sizes = json_decode($size_guide->sizes);

        $response = '';

        $response .= '<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sizes</th>';
                                    foreach($size_guide_units as $unit){
                                        $response .= '<th>'.$unit->name.'</th>';
                                    }
                                $response .= '</tr>
                            </thead>
                            <tbody>';
                                foreach($size_guide_sizes as $key => $size){
                                    $response .= '<tr>
                                        <td>'.$size->name.'</td>';
    
                                        foreach($size_guide_units as $unit){
                                            $response .= '<td>'.$unit->value[$key].'</td>';
                                        }
                                        
                                    $response .= '</tr>';
                                }
                            $response .= '</tbody>
                        </table>';

        echo $response;

    }
}

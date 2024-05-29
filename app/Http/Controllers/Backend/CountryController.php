<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;

use Illuminate\Support\Facades\Auth;
use App\Services\ModelHelper;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //     $this->middleware('permission:info-page-list|info-page-create|info-page-edit|info-page-delete', ['only' => ['index','show']]);
    //     $this->middleware('permission:info-page-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:info-page-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:info-page-delete', ['only' => ['destroy']]);
        
    // }

    public function index()
    {
        $countries = Country::all();
        return view('backend.countries.list',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.countries.create-update');
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
            "name" => 'required|max:255',
            "country_code"=> 'required',
        ]);
        
       
        
        $insertArray = array("name" => $request->name, 
                             "country_code" => $request->country_code,
                             "display"=> $request->display,
                             "created_by" => Auth::user()->name
                            );
       
        $country_create= Country::create($insertArray);

        if ($country_create) {

            return redirect()->route('admin.countries.index')->with('status','Country Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InfoPage  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InfoPage  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find(base64_decode($id));
        return view('backend.countries.create-update',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InfoPage  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        
        // dd($country);

        $updateArray = array(
                                "name" => $request->name, 
                                "country_code" => $request->country_code,
                                "display"=> $request->display,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        

        $country_updated = $country->update($updateArray);

        if ($country_updated) {

            return redirect()->route('admin.countries.index')->with('status','Country has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InfoPage  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        if ($id == 1) {
            return redirect()->back()->with('error', 'It cannot be deleted.');
        }
        $country = Country::where('id' , $id)->firstOrFail();
        
        $country->states()->delete();

        if ($country->delete()) {

            return redirect()->back()->with('status', 'Country Deleted Successfully!');
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
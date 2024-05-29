<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;

use Illuminate\Support\Facades\Auth;
use App\Services\ModelHelper;
class StateController extends Controller
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
        $states = State::all();
        return view('backend.states.list',compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    
    {
        $parent_country = Country::orderBy('name')->get();
        return view('backend.states.create-update',compact('parent_country'));
    }


    public function store(Request $request)
    {
    	// dd($request);
        $validateData = $request->validate([
            "name" => 'required|max:255',
            
        ]);
        
       
        
        $insertArray = array("name" => $request->name, 
                             "country_id" => $request->country_id,
                             "display"=> $request->display,
                             "created_by" => Auth::user()->name
                            );
       
        $state_create= State::create($insertArray);

        if ($state_create) {

            return redirect()->route('admin.states.index')->with('status','State Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }


    public function show(State $state)
    {
        //
    }

     
    public function edit($id)
    {
        $state = State::find(base64_decode($id));
        $parent_country = Country::where('id','!=', $state->state_id)->orderBy('name')->get();
        return view('backend.states.create-update',compact('state','parent_country'));
    }


    public function update(Request $request, State $state)
    {
        
        // dd($state);

        $updateArray = array(
                                "name" => $request->name, 
                                "country_id" => $request->country_id,
                                "display"=> $request->display,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        

        $state_updated = $state->update($updateArray);

        if ($state_updated) {

            return redirect()->route('admin.states.index')->with('status','State has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InfoPage  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $state = State::where('id' , $id)->firstOrFail();



            
            if ($state->delete()) {

                return redirect()->back()->with('status', 'State Deleted Successfully!');

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
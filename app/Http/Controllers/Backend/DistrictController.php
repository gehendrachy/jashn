<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\District;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:info-page-list|info-page-create|info-page-edit|info-page-delete', ['only' => ['index','show']]);
    //     $this->middleware('permission:info-page-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:info-page-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:info-page-delete', ['only' => ['destroy']]);  
    // }

    public function index()
    {
        $districts = District::all();
        return view('backend.districts.list',compact('districts'));
    }
    public function create()
    
    {
        $parent_state = State::orderBy('name')->get();
        return view('backend.districts.create-update',compact('parent_state'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            "name" => 'required|max:255',
        ]);

        $country = State::where('id',$request->state_id)->first();
        $insertArray = array("name" => $request->name, 
                             "state_id" => $request->state_id,
                             "country_id"=>$country->country_id,
                             "display"=> $request->display,
                             "created_by" => Auth::user()->name
                            );
       
        $district_create= District::create($insertArray);

        if ($district_create) {

            return redirect()->route('admin.districts.index')->with('status','District Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    public function show(District $district)
    {
        //
    }

    public function edit($id)
    {
        $district = District::find(base64_decode($id));
        $parent_state = State::orderBy('name')->get();
        
        return view('backend.districts.create-update',compact('district','parent_state'));
    }


    public function update(Request $request, District $district)
    {
         $country = State::where('id',$request->state_id)->first();
        $updateArray = array(
                                "name" => $request->name, 
                                "country_id"=> $country->country_id,
                                "state_id" => $request->state_id,
                                "display"=> $request->display,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        $district_updated = $district->update($updateArray);

        if ($district_updated) {

            return redirect()->route('admin.districts.index')->with('status','District has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    public function destroy($id)
    {
        $id = base64_decode($id);
        $district = District::where('id' , $id)->firstOrFail();  
            if ($district->delete()) {
                return redirect()->back()->with('status', 'District Deleted Successfully!');
            }
        return redirect()->back()->with('error', 'Something Went Wrong!');
    }


}
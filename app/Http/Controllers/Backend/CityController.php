<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
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
        $cities = City::all();
        return view('backend.cities.list',compact('cities'));
    }
    public function create()
    {
        $parent_countries = Country::all();
        $parent_district = District::orderBy('name')->get();
        return view('backend.cities.create-update', compact('parent_countries', 'parent_district'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            "name" => 'required|max:255',
        ]);
        $insertArray = array("name" => $request->name, 
                             "pin_code" => $request->pin_code,
                             "district_id" => $request->district_id,
                             "display"=> $request->display,
                             "created_by" => Auth::user()->name
                            );
       
        $city_create= City::create($insertArray);

        if ($city_create) {

            return redirect()->route('admin.cities.index')->with('status','City Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    public function show(City $city)
    {
        //
    }

    public function edit($id)
    {
        $city = City::find(base64_decode($id));
        $parent_countries = Country::all();
        $parent_district = District::orderBy('name')->get();
        return view('backend.cities.create-update',compact('city','parent_district', 'parent_countries'));
    }


    public function update(Request $request, City $city)
    {
        $updateArray = array(
                                "name" => $request->name, 
                                "pin_code" => $request->pin_code,
                                "district_id" => $request->district_id,
                                "display"=> $request->display,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        $city_updated = $city->update($updateArray);

        if ($city_updated) {

            return redirect()->route('admin.cities.index')->with('status','City has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    public function destroy($id)
    {
        $id = base64_decode($id);
        $city = City::where('id' , $id)->firstOrFail();  
            if ($city->delete()) {
                return redirect()->back()->with('status', 'City Deleted Successfully!');
            }
        return redirect()->back()->with('error', 'Something Went Wrong!');
    }


}
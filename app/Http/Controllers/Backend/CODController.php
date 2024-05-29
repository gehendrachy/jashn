<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\City;
use App\Models\COD;
use App\Models\District;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class CODController extends Controller
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
        $cods = COD::orderBy('state_id')->orderBy('district_id')->orderBy('city_id')->get();

        return view('backend.cods.list',compact('cods' , 'cities'));
    }
    public function create()
    
    {
        $parent_state = State::orderBy('name')->get();
        $parent_district = District::orderBy('name')->get();
        $parent_city = City::orderBy('name')->get();
        return view('backend.cods.create-update',compact('parent_state','parent_district','parent_city'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            "status" => 'required',
        ]);

        $cod_create_update= COD::updateOrCreate([
                                    "state_id" => $request->state_id, 
                                    "district_id" => $request->district_id,
                                    "city_id" => $request->city_id,
                                ],
                                [
                                    "status" => $request->status,
                                    "display"=> 1,
                                    "created_by" => Auth::user()->name
                                ]);

        if ($cod_create_update) {

            return redirect()->route('admin.cods.index')->with('status','Cash on Delivery Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    public function show(COD $cod)
    {
        //
    }

    public function edit($id)
    {
        return redirect('404');
        $cod = COD::find(base64_decode($id));
        $parent_district = District::orderBy('name')->get();
        $parent_state = State::orderBy('name')->get();
        $parent_city = City::orderBy('name')->get();
        return view('backend.cods.create-update',compact('cod','parent_district','parent_state','parent_city'));
    }


    public function update(Request $request, Cod $cod)
    {

        $cod_updated = COD::updateOrCreate([
                                    "state_id" => $request->state_id, 
                                    "district_id" => $request->district_id,
                                    "city_id" => $request->city_id,
                                ],
                                [
                                    "status" => $request->status,
                                    "display"=> 1,
                                    "created_by" => Auth::user()->name
                                ]);

        if ($cod_updated) {

            return redirect()->route('admin.cods.index')->with('status','Cash on Delivery has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    public function destroy($id)
    {
        $id = base64_decode($id);
        $cod = Cod::where('id' , $id)->firstOrFail();  
            if ($cod->delete()) {
                return redirect()->back()->with('status', 'Cod Deleted Successfully!');
            }
        return redirect()->back()->with('error', 'Something Went Wrong!');
    }

    public function get_related_district(Request $request)
    {
       
        $state = State::find($request->state_id);
        $districts = $state->districts;
        $responseDistrict = '<option disabled selected>--Select District--</option>';
        
        foreach($districts as $dis){
            
            $responseDistrict .= '<option value="'.$dis->id.'">'.$dis->name.'</option>';
        }
        echo $responseDistrict;
    }

    public function get_related_city(Request $request)
    {
        
        $district = District::find($request->district_id);
    
        $cities = City::where('district_id', $request->district_id)->get();
        $responseCities =  '<option disabled selected>--Select City--</option>';

        foreach($cities as $cit){
          
            $responseCities .= '<option value="'.$cit->id.'">'.$cit->name.'</option>';
        }
        echo $responseCities;
    }

    public function change_cod_availability_status(Request $request)
    {
        $id = $request->id;
        $city = City::where('id', $id)->first();

        if ($city) {

            $city->cod = $city->cod == 1 ? 0 : 1;
            $city->save();
            echo "success";
            
        }else{
            echo "error";
        }
    }

}
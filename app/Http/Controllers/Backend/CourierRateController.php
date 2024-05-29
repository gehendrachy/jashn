<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CourierRate;
use App\Models\Courier;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\District;

class CourierRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parent_countries = Country::orderBy('name')->get();
        $parent_states = State::orderBy('name')->get();
        $courier_rates = CourierRate::all();
        return view('backend.courier-rates.list', compact('courier_rates','parent_states','parent_countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parent_courier = Courier::orderBy('name')->get();
        $parent_country = Country::orderBy('name')->get();
        $parent_city = City::orderBy('name')->get();
        return view('backend.courier-rates.create-update',compact('parent_courier','parent_country','parent_city'));
    }

    public function filters(Request $req)
    {
        //
        $parent_countries = Country::orderBy('name')->get();
        $parent_states = State::orderBy('name')->get();
        $courier_rates = CourierRate::where('country_id', $req->country_id)->where('state_id', $req->state_id)->get();
        return view('backend.courier-rates.list', compact('courier_rates','parent_states','parent_countries'));
      
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_update_courier_rates(Request $request)
    {
        
        $validateData = $request->validate([
            "country_id" => 'required',
            "state_id" => 'required',
            "courier_rates" => 'required'
        ]);
        // dd($_POST);
        $courier_rates = $request->courier_rates;
        foreach ($courier_rates as $courier_rate) {

            $courier_rate_created_updated = CourierRate::updateOrCreate([
                                                        "country_id"=> $request->country_id,
                                                        "state_id" => $request->state_id,
                                                        "district_id"=> $courier_rate['district_id']
                                                    ],
                                                    [
                                                        "half_kg"=> $courier_rate['half_kg'],
                                                        "one_kg"=> $courier_rate['one_kg'],
                                                        "one_half_kg" => $courier_rate['one_half_kg'],
                                                        "two_kg"=> $courier_rate['two_kg'],
                                                        "two_half_kg" => $courier_rate['two_half_kg'],
                                                        "three_kg"=> $courier_rate['three_kg'],
                                                        "three_half_kg"=> $courier_rate['three_half_kg'],
                                                        "four_kg"=> $courier_rate['four_kg'],
                                                        "four_half_kg"=> $courier_rate['four_half_kg'],
                                                        "five_kg"=> $courier_rate['five_kg'],
                                                        "per_500g"=> $courier_rate['per_500g'],
                                                        "display" => 1
                                                    ]);

        }

        if ($courier_rate_created_updated) {

            $selected_district_ids = collect($request->courier_rates)->pluck('district_id')->all();

            CourierRate::where([["country_id", $request->country_id],["state_id", $request->state_id]])
                        ->whereNotIn('district_id',$selected_district_ids)->update(['display' => 0]);

            return redirect()->route('admin.courier-rates.index')->with('status', 'Courier Rates Updated Successfully!');
        }else{
            return redirect()->back()->with('error','Something went Wrong!');
        }
        
    }

    
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $courier_rate = CourierRate::find(base64_decode($id));
        $parent_courier = Courier::orderBy('name')->get();
        $parent_country = Country::orderBy('name')->get();
        $parent_city = City::orderBy('name')->get();
        return view('backend.courier-rates.create-update', compact('courier_rate','parent_courier','parent_country','parent_city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourierRate $courier_rate)
    {
        //
        // dd($request);
        $updateArray = array(
           
            "courier_id" => $request->courier_id,
            "country_id" => $request->country_id,
            "city_id" => $request->city_id,
            "half_kg" => $request->half_kg,
            "one_kg" => $request->one_kg,
            "one_half_kg" => $request->one_half_kg,
            "two_kg"=> $request->two_kg,
            "two_half_kg" => $request->two_half_kg,
            "three_kg"=> $request->three_kg,
            "three_half_kg"=> $request->three_half_kg,
            "four_kg"=> $request->four_kg,
            "four_half_kg"=> $request->four_half_kg,
            "five_kg"=> $request->five_kg,
            "above_five_kg"=> $request->above_five_kg,
            "display" => $request->display,
            "updated_by" => Auth::user()->name,
            "updated_at" => date('Y-m-d h:i:s')
        );

        $courierR_updated = $courier_rate->update($updateArray);

        if ($courierR_updated) {
            return redirect()->route('admin.courier-rates.index')->with('status', 'Courier Rate has been Updated Successfully!');
        } 
        else {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
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
        $courier_rate = CourierRate::where('id' , $id)->firstOrFail();
            if ($courier_rate->delete()) {
                return redirect()->back()->with('status', 'Courier Rate Deleted Successfully!');
            }
        return redirect()->back()->with('error', 'Something Went Wrong!');
    }

    public function get_related_states(Request $request)
    {
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $country = Country::find($request->country_id);
        $states = $country->states;
        $responseStates = '';
        

        foreach($states as $state){
           
            $selected = $state->id == $state_id ? 'selected' : '';
            $responseStates .= '<option value="'.$state->id.'" '.$selected.'>'.$state->name.'</option>';
        }
        echo $responseStates;
    }


    public function get_district_courier_rates(Request $request)
    {
        $state_id = $request->state_id;
        $state = State::where('id',$state_id)->first();

        if ($state) {
            $districts = $state->districts;
            $tableResponse = '';
            foreach ($districts as $key => $district) {
                $db_courier_rate = CourierRate::where([['state_id', $state_id],['district_id',$district->id]])->first();

                $half_kg = isset($db_courier_rate) ? $db_courier_rate->half_kg : '';
                $one_kg = isset($db_courier_rate) ? $db_courier_rate->one_kg : '';
                $one_half_kg = isset($db_courier_rate) ? $db_courier_rate->one_half_kg : '';
                $two_kg = isset($db_courier_rate) ? $db_courier_rate->two_kg : '';
                $two_half_kg = isset($db_courier_rate) ? $db_courier_rate->two_half_kg : '';
                $two_kg = isset($db_courier_rate) ? $db_courier_rate->two_kg : '';
                $two_half_kg = isset($db_courier_rate) ? $db_courier_rate->two_half_kg : '';
                $three_kg = isset($db_courier_rate) ? $db_courier_rate->three_kg : '';
                $three_half_kg = isset($db_courier_rate) ? $db_courier_rate->three_half_kg : '';
                $four_kg = isset($db_courier_rate) ? $db_courier_rate->four_kg : '';
                $four_half_kg = isset($db_courier_rate) ? $db_courier_rate->four_half_kg : '';
                $five_kg = isset($db_courier_rate) ? $db_courier_rate->five_kg : '';
                $per_500g = isset($db_courier_rate) ? $db_courier_rate->per_500g : '';
                $active_status = isset($db_courier_rate) && $db_courier_rate->display == 1 ? '' : 'disabled' ;
                $display_status = isset($db_courier_rate) && $db_courier_rate->display == 1 ? 'checked' : '' ;
                $required_status = isset($db_courier_rate) && $db_courier_rate->display == 1 ? 'required' : '';

                $tableResponse .= '<tr>
                                    <td>
                                        <input class="active-status" type="checkbox" name="courier_rates['.$key.'][district_id]" value="'.$district->id.'" '.$display_status.'>
                                    </td>
                                    <td>'.$district->name.'</td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][half_kg]" value="'.$half_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][one_kg]" value="'.$one_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][one_half_kg]" value="'.$one_half_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][two_kg]" value="'.$two_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][two_half_kg]" value="'.$two_half_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][three_kg]" value="'.$three_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][three_half_kg]" value="'.$three_half_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][four_kg]" value="'.$four_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][four_half_kg]" value="'.$four_half_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][five_kg]" value="'.$five_kg.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                    <td>
                                        <input class="form-control decimal-input req-not-req-'.$district->id.' active-inactive-'.$district->id.'" type="text" name="courier_rates['.$key.'][per_500g]" value="'.$per_500g.'" '.$active_status.' '.$required_status.'>
                                    </td>
                                </tr>';
            }

        }else{
            $tableResponse = '<tr>
                                <td class="text-center" colspan="13" style="background-color: #a4797e !important; color: white;"><strong >Select State First</strong></td>
                            </tr>';

        }

        $response = array('message' => 'success', 'tableResponse' => $tableResponse);

        echo json_encode($response);
    }
}

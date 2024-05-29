<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Courier;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $couriers = Courier::all();
        return view('backend.couriers.list', compact('couriers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.couriers.create-update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
      
        $validateData = $request->validate([
            "name" => 'required|max:255',
            "phone" => 'required',
            "address" => 'required',
        ]);
        $insertArray = array(
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            'address' => $request->address,
            "display" => $request->display,
            "created_by" => Auth::user()->name
        );

        $courier_create = Courier::create($insertArray);

        if ($courier_create) {
            return redirect()->route('admin.couriers.index')->with('status', 'Courier Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong!');
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
        //
        $courier = Courier::find(base64_decode($id));
        return view('backend.couriers.create-update', compact('courier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Courier $courier)
    {
        //
        $updateArray = array(
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "display" => $request->display,
            "updated_by" => Auth::user()->name,
            "updated_at" => date('Y-m-d h:i:s')
        );

        $courier_updated = $courier->update($updateArray);

        if ($courier_updated) {
            return redirect()->route('admin.couriers.index')->with('status', 'Courier has been Updated Successfully!');
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
        $courier = Courier::where('id' , $id)->firstOrFail();
            if ($courier->delete()) {
                return redirect()->back()->with('status', 'Courier Deleted Successfully!');
            }
        return redirect()->back()->with('error', 'Something Went Wrong!');
    }
}

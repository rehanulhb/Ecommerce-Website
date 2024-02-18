<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipDistricts;
use App\Models\ShipDivision;
use App\Models\ShipState;
use Carbon\Carbon;

class ShippingAreaController extends Controller
{
    //
    public function AllDivision(){
        $division = ShipDivision::latest()->get();
        return view('backend.ship.division.division_all', compact('division'));
    }

    public function AddDivision(){
        return view('backend.ship.division.division_add');
    }


    public function StoreDivision(Request $request){

        ShipDivision::insert([
            
            'division_name' => $request->division_name,
            
            
        ]);

       $notification = array(
            'message' => 'Ship Division Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.division')->with($notification); 

    }
    public function EditDivision($id){
        $division = ShipDivision::findOrFail($id);
        return view('backend.ship.division.division_edit', compact('division'));
    }

    public function UpdateDivision(Request $request){
        $division_id = $request->id;

        ShipDivision::findOrFail($division_id)->update([
            'division_name' => $request->division_name,
            
        ]);

       $notification = array(
            'message' => 'Ship Division Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.division')->with($notification);

    }
    
    public function DeleteDivision($id){
        
        ShipDivision::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Division Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }


    ///// District Code

    public function AllDistrict(){
        $district = ShipDistricts::latest()->get();
        return view('backend.ship.district.district_all', compact('district'));
    }
    public function AddDistrict(){
        $division = ShipDivision::orderBy('division_name','ASC')->get();
        return view('backend.ship.district.district_add',compact('division'));
    }
    public function StoreDistrict(Request $request){

        ShipDistricts::insert([
            
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
            
            
        ]);

       $notification = array(
            'message' => 'Ship District Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.district')->with($notification); 

    }
    public function EditDistrict($id){
        $division = ShipDivision::orderBy('division_name','ASC')->get();
        $district = ShipDistricts::findOrFail($id);
        return view('backend.ship.district.district_edit', compact('district','division'));
    }

    public function UpdateDistrict(Request $request){
        $district_id = $request->id;

        ShipDistricts::findOrFail($district_id)->update([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
            
        ]);

       $notification = array(
            'message' => 'Ship Districts Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.district')->with($notification);

    }

    public function DeleteDistrict($id){
        
        ShipDistricts::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Ship Districts Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    public function AllState(){
        $state = ShipState::latest()->get();
        return view('backend.ship.state.state_all', compact('state'));
    }

    public function AddState(){
        $division = ShipDivision::orderBy('division_name','ASC')->get();
        $district = ShipDistricts::orderBy('district_name','ASC')->get();
        return view('backend.ship.state.state_add', compact('division','district'));
    }

    public function GetDistrict($division_id){
        $dist = ShipDistricts::where('division_id', $division_id)->orderBy('district_name', 'ASC')->get();
        return json_encode($dist);
    }

    public function StoreState(Request $request){

        ShipState::insert([
            
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
            
            
        ]);

       $notification = array(
            'message' => 'Ship State Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification); 

    }

    public function EditState($id){
        $division = ShipDivision::orderBy('division_name','ASC')->get();
        $district = ShipDistricts::orderBy('district_name','ASC')->get();
        $state = ShipState::findOrFail($id);
        return view('backend.ship.state.state_edit', compact('division','district','state'));
    }

    public function UpdateState(Request $request){
        $state_id = $request->id;

        ShipState::findOrFail($state_id)->update([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
            
        ]);

       $notification = array(
            'message' => 'Ship State Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification);

    }


}

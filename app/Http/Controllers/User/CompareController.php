<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Compare;
use Carbon\Carbon;

class CompareController extends Controller
{
    //

    public function AddToCompare(Request $request, $product_id){

        if(Auth::check()){
                $exists = Compare::where('user_id', Auth::id())->where('product_id',$product_id)->first();


                if(!$exists){
                        Compare::insert([
                            'user_id' => Auth::id(),
                            'product_id' => $product_id,
                            'created_at' => Carbon::now(),


                        ]);
                        return response()->json(['success' => "Successfully Added to Compare"]);
                }else{
                    return response()->json(['error' => "This Product is Already on your Compare"]);
                }
                 
        }else{
            return response()->json(['error' => "Please Login to your account"]);
        }

    }


    public function AllCompare(){
        return view('frontend.compare.view_compare');

    }

    //End compare




}

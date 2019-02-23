<?php

namespace Workload\Http\Controllers\customer;

use Illuminate\Http\Request;
use Workload\Http\Controllers\Controller;
use DB;
use Workload\User;
use Validator;
use Auth;

class CustomerController extends Controller
{
    public function getAllCustomer()
    {
    	//2 for customers
        $customers = User::where('role', 2)->get();

        if(count($customers) > 0){
        return response()->json(['customers' => $customers], 200);
		}

		return response()->json(['error' => 'No customers created yet']);
    }


    public function getCustomerByid(Request $request , $id)
    {
        $customerById = User::where('id', $id)->where('role', 2)->get();

        if(count($customerById) > 0){
            return response()->json([
            	'status' => 'success',
            	'Customer' => $customerById

            ], 200);

    }else{
    	return response()->json([
    		'status' => 'failure',
    		'message' => 'Customer dont exist'
    	]);
    }
}


    public function updateCustomerProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            	'sex' => 'required',
                //'username' => 'required|unique:users',
                //'email' => 'required|email|unique:users',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                //'mobile' => 'digits_between:11,13',
                //'role' => 'required|in:1,2',
                'specialization' => 'required_if:user_type,2',
                'state' => 'required|integer',
                'lga' => 'required|integer',
                //'state' => 'exists:states,id',
                //'lga' => 'exists:lgas,id',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
        ]);

        //$CustomerId = Auth::user()->id;
        $new_customer = User::find($id);

        $new_customer->first_name = $request->input('first_name');
        $new_customer->last_name = $request->input('last_name');
        //$new_customer->username = $request->input('username');
        //$new_customer->email = $request->input('email');
        $new_customer->state = $request->input('state');
        //$new_customer->mobile = $request->input('mobile');
        //$new_customer->activation_token = bcrypt(str_random(40));
        $new_customer->lga = $request->input('lga');
        $new_customer->sex = $request->input('sex');
        $new_customer->specialization = $request->input('specialization');
        $new_customer->password = $request->input('password');
        //$new_customer->bio = $request->input('bio');
        // file upload here now
        //$avatar_file = $request->file('avatar');

        //echo $avatar_file;
        // $avatar_name = $avatar_file->getClientOriginalName();
        $image_name = bcrypt(time()). $request->input('avatar');


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


            $new_customer->save();
            return response()->json([
                'status' => 'success',
                'message' => "Customer Profile Updated Successfully"
            ]);

    }


}

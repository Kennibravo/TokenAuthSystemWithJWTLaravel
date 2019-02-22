<?php

namespace Workload\Http\Controllers\artisan;

use Illuminate\Http\Request;
use Workload\Http\Controllers\Controller;
use DB;
use Workload\User;
use Validator;

class ArtisanController extends Controller
{
    public function getAllArtisan()
    {
        //3 for artisans
        $artisans = User::where('role', 3)->get();

        if(count($artisans) > 0){
        return response()->json(['artisans' => $artisans], 200);
        }

        return response()->json(['error' => 'No artisans created yet']);
    }


    public function getArtisanByid(Request $request , $id)
    {
        $artisanById = User::where('id', $id)->where('role', 3)->get();

        if(count($artisanById) > 0){
            return response()->json([
                'status' => 'success',
                'Customer' => $artisanById

            ], 200);

    }else{
        return response()->json([
            'status' => 'failure',
            'message' => 'Artisan dont exist'
        ]);
    }
}


    public function updateArtisanProfile(Request $request, $id)
    {

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
        $new_artisan = User::find($id);

        $new_artisan->first_name = $request->input('first_name');
        $new_artisan->last_name = $request->input('last_name');
        //$new_artisan->username = $request->input('username');
        //$new_artisan->email = $request->input('email');
        $new_artisan->state = $request->input('state');
        //$new_artisan->mobile = $request->input('mobile');
        //$new_artisan->activation_token = bcrypt(str_random(40));
        $new_artisan->lga = $request->input('lga');
        $new_artisan->sex = $request->input('sex');
        $new_artisan->specialization = $request->input('specialization');
        $new_artisan->password = $request->input('password');
        //$new_artisan->bio = $request->input('bio');
        // file upload here now
        //$avatar_file = $request->file('avatar');

        //echo $avatar_file;
        // $avatar_name = $avatar_file->getClientOriginalName();
        $image_name = bcrypt(time()). $request->input('avatar');
        
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


            $new_artisan->save();
            return response()->json([
                'status' => 'success',
                'message' => "Artisan Profile Updated Successfully"
            ]);

    }
    
    
}

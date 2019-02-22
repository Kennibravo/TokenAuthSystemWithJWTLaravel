<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Artisan;
use DB;
use Validator;
// use Illuminate\Support\Facades\Artisan;
class ArtisanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all()
    {
        $all = Artisan::get();
        // count the number of available items
        if($all->count() > 0 ){
            return response()->json([
                'message' => 'success',
                'result' => $all
            ]);
        }else{
            return response()->json([
                'message' => 'success',
                'result' => 'No Artisan Found'
            ]);
        }

    }
    public function get_id(Request $request , $id)
    {
        $find_by_id = Artisan::find($id);

        if(is_null($find_by_id) == true){
            return response()->json([
                'message' => 'success',
                'result' => 'Artisan Not Found'
            ]);
        }else{
            return response()->json([
                'message' => 'success',
                'result' => $find_by_id
            ]);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:artisans',
            'password' => 'required|min:6',
            'mobile' => 'required|unique:artisans',
            'state' => 'required',
            'lga' =>'required',
            'sex' => 'required',
            'specialization' => 'required',
            'bio' => 'required',
            'avatar' => 'required'
        ]);


        $new_artisan = new Artisan();
        $new_artisan->first_name = $request->input('first_name');
        $new_artisan->last_name = $request->input('last_name');
        $new_artisan->username = $request->input('username');
        $new_artisan->email = $request->input('email');
        $new_artisan->state = $request->input('state');
        $new_artisan->mobile = $request->input('mobile');
        $new_artisan->activation_token = bcrypt(str_random(40));
        $new_artisan->lga = $request->input('lga');
        $new_artisan->sex = $request->input('sex');
        $new_artisan->specialization = $request->input('specialization');
        $new_artisan->password = $request->input('password');
        $new_artisan->bio = $request->input('bio');
        // file upload here now
        $avatar_file = $request->file('avatar');

        echo $avatar_file;
        // $avatar_name = $avatar_file->getClientOriginalName();
        $image_name = bcrypt(time()). $request->input('avatar');
        // if ($request->avatar) {

        //     //moving the file to the uploads folder
        //     $destinationPath = 'uploads/';

        //     // $move_file = $avatar_file->move($destinationPath, $image_name );
        //     // $request->merge(['avatar' => $image_name]);
        //     // $avatar = public_path('uploads/');
        //     // if (file_exists($image_name)) {
        //     //     @unlink($destinationPath. $image_name);
        //     // }
        // }

        $new_artisan->avatar = $image_name;
        //$request->input('avatar');

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


            $new_artisan->save();
            return response()->json([
                'message' => 'success',
                'result' => 'Artisan Successfully Added'
            ]);

    }
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:artisans',
            'password' => 'required|min:6',
            'mobile' => 'required|unique:artisans',
            'state' => 'required',
            'lga' => 'required',
            'sex' => 'required',
            'specialization' => 'required',
            'bio' => 'required',
            'avatar' => 'required'
        ]);
        $changed_artisan = Artisan::find($id);

        if($changed_artisan != NULL){
            $changed_artisan->first_name = $request->input('first_name');
            $changed_artisan->last_name = $request->input('last_name');
            $changed_artisan->username = $request->input('username');
            $changed_artisan->email = $request->input('email');
            $changed_artisan->state = $request->input('state');
            $changed_artisan->mobile = $request->input('mobile');
            $changed_artisan->activation_token = bcrypt(str_random(40));
            $changed_artisan->lga = $request->input('lga');
            $changed_artisan->sex = $request->input('sex');
            $changed_artisan->specialization = $request->input('specialization');
            $changed_artisan->password = $request->input('password');
            $changed_artisan->bio = $request->input('bio');
            // file upload also goes here if available here now
            $avatar_file = bcrypt(time()) . $request->input('avatar'); // name of the avatar file
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $changed_artisan->save();
            return response()->json([
                'message' => 'success',
                'result' => 'Artisan Successfully changed'
            ]);
        }else{
            return response()->json([
                'message' => 'failure',
                'result' => $changed_artisan
            ]);
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
        $artisan = Artisan::find($id);
        $action = $artisan->delete();
        if($action){
            return response()->json([
                'message' => 'Success',
                'result' => "Artisan Deleted Successfully"
            ]);
        }else{
            return response()->json([
                'message' => 'failure',
                'result' => 'Artisan not found'
            ]);
        }
    }
}

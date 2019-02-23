<?php

namespace Workload\Http\Controllers\customer;

use Illuminate\Http\Request;
use Workload\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Workload\User;
use Auth;
use Workload\Service;


class CustomerServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerId = Auth::user()->id;

        $allServices = Service::where('user_id', $customerId)->get();

        if(count($allServices) > 0){
        return response()->json([
          'status' => 'success',
          'id' => $customerId,
          'services' => $allServices
        ], 200);
    }else{
      return response()->json([
        'status' => 'failure',
        'message' => 'No services created by the user yet'
      ], 404);
    }
  }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'id_string' => 'required|max:255',
            'category_id' => 'required',
            'description' => 'required|string|max:500',
            'budget' => 'required|integer',
            'id_lga' => 'integer',
            'id_state' => 'integer',
            'slug' => 'max:255',
            'landmark' => 'string|max:255',
            'priority' => 'string|max:255',
            'attachment' => 'string|max:255',
            'photo' => 'string|max:255',
            'title' => 'required|max:255',
            'remote' => 'required|max:255',
            'contract' => 'required|max:255',

          ]);

          if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->toJson()], 400);
          }else{

            $customerId = Auth::user()->id;
            $service = new Service;
            $service->id_string = $request->get('id_string');
            $service->user_id = $customerId;
            $service->category_id = $request->get('category_id');
            $service->description = $request->get('description');
            $service->budget = $request->get('budget');
            $service->id_lga = $request->get('id_lga');
            $service->id_state = $request->get('id_state');
            $service->slug = str_slug($request->description, '-');
            $service->landmark = $request->get('landmark');
            $service->priority = $request->get('priority');
            $service->attachment = $request->get('attachment');
            $service->photo = $request->get('photo');
            $service->title = $request->get('title');
            $service->remote = $request->get('remote');
            $service->contract = $request->get('contract');
            $service->status = $request->get('status');
            //$table->start_date = Carbon::now();


          }

          $service->save();
          return response()->json([
            'status' => 'success',
            'message' => 'Service successfully created'
          ], 200);
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customerId = Auth::user()->id;
        $service = Service::where('user_id', $customerId)->find($id);

        if($service != NULL){
        return response()->json([
          'status' => 'success',
          'service' => $service
        ], 200);

    }else{
        return response()->json([
          'status' => 'failure',
          'message' => 'Service does not exist, or may not exist for the current user'
        ], 404);
    }
  }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [
        //'id_string' => 'required|max:255',
        'category_id' => 'required',
        'description' => 'required|string|max:500',
        'budget' => 'required|integer',
        'id_lga' => 'integer',
        'id_state' => 'integer',
        //'slug' => 'max:255',
        'landmark' => 'string|max:255',
        'priority' => 'string|max:255',
        'attachment' => 'string|max:255',
        'photo' => 'string|max:255',
        'title' => 'required|max:255',
        'remote' => 'required|max:255',
        'contract' => 'required|max:255',

      ]);

      if($validator->fails()){
        return response()->json(['errors' => $validator->errors()->toJson()], 400);
    }else{
      $customerId = Auth::user()->id;
      $service = Service::where('user_id', $customerId)->find($id);

      if($service == NULL){
        return response()->json([
          'status' => 'failure',
          'message' => 'Service does not exist, or may not exist for the current user'
        ], 404);
      }

      //$service->id_string = $request->input('id_string');
      $service->user_id = $customerId;
      $service->category_id = $request->input('category_id');
      $service->description = $request->input('description');
      $service->budget = $request->input('budget');
      $service->id_lga = $request->input('id_lga');
      $service->id_state = $request->input('id_state');
      //$service->slug = str_slug($request->description, '-');
      $service->landmark = $request->input('landmark');
      $service->priority = $request->input('priority');
      $service->attachment = $request->input('attachment');
      $service->photo = $request->input('photo');
      $service->title = $request->input('title');
      $service->remote = $request->input('remote');
      $service->contract = $request->input('contract');
      $service->status = $request->input('status');
    }

      $service->save();
      return response()->json([
        'status' => 'success',
        'message' => 'Service updated successfully'
      ]);
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customerId = Auth::user()->id;
        $service = Service::where('user_id', $customerId)->find($id);

        if($service == NULL){
        return response()->json([
          'status' => 'failure',
          'message' => 'Service does not exist, or may not exist for the current user'
        ], 404);
      }else{
            $service->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Service deleted successfully'
            ]);
      }

    }
}

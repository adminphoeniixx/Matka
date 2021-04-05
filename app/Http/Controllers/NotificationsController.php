<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Datatables;  
use App\User;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notifications.index');
    }

   
    public function notificationsdata()
    {
         $users = Notification::latest();
        return Datatables::of($users)
           ->addColumn('action', function ($users) {
            $deleteroute =route('destroynotification',['id'=>$users->id]);
               return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
                <a style="margin-right:5px;" class="btn btn-danger" href="'.$deleteroute.'">Delete</a>
                </div>';
           })
           ->escapeColumns([])
           ->make(true);
    }


    public function create (){

        $users= User::where('role_id',2)->get();
        return view('notifications.add',['users'=>$users]);
    }

   
    public function store(Request $request)
    {
        $data = new Notification;
        $data->title = $request->title;
        $data->message = $request->messagebody;
        $data->save();

        if ($request->sendtype=='selected') {
            
            foreach ($request->users as $key => $value) {
               
            }
        }else{

        }



        return redirect()->route('notifications')->with(['message' => "Notification Added Successfully.", 'alert-type' => 'success']);
    }


    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }


    public function update(Request $request, Notification $notification)
    {
        //
    }

    public function destroy($id)
    {
        $data = Notification::destroy($id);
        return redirect()->route('notifications')->with(['message' => "Notification Deleted Successfully.", 'alert-type' => 'success']);

    }
}

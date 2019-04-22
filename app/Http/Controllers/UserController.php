<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Undo;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $undoDeleted = Undo::where('user_id','<>',null)->where('type','Deleted')->first();
        return view('users.index',compact('users','undoDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        if($request->roles)
        {
            $user->assignRole($request->roles);
        }
        return redirect()->back()->with('success','Successfully created new user '.$user->name);
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
        $user = User::find($id);
        $roles = Role::all();
        $undoEdited = Undo::where('type','Edited')->where('user_id',$user->id)->first();
        return view('users.edit',compact('user','roles','undoEdited'));
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
        if($request->password)
        {
            $this->validate($request,[
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
            ]);
            $user = User::find($id);
            $properties = $user->toJson();
            $roleIds = $user->roles()->pluck('id');
            $properties = json_decode($properties);
            $properties->roles = $roleIds;
            $properties = json_encode($properties);
            $hasUndo = Undo::where('user_id','<>',null)->where('type','Edited')->first();
            //dd($hasUndo);
            if($hasUndo == null)
            {
                $undo = Undo::create([
                    'properties' => $properties,
                    'type' => 'Edited',
                    'user_id' => $user->id,
                ]);
            }
            else
            {
                $hasUndo->update([
                    'properties' => $properties,
                    'type' => 'Edited',
                    'user_id' => $user->id,
                ]);
            } 
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            if($request->roles)
            {
                $user->syncRoles($request->roles);
            }
            return redirect()->back()->with('success','Successfully updated user '.$user->name);
        }
        else
        {
            $this->validate($request,[
                'name' => 'required',
                'email' => 'required|email',
            ]);
            $user = User::find($id);
            $properties = $user->toJson();
            $roleIds = $user->roles()->pluck('id');
            $properties = json_decode($properties);
            $properties->roles = $roleIds;
            $properties = json_encode($properties);
            $hasUndo = Undo::where('user_id','<>',null)->where('type','Edited')->first();
            if($hasUndo == null)
            {
                $undo = Undo::create([
                    'properties' => $properties,
                    'type' => 'Edited',
                    'user_id' => $user->id,
                ]);
            }
            else
            {
                $hasUndo->update([
                    'properties' => $properties,
                    'type' => 'Edited',
                    'user_id' => $user->id,
                ]);
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            if($request->roles)
            {
                $user->syncRoles($request->roles);
            }
            return redirect()->back()->with('success','Successfully updated user '.$user->name);
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
        $user = User::find($id);
        $name = $user->name;
        $roleIds = $user->roles()->pluck('id');
        $properties = $user->toJson();
        $properties = json_decode($properties);
        $properties->roles = $roleIds;
        $properties = json_encode($properties);
        $hasUndo = Undo::where('user_id','<>',null)->where('type','Deleted')->first();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Deleted',
                'user_id' => $user->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Deleted',
                'user_id' => $user->id,
            ]);
        }
        $user->delete();
        return redirect()->back()->with('success','Successfully deleted user '.$name);
    }

    public function undoDeleted()
    {
        $undo = Undo::where('user_id','<>',null)->where('type','Deleted')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $user = User::create([
                'name' => $props->name,
                'email' => $props->email,
                'password' => $props->password,
            ]);
            $roles = Role::find($props->roles);
            if($roles)
            {
                $user->assignRole($roles);
            }
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully restore last deleted user.');
        }
    }

    public function undoEdited($id)
    {
        $user = User::find($id);
        $undo = Undo::where('user_id',$id)->where('type','Edited')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $user->update([
                'name' => $props->name,
                'email' => $props->email,
                'password' => $props->password,
            ]);
            $roles = Role::find($props->roles);
            $user->syncRoles($roles);
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully undo user');
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Undo;
use App\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles  = Role::all();
        $undoDeleted = Undo::where('role_id','<>',null)->where('type','Deleted')->first();
        return view('roles.index',compact('roles','undoDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create',compact('permissions'));
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
        ]);
        $role = Role::create([
            'name' => $request->name,
        ]);
        if($request->permissions)
        {
            foreach($request->permissions as $permission)
            {
                $role->givePermissionTo($permission);
            }
        }
        return redirect()->back()->with('success','Successfully created new role '.$role->name);
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
        $role = Role::find($id);
        $permissions = Permission::all();
        $undoEdited = Undo::where('role_id',$role->id)->where('type','Edited')->first();
        return view('roles.edit',compact('role','permissions','undoEdited'));
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
        //dd($request->all());
        $this->validate($request,[
            'name' => 'required',
        ]);
        $role = Role::find($id);
        $properties = $role->toJson();
        $permissionIds = $role->permissions()->pluck('id');
        $properties = json_decode($properties);
        $properties->permissions = $permissionIds;
        $properties = json_encode($properties);
        $hasUndo = Undo::where('role_id','<>',null)->where('type','Edited')->first();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Edited',
                'role_id' => $role->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Edited',
                'role_id' => $role->id,
            ]);
        }
        $role->update([
            'name' => $request->name,
        ]);
        
        $role->syncPermissions($request->permissions);
        return redirect()->back()->with('success','Successfully updated role '.$role->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $name = $role->name;
        $hasUndo = Undo::where('role_id','<>',null)->where('type','Deleted')->first();
        $properties = $role->toJson();
        $permissionIds = $role->permissions()->pluck('id');
        $userIds = $role->users()->pluck('id');
        $properties = json_decode($properties);
        $properties->permissions = $permissionIds;
        $properties->users = $userIds;
        $properties = json_encode($properties);
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Deleted',
                'role_id' => $role->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Deleted',
                'role_id' => $role->id,
            ]);
        }
        $role->delete();
        return redirect()->back()->with('success','Successfully deleted role '.$name);
    }

    public function undoDeleted()
    {
        $undo = Undo::where('role_id','<>',null)->where('type','Deleted')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $role = Role::create([
                'name' => $props->name,
            ]);
            $permissions = Permission::find($props->permissions);
            $users = User::find($props->users);
            foreach($permissions as $permission)
            {
                $role->givePermissionTo($permission);
            }
            foreach($users as $user)
            {
                $user->assignRole($role);
            }
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully restore last deleted role.');
        }
    }

    public function undoEdited($id)
    {
        $role = Role::find($id);
        $undo = Undo::where('role_id',$id)->where('type','Edited')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $role->update([
                'name' => $props->name,
            ]);
            $permissions = Permission::find($props->permissions);
            $role->syncPermissions($permissions);
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully undo role');
        }
    }

}

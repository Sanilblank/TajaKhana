<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //
        if ($request->user()->can('manage-user')) {
            if ($request->ajax()) {
                $data = User::latest()->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                                $editurl = route('user.edit', $row->id);
                                $deleteurl = route('user.destroy', $row->id);
                                $csrf_token = csrf_token();
                            $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                                return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            return view('backend.user.index');
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if ($request->user()->can('manage-user')) {
            $roles = Role::where('id', '!=', 4)->get();
            return view('backend.user.create', compact('roles'));
        }else{
            return view('backend.permission.permission');
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
        //
        if ($request->user()->can('manage-user')) {
            $data = $this->validate($request, [
                'name'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:users',
                'role_id'=>'required|integer',
                'password' => 'sometimes|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->roles()->attach($data['role_id']);
            $permissions = RolePermission::where('role_id', $data['role_id'])->get();
            $selectedperm = array();
                foreach($permissions as $permission){
                    $selectedperm[] = $permission->permission_id;
                }
            $user->permissions()->attach($selectedperm);
            $user->save();
            return redirect()->route('user.index')->with('success', 'User Successfully Created');
        }
        else{
            return view('backend.permission.permission');
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
    public function edit(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-user')) {
            $user = User::findorfail($id);
            $userrole = UserRole::where('user_id', $id)->first();
            $roles = Role::all();
            return view('backend.user.edit', compact('user', 'userrole', 'roles'));
        }else{
            return view('backend.permission.permission');
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
        //
        if ($request->user()->can('manage-user')) {
            $user = User::findorfail($id);
            if(isset($_POST['updatedetails'])){
                $data = $this->validate($request, [
                    'name'=>'required|string|max:255',
                    'email'=>'required|string|email|max:255|unique:users,email,'.$user->id,
                    'role_id'=>'required',
                ]);
                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                ]);
                $user->roles()->sync($data['role_id']);
                $permissions = RolePermission::where('role_id', $data['role_id'])->get();
                $selectedperm = array();
                foreach($permissions as $permission){
                    $selectedperm[] = $permission->permission_id;
                }
                $user->permissions()->sync($selectedperm);
                $user->save();
                return redirect()->route('user.index')->with('success', 'UserDetails Successfully updated');
            }
            elseif(isset($_POST['updatepassword'])){
                $data = $this->validate($request, [
                    'oldpassword' => 'required',
                    'new_password' => 'sometimes|min:8|confirmed|different:password',
                ]);

                if (Hash::check($data['oldpassword'], $user->password)) {
                    if (!Hash::check($data['new_password'] , $user->password)) {
                        $newpass = Hash::make($data['new_password']);

                        $user->update([
                            'password' => $newpass,
                        ]);
                        $user->save;
                        session()->flash('success','password updated successfully');
                        return redirect()->route('user.index');
                    }

                    else{
                            session()->flash('success','new password can not be the old password!');
                            return redirect()->back();
                        }

                    }

                else {
                    $request->session()->flash('success', 'Password does not match');
                    return redirect()->route('user.index');
                }
            }
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-user')) {
            $user = User::findorfail($id);
            $user->delete();

            return redirect()->route('user.index')->with('success', 'User Successfully Deleted');
        }
        else{
            return view('backend.permission.permission');
        }
    }
}

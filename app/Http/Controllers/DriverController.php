<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->user()->can('manage-user')) {
            if ($request->ajax()) {
                $data = Driver::latest()->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('photo', function($row){
                            $photo = Storage::disk('uploads')->url($row->photo);
                            $img = "<img src = '$photo' style='max-height:100px'>";
                            return $img;
                        })
                        ->addColumn('citizenship', function($row){
                            $citizenship = Storage::disk('uploads')->url($row->citizenship);
                            $link = "<a href='$citizenship' target='_blank'>Click here</a>";
                            return $link;
                        })
                        ->addColumn('license', function($row){
                            $license = Storage::disk('uploads')->url($row->license);
                            $link = "<a href='$license' target='_blank'>Click here</a>";
                            return $link;
                        })
                        ->editColumn('status', function($row){
                            if($row->status == 1){
                                $status = 'Active';
                            }else{
                                $status = 'Inactive';
                            }
                            return $status;
                        })

                        ->addColumn('action', function($row){
                                $editurl = route('driver.edit', $row->id);
                                $deleteurl = route('driver.destroy', $row->id);
                                $csrf_token = csrf_token();
                            $btn = "
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                                return $btn;
                        })
                        ->rawColumns(['photo', 'citizenship', 'license', 'action'])
                        ->make(true);
            }
            return view('backend.driver.index');
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
            return view('backend.driver.create');
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
        $data = $this->validate($request, [
            'fullname' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg',
            'citizenship' => 'required|mimes:pdf',
            'license' => 'required|mimes:pdf',
            'status' => 'required',
            'password' => 'required',
        ]);

            $photoname = '';
            if($request->hasfile('photo')){
                $image = $request->file('photo');
                $photoname = $image->store('driver_images', 'uploads');
            }
            $citizenshipname = '';
            if($request->hasfile('citizenship')){
                $cimage = $request->file('citizenship');
                $citizenshipname = $cimage->store('driver_documents', 'uploads');
            }
            $licensename = '';
            if($request->hasfile('license')){
                $limage = $request->file('license');
                $licensename = $limage->store('driver_documents', 'uploads');
            }

        $driver = Driver::create([
            'fullname' => $data['fullname'],
            'address' => $data['address'],
            'email' => $data['email'],
            'photo' => $photoname,
            'license' => $licensename,
            'citizenship' => $citizenshipname,
            'phone' => $data['phone'],
            'status' => $data['status'],
            'verified' => 1,
        ]);
        $driver->save();

        $user = User::create([
            'name' => $data['fullname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_verified' => 1,
        ]);
        $user->roles()->attach(4);
            $user->save();

            return redirect()->route('driver.index')->with('success', 'Driver Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-user')) {
            $driver = Driver::findorfail($id);

            return view('backend.driver.edit', compact('driver'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-user')) {
            $driver = Driver::findorfail($id);
            $user = User::where('email', $driver->email)->first();
            $data = $this->validate($request, [
                'fullname' => 'required',
                'address' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'photo' => 'mimes:png,jpg,jpeg',
                'citizenship' => 'mimes:pdf',
                'license' => 'mimes:pdf',
                'status' => 'required',
            ]);

            $photoname = '';
            if($request->hasfile('photo')){
                $image = $request->file('photo');
                Storage::disk('uploads')->delete($driver->photo);
                $photoname = $image->store('driver_images', 'uploads');
            } else {
                $photoname = $driver->photo;
            }
            $citizenshipname = '';
            if($request->hasfile('citizenship')){
                $cimage = $request->file('citizenship');
                Storage::disk('uploads')->delete($driver->citizenship);
                $citizenshipname = $cimage->store('driver_documents', 'uploads');
            } else {
                $citizenshipname = $driver->citizenship;
            }
            $licensename = '';
            if($request->hasfile('license')){
                $limage = $request->file('license');
                Storage::disk('uploads')->delete($driver->license);
                $licensename = $limage->store('driver_documents', 'uploads');
            } else {
                $licensename = $driver->license;
            }

            $driver->update([
                'fullname' => $data['fullname'],
                'address' => $data['address'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'photo' => $photoname,
                'citizenship' => $citizenshipname,
                'license' => $licensename,
                'status' => $data['status'],
            ]);

            $user->update([
                'name' => $data['fullname'],
                'email' => $data['email'],
            ]);

            return redirect()->route('driver.index')->with('success', 'Driver Updated Successfully.');

        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-user')) {
            $driver = Driver::findorfail($id);
            $user = User::where('email', $driver->email)->first();

            Storage::disk('uploads')->delete($driver->photo);
            Storage::disk('uploads')->delete($driver->citizenship);
            Storage::disk('uploads')->delete($driver->license);

            $driver->delete();
            $user->delete();
            return redirect()->back()->with('success', 'Driver Deleted Successfully.');
        }else{
            return view('backend.permission.permission');
        }
    }
}

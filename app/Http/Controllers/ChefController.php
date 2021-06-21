<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Chef;
use App\Models\ChefResponsibility;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ChefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->user()->can('manage-branch')) {
            if ($request->ajax()) {
                $data = Chef::latest()->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('photo', function ($row) {
                            $photo = Storage::disk('uploads')->url($row->photo);
                            $img = "<img src = '$photo' style='max-height:100px'>";
                            return $img;
                        })
                        ->addColumn('branch', function ($row) {
                            return $row->branch->branchlocation;
                        })
                        ->addColumn('action', function($row){

                                $responsibilty = route('chefresponsibility.index', $row->id);
                                $editurl = route('chef.edit', $row->id);
                                $deleteurl = route('chef.destroy', $row->id);
                                $csrf_token = csrf_token();
                            $btn = "
                            <a href='$responsibilty' class='edit btn btn-warning btn-sm'>Responsibilities</a>
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                                return $btn;
                        })
                        ->rawColumns(['photo', 'branch', 'action'])
                        ->make(true);
            }
            return view('backend.chef.index');
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
        if ($request->user()->can('manage-branch')) {

            $branches = Branch::where('status', 1)->latest()->get();
            return view('backend.chef.create', compact('branches'));
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
            'name' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg',
            'branch_id' => 'required',
            'contact' =>'required',
            'details' => 'required',
        ]);

        $photoname = '';
        if($request->hasFile('photo'))
        {
            $image = $request->file('photo');
            $photoname = $image->store('chef_images', 'uploads');
        }

        $chef = Chef::create([
            'branch_id' => $data['branch_id'],
            'name' => $data['name'],
            'photo' => $photoname,
            'contact' => $data['contact'],
            'details' => $data['details'],
            'facebook' => $request['facebook'],
            'linkedin' => $request['linkedin'],
            'youtube' => $request['youtube'],
            'instagram' => $request['instagram'],
        ]);

        $chef->save();
        return redirect()->route('chef.index')->with('success', 'Employee Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function show(Chef $chef)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {
            $chef = Chef::findorfail($id);
            $branches = Branch::where('status', 1)->latest()->get();
            return view('backend.chef.edit', compact('chef', 'branches'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $res = 0;
        $chef = Chef::findorfail($id);
        $data = $this->validate($request, [
            'name' => 'required',
            'photo' => 'mimes:png,jpg,jpeg',
            'branch_id' => 'required',
            'contact' =>'required',
            'details' => 'required',
        ]);

        $chefphoto = '';
            if($request->hasfile('photo')){
                Storage::disk('uploads')->delete($chef->photo);
                $image = $request->file('photo');
                $chefphoto = $image->store('chef_images', 'uploads');
            }
            else {
                $chefphoto = $chef->photo;
            }

        if($data['branch_id'] != $chef->branch_id)
        {
            $responsibilities = ChefResponsibility::where('chef_id', $chef->id)->get();
            if(count($responsibilities) > 0)
            {
                foreach($responsibilities as $responsibility)
                {
                    $responsibility->delete();
                }
            }

            $res = 1;
        }

        $chef->update([
            'branch_id' => $data['branch_id'],
            'name' => $data['name'],
            'photo' => $chefphoto,
            'contact' => $data['contact'],
            'details' => $data['details'],
            'facebook' => $request['facebook'],
            'linkedin' => $request['linkedin'],
            'youtube' => $request['youtube'],
            'instagram' => $request['instagram'],
        ]);

        if($res == 1)
        {
            return redirect()->route('chef.index')->with('success', 'Employee Updated and responsibilities deleted as branch has been changed.');

        }
        else
        {
            return redirect()->route('chef.index')->with('success', 'Employee Updated Successfully.');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {
            $chef = Chef::findorfail($id);
            Storage::disk('uploads')->delete($chef->photo);
            $chef->delete();
            return redirect()->back()->with('success', 'Chef Deleted Successfully.');
        }else{
            return view('backend.permission.permission');
        }
    }
}

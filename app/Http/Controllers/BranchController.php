<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Chef;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
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
                $data = Branch::latest()->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('status', function ($row) {
                            if($row->status == 1)
                            {
                                $status = '<span class="badge bg-green" style="background-color: green";>Active</span>';
                            }
                            else
                            {
                                $status = '<span class="badge bg-danger" style="color: white";>Inactive</span>';
                            }
                            return $status;
                        })


                        ->addColumn('branchimage', function ($row) {
                            $photo = Storage::disk('uploads')->url($row->branchimage);
                            $img = "<img src = '$photo' style='max-height:100px'>";
                            return $img;
                        })
                        ->addColumn('action', function($row){
                                $branchmenu = route('branchmenu.index', $row->id);
                                $editurl = route('branch.edit', $row->id);
                                $deleteurl = route('branch.destroy', $row->id);
                                $csrf_token = csrf_token();
                            $btn = "
                            <a href='$branchmenu' class='edit btn btn-warning btn-sm'>Menu</a>
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                                return $btn;
                        })
                        ->rawColumns(['status', 'branchimage', 'action'])
                        ->make(true);
            }
            return view('backend.branch.index');
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
            return view('backend.branch.create');
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
            'branchname' => 'required',
            'branchlocation' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'branchimage' => 'required|mimes: jpg,png,jpeg',
        ]);

        $exists = Branch::where('branchlocation', $data['branchlocation'])->where('branchname', $data['branchname'])->first();
        if($exists)
        {
            return back()->with('failure', 'Branch at that location with same name already exists.');
        }

            $branchimage = '';
            if($request->hasfile('branchimage')){
                $image = $request->file('branchimage');
                $branchimage = $image->store('branch_images', 'uploads');
            }

        $branch = Branch::create([
            'branchname' => $data['branchname'],
            'branchlocation' => $data['branchlocation'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'phone' => $data['phone'],
            'status' => $data['status'],
            'branchimage' => $branchimage,
        ]);

        $branch->save();
        return redirect()->route('branch.index')->with('success', 'Branch Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {
            $branch = Branch::findorfail($id);
            return view('backend.branch.edit', compact('branch'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $branch = Branch::findorfail($id);
        $chef = Chef::where('branch_id', $id)->first();
        $data = $this->validate($request, [
            'branchname' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'branchimage' => 'mimes:png,jpg,jpeg',

        ]);

            $branchimage = '';
            if($request->hasfile('branchimage')){
                Storage::disk('uploads')->delete($branch->branchimage);
                $image = $request->file('branchimage');
                $branchimage = $image->store('branch_images', 'uploads');
            }
            else {
                $branchimage = $branch->branchimage;
            }

        $branch->update([
            'branchname' => $data['branchname'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'phone' => $data['phone'],
            'status' => $data['status'],
            'branchimage' => $branchimage,
        ]);

        return redirect()->route('branch.index')->with('success', 'Branch Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {
            $branch = Branch::findorfail($id);
            Storage::disk('uploads')->delete($branch->branchimage);
            $branch->delete();
            return redirect()->back()->with('success', 'Branch Deleted Successfully.');
        }else{
            return view('backend.permission.permission');
        }
    }
}

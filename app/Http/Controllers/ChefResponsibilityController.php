<?php

namespace App\Http\Controllers;

use App\Models\BranchMenu;
use App\Models\Chef;
use App\Models\ChefResponsibility;
use App\Models\MenuitemImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ChefResponsibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {
            $chef = Chef::findorfail($id);
            if ($request->ajax()) {
                $data = ChefResponsibility::where('chef_id', $chef->id)->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('itemname', function ($row){
                            return $row->branchmenu->menuitem->title;
                        })
                        ->addColumn('photo', function ($row) {
                            $item = $row->branchmenu->menuitem;
                            $itemimage = MenuitemImage::where('menuitem_id', $item->id)->first();
                            $photo = Storage::disk('uploads')->url($itemimage->filename);
                            $img = "<img src = '$photo' style='max-height:100px'>";
                            return $img;
                        })
                        ->addColumn('action', function($row){
                                $deleteurl = route('chefresponsibility.destroy', $row->id);
                                $csrf_token = csrf_token();
                            $btn = "
                            <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            ";

                                return $btn;
                        })
                        ->rawColumns(['itemname', 'photo', 'action'])
                        ->make(true);
            }
            return view('backend.chef.responsibility', compact('chef'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {
            $chef = Chef::findorfail($id);
            $branchmenuitems = BranchMenu::where('branch_id', $chef->branch_id)->get();
            return view('backend.chef.responsibilitycreate', compact('branchmenuitems', 'chef'));
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
            'chef_id' => 'required',
            'branchmenu_id' => 'required',
        ]);
        $chef = Chef::findorfail($data['chef_id']);

        foreach($data['branchmenu_id'] as $item)
        {
            $existingitem = ChefResponsibility::where('branch_id', $chef->branch_id)->where('branchmenu_id', $item)->first();
            if($existingitem)
            {
                return redirect()->back()->with('failure', 'Responsibilty for some selected items already assigned. Please check.');
            }
            else
            {
                $responsibility = ChefResponsibility::create([
                    'chef_id' => $data['chef_id'],
                    'branchmenu_id' => $item,
                    'branch_id' => $chef->branch_id
                ]);
                $responsibility->save();
            }
        }

            return redirect()->route('chefresponsibility.index', $data['chef_id'])->with('success', 'Responsibility Updated Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChefResponsibility  $chefResponsibility
     * @return \Illuminate\Http\Response
     */
    public function show(ChefResponsibility $chefResponsibility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChefResponsibility  $chefResponsibility
     * @return \Illuminate\Http\Response
     */
    public function edit(ChefResponsibility $chefResponsibility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChefResponsibility  $chefResponsibility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChefResponsibility $chefResponsibility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChefResponsibility  $chefResponsibility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {

            $responsibility = ChefResponsibility::findorfail($id);
            $responsibility->delete();

            return redirect()->back()->with('success', 'Responsibility Deleted Successfully.');

        }else{
            return view('backend.permission.permission');
        }
    }
}

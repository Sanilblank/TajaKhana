<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\Category;
use App\Models\Menuitem;
use App\Models\MenuitemImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class BranchMenuController extends Controller
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
            $branch = Branch::findorfail($id);
            if ($request->ajax()) {
                $data = BranchMenu::where('branch_id', $branch->id)->with('branch')->with('menuitem')->get();
                return DataTables::of($data)
                        ->addIndexColumn()

                        ->addColumn('photo', function($row){
                            $itemimage = MenuitemImage::where('menuitem_id', $row->menuitem_id)->first();
                            $photo = Storage::disk('uploads')->url($itemimage->filename);
                            $img = "<img src = '$photo' style='max-height:100px'>";
                            return $img;
                        })

                        ->addColumn('menuitem_id', function($row){
                            $iteminfo = $row->menuitem->title . '<br>' . '(' . $row->menuitem->quantity . ' ' . $row->menuitem->unit . ')';
                            return $iteminfo;
                        })

                        ->addColumn('category_id', function ($row) {
                            $categories = $row->menuitem->category_id;
                            $category = '';
                            foreach ($categories as $cat) {
                                $categoryname = Category::where('id', $cat)->first();
                                $category .= '<span class="badge bg-green" style="background-color: green";>' . $categoryname->title . '</span>' . ' ';
                            }
                            return $category;
                        })

                        ->addColumn('price', function ($row) {
                            $price = 'Rs. ' . $row->menuitem->price;
                            return $price;
                        })

                        ->addColumn('costprice', function ($row) {
                            $costprice = 'Rs. ' . $row->menuitem->costprice;
                            return $costprice;
                        })

                        ->addColumn('discount', function ($row) {
                            $discount = $row->menuitem->discount . ' %';
                            return $discount;
                        })

                        ->addColumn('action', function($row){
                                $deleteurl = route('branchmenu.destroy', $row->id);
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
                        ->rawColumns(['photo', 'menuitem_id', 'category_id', 'price', 'costprice', 'discount', 'action'])
                        ->make(true);
            }
            return view('backend.branchmenu.index', compact('branch'));
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
            $branch = Branch::findorfail($id);
            $menuitems = Menuitem::where('status', 1)->get();
            return view('backend.branchmenu.create', compact('branch', 'menuitems'));
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
            'branch_id' => 'required',
            'menuitem_id' => 'required',
        ]);

        foreach($data['menuitem_id'] as $item)
        {
            $existingitem = BranchMenu::where('branch_id', $data['branch_id'])->where('menuitem_id', $item)->first();
            if(!$existingitem)
            {
                $branchmenu = BranchMenu::create([
                    'branch_id' => $data['branch_id'],
                    'menuitem_id' => $item,
                ]);
                $branchmenu->save();
            }
        }

            return redirect()->route('branchmenu.index', $data['branch_id'])->with('success', 'Menu Updated Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchMenu  $branchMenu
     * @return \Illuminate\Http\Response
     */
    public function show(BranchMenu $branchMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchMenu  $branchMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchMenu $branchMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchMenu  $branchMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchMenu $branchMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchMenu  $branchMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-branch')) {

            $branchmenuitem = BranchMenu::findorfail($id);
            $branchmenuitem->delete();

            return redirect()->back()->with('success', 'Menu Item Deleted Successfully.');

        }else{
            return view('backend.permission.permission');
        }
    }
}

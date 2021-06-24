<?php

namespace App\Http\Controllers;

use App\Models\CookbookCategory;
use App\Models\CookbookItem;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class CookbookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->user()->can('manage-cookbook')){
            if ($request->ajax()) {
                $data = CookbookCategory::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        $editurl = route('cookbookcategory.edit', $row->id);
                        $deleteurl = route('cookbookcategory.destroy', $row->id);
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
            return view('backend.cookbookcategory.index');

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
        if($request->user()->can('manage-cookbook')){
            return view('backend.cookbookcategory.create');

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
            'name'=>'required|string',
        ]);

        $existingcategory = CookbookCategory::where('name', $data['name'])->first();
        if($existingcategory)
        {
            return redirect()->back()->with('failure', 'Category already exists');
        }

        $cookbookCategory = CookbookCategory::create([
            'name'=>$data['name'],
            'slug'=>Str::slug($data['name']),
        ]);
        $cookbookCategory->save();
        return redirect()->route('cookbookcategory.index')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CookbookCategory  $cookbookCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CookbookCategory $cookbookCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CookbookCategory  $cookbookCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if($request->user()->can('manage-blog')){
            $cookbookCategory = CookbookCategory::findorfail($id);
            return view('backend.cookbookcategory.edit', compact('cookbookCategory'));

        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CookbookCategory  $cookbookCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cookbookCategory = CookbookCategory::findorfail($id);
        $data = $this->validate($request, [
            'name'=>'required|string',
        ]);
        $existingcategory = CookbookCategory::where('name', $data['name'])->first();
        if($existingcategory)
        {
            return redirect()->back()->with('failure', 'Category already exists');
        }

        $cookbookCategory->update([
            'name'=>$data['name'],
            'slug'=>Str::slug($data['name']),
        ]);

        return redirect()->route('cookbookcategory.index')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CookbookCategory  $cookbookCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $cookbookCategory = CookbookCategory::findorfail($id);

        $items = CookbookItem::all();
        foreach ($items as $item) {
            if(in_array($cookbookCategory->id, $item->category))
            {
                return redirect()->back()->with('failure', 'Category is being used in cookbook item');
            }
        }
        $cookbookCategory->delete();

        return redirect()->route('cookbookcategory.index')->with('success', 'Category Successfully Deleted');
    }
}

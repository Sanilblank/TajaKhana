<?php

namespace App\Http\Controllers;

use App\Models\CookbookCategory;
use App\Models\CookbookItem;
use App\Models\Levelofcooking;
use App\Models\Recipetype;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CookbookItemController extends Controller
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
                $data = CookbookItem::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category', function ($row) {
                        $categories = $row->category;
                        $category = '';
                        foreach ($categories as $cat) {
                            $categoryname = CookbookCategory::where('id', $cat)->first();
                            $category .= '<span class="badge bg-green" style="background-color: green";>' . $categoryname->name . '</span>' . ' ';
                        }
                        return $category;
                    })
                    ->addColumn('itemimage', function ($row) {
                        $imageurl = Storage::disk('uploads')->url($row->itemimage);

                        $image = "<img src='$imageurl'style = 'max-height:100px'>";
                        return $image;
                    })
                    // ->addColumn('recipebyimage', function ($row) {
                    //     $imageurl = Storage::disk('uploads')->url($row->recipebyimage);

                    //     $image = "<img src='$imageurl'style = 'max-height:100px'>";
                    //     return $image;
                    // })
                    ->addColumn('action', function($row){
                        $editurl = route('cookbookitem.edit', $row->id);
                        $deleteurl = route('cookbookitem.destroy', $row->id);
                        $showurl = route('cookbookitem.show', $row->id);
                        $csrf_token = csrf_token();
                        $btn = "<a href='$showurl' class='edit btn btn-warning btn-sm'>Show</a>
                                <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                               <form action='$deleteurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='DELETE' />
                                   <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                               </form>
                               ";

                                return $btn;
                    })
                    ->rawColumns(['category', 'itemimage', 'action'])
                    ->make(true);
            }

            return view('backend.cookbookitem.index');
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
            $cookbookcategories = CookbookCategory::latest()->get();
            $levels = Levelofcooking::all();
            $recipetypes = Recipetype::all();

            return view('backend.cookbookitem.create', compact('cookbookcategories', 'levels', 'recipetypes'));

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
            'category'=>'required',
            'itemname'=>'required',
            'itemimage'=>'required|mimes:png,jpg,jpeg',
            'recipeby'=>'required',
            'recipebyimage'=>'required|mimes:png,jpg,jpeg',
            'serving'=>'required',
            'timetoprepare'=>'required',
            'timetocook'=>'required',
            'description'=>'required',
            'course'=>'required',
            'cuisine'=>'required',
            'timeofday'=>'required',
            'levelofcooking_id'=>'required',
            'recipetype_id'=>'required',
            'steps'=>'required',
            'ingredients'=>'required',
        ]);

            $imagename = '';
            if($request->hasfile('itemimage')){
                $image = $request->file('itemimage');
                $imagename = $image->store('cookbookitem_image', 'uploads');
            }

            $authorimage = '';
            if($request->hasfile('recipebyimage')){
                $image = $request->file('recipebyimage');
                $authorimage = $image->store('cookbookrecipeby_image', 'uploads');
            }

            $item = CookbookItem::create([
                'itemname'=>$data['itemname'],
                'category'=>$data['category'],
                'slug'=>Str::slug($data['itemname']),
                'itemimage'=>$imagename,
                'recipeby'=>$data['recipeby'],
                'recipebyimage'=>$authorimage,
                'serving'=>$data['serving'],
                'timetoprepare'=>$data['timetoprepare'],
                'timetocook'=>$data['timetocook'],
                'description'=>$data['description'],
                'course'=>$data['course'],
                'cuisine'=>$data['cuisine'],
                'timeofday'=>$data['timeofday'],
                'levelofcooking_id'=>$data['levelofcooking_id'],
                'recipetype_id'=>$data['recipetype_id'],
                'ingredients'=>$data['ingredients'],
                'steps'=>$data['steps'],
            ]);
            $item->save();

            return redirect()->route('cookbookitem.index')->with('success', 'Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CookbookItem  $cookbookItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        if($request->user()->can('manage-cookbook')){
            $cookbookitem = CookbookItem::findorfail($id);
            $categories = $cookbookitem->category;
            $category = '';
            foreach ($categories as $cat) {
                $categoryname = CookbookCategory::where('id', $cat)->first();
                $category .=  $categoryname->name. ', ';
            }

            return view('backend.cookbookitem.show', compact('cookbookitem', 'category'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CookbookItem  $cookbookItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if($request->user()->can('manage-cookbook')){
            $cookbookitem = CookbookItem::findorfail($id);
            $cookbookcategories = CookbookCategory::latest()->get();
            $levels = Levelofcooking::all();
            $recipetypes = Recipetype::all();

            return view('backend.cookbookitem.edit', compact('cookbookitem', 'cookbookcategories', 'levels', 'recipetypes'));

        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CookbookItem  $cookbookItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cookbookitem = CookbookItem::findorfail($id);
        $data = $this->validate($request, [
            'itemname'=>'required',
            'category'=>'required',
            'itemimage'=>'mimes:png,jpg,jpeg',
            'recipeby'=>'required',
            'recipebyimage'=>'mimes:png,jpg,jpeg',
            'serving'=>'required',
            'timetoprepare'=>'required',
            'timetocook'=>'required',
            'description'=>'required',
            'course'=>'required',
            'cuisine'=>'required',
            'timeofday'=>'required',
            'levelofcooking_id'=>'required',
            'recipetype_id'=>'required',
            'steps'=>'required',
            'ingredients'=>'required',
        ]);

        $imagename = '';
        if($request->hasfile('itemimage')){
            $image = $request->file('itemimage');
            Storage::disk('uploads')->delete($cookbookitem->itemimage);
            $imagename = $image->store('cookbookitem_image', 'uploads');
        } else{
            $imagename = $cookbookitem->itemimage;
        }

        $authorimage = '';
        if($request->hasfile('recipebyimage')){
            $image = $request->file('recipebyimage');
            Storage::disk('uploads')->delete($cookbookitem->recipebyimage);
            $authorimage = $image->store('cookbookrecipeby_image', 'uploads');
        } else{
            $authorimage = $cookbookitem->recipebyimage;
        }

        $cookbookitem->update([
            'itemname'=>$data['itemname'],
            'category'=>$data['category'],
            'slug'=>Str::slug($data['itemname']),
            'itemimage'=>$imagename,
            'recipeby'=>$data['recipeby'],
            'recipebyimage'=>$authorimage,
            'serving'=>$data['serving'],
            'timetoprepare'=>$data['timetoprepare'],
            'timetocook'=>$data['timetocook'],
            'description'=>$data['description'],
            'course'=>$data['course'],
            'cuisine'=>$data['cuisine'],
            'timeofday'=>$data['timeofday'],
            'levelofcooking_id'=>$data['levelofcooking_id'],
            'recipetype_id'=>$data['recipetype_id'],
            'ingredients'=>$data['ingredients'],
            'steps'=>$data['steps'],
        ]);
        return redirect()->route('cookbookitem.index')->with('success', 'Updated Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CookbookItem  $cookbookItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if($request->user()->can('manage-cookbook')){
            $cookbookitem = CookbookItem::findorfail($id);
            Storage::disk('uploads')->delete($cookbookitem->itemimage);
            Storage::disk('uploads')->delete($cookbookitem->recipebyimage);

            $cookbookitem->delete();
            return redirect()->back()->with('success', 'Deleted Successfully');

        }else{
            return view('backend.permission.permission');
        }
    }
}

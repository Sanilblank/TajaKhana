<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ComboItem;
use App\Models\Menuitem;
use App\Models\MenuitemImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            if ($request->ajax()) {
                $data = Menuitem::latest()->where('is_combo', null)->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('photo', function($row){
                            $itemimage = MenuitemImage::where('menuitem_id', $row->id)->first();
                            $photo = Storage::disk('uploads')->url($itemimage->filename);
                            $img = "<img src = '$photo' style='max-height:100px'>";
                            return $img;
                        })

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

                        ->addColumn('featured', function ($row) {
                            if($row->featured == 1)
                            {
                                $featured = '<span class="badge bg-green" style="background-color: green";>Featured</span>';
                            }
                            else
                            {
                                $featured = '<span class="badge bg-danger" style="color: white";>Not Featured</span>';
                            }
                            return $featured;
                        })

                        ->addColumn('price', function ($row) {
                            $price = 'Rs. ' . $row->price;
                            return $price;
                        })

                        ->addColumn('costprice', function ($row) {
                            $costprice = 'Rs. ' . $row->costprice;
                            return $costprice;
                        })

                        ->addColumn('discount', function ($row) {
                            $discount = $row->discount . ' %';
                            return $discount;
                        })

                        ->addColumn('title', function ($row) {
                            $title = $row->title;
                            $info = $title . '<br>' . '(' . $row->quantity . ' ' . $row->unit . ')';

                            return $info;
                        })

                        ->addColumn('category_id', function ($row) {
                            $categories = $row->category_id;
                            $category = '';
                            foreach ($categories as $cat) {
                                $categoryname = Category::where('id', $cat)->first();
                                $category .= '<span class="badge bg-green" style="background-color: green";>' . $categoryname->title . '</span>' . ' ';
                            }
                            return $category;
                        })

                        ->addColumn('action', function($row){
                                $editurl = route('menuitem.edit', $row->id);
                                $deleteurl = route('menuitem.destroy', $row->id);
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
                        ->rawColumns(['photo', 'status', 'featured', 'price', 'costprice', 'discount', 'title', 'category_id', 'action'])
                        ->make(true);
            }
            return view('backend.menuitem.index');
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
        if ($request->user()->can('manage-menuitem')) {
            $categories = Category::where('status', 1)->get();
            return view('backend.menuitem.create', compact('categories'));
        }else{
            return view('backend.permission.permission');
        }
    }

    public function combomenucreate(Request $request)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            $categories = Category::where('status', 1)->get();
            $menuitems = Menuitem::where('status', 1)->where('is_combo', null)->get();
            return view('backend.combomenu.create', compact('categories', 'menuitems'));
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
            'title' => 'required',
            'category' => 'required',
            'costprice' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'photos' =>'required',
            'photos.*' => 'mimes:jpg,jpeg,png',
            'details' => 'required',
            'status' => 'required',
            'featured' => 'required',
        ]);

        $menuitem = Menuitem::create([
            'category_id'=>$data['category'],
            'title'=>$data['title'],
            'slug'=>Str::slug($data['title']),
            'price'=>$data['price'],
            'discount'=>$data['discount'],
            'quantity'=>$data['quantity'],
            'unit'=>$data['unit'],
            'details'=>$data['details'],
            'status'=>$data['status'],
            'featured'=>$data['featured'],
            'costprice'=>$data['costprice'],
        ]);

            $imagename = '';
            if($request->hasfile('photos')){
                $images = $request->file('photos');
                foreach($images as $image){
                    $imagename = $image->store('menuitem_images', 'uploads');

                    $menuitemimage = MenuitemImage::create([
                        'menuitem_id' => $menuitem['id'],
                        'filename' => $imagename,
                    ]);
                    $menuitemimage->save();
                }
            }

            $menuitem->save();
            if($data['status'] == 1)
            {
                FrontController::sendsubscribermail($menuitem->id);
            }
            return redirect()->route('menuitem.index')->with('success', 'Menu Item successfully Created.');

    }

    public function combomenustore(Request $request)
    {
        //
        $data = $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'costprice' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'photos' =>'required',
            'photos.*' => 'mimes:jpg,jpeg,png',
            'details' => 'required',
            'status' => 'required',
            'featured' => 'required',
            'menuitem_id' => 'required',
        ]);

        $menuitem = Menuitem::create([
            'category_id'=>$data['category'],
            'title'=>$data['title'],
            'slug'=>Str::slug($data['title']),
            'price'=>$data['price'],
            'discount'=>$data['discount'],
            'quantity'=>$data['quantity'],
            'unit'=>$data['unit'],
            'details'=>$data['details'],
            'status'=>$data['status'],
            'featured'=>$data['featured'],
            'costprice'=>$data['costprice'],
            'is_combo'=>1,
        ]);

            $imagename = '';
            if($request->hasfile('photos')){
                $images = $request->file('photos');
                foreach($images as $image){
                    $imagename = $image->store('menuitem_images', 'uploads');

                    $menuitemimage = MenuitemImage::create([
                        'menuitem_id' => $menuitem['id'],
                        'filename' => $imagename,
                    ]);
                    $menuitemimage->save();
                }
            }

            $menuitem->save();
            foreach($data['menuitem_id'] as $item_id)
            {
                $comboitem = ComboItem::create([
                    'combo_id' => $menuitem->id,
                    'menuitem_id' => $item_id,
                ]);

                $comboitem->save();
            }

            return redirect()->route('combomenu.index')->with('success', 'Combo Menu successfully Created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menuitem  $menuitem
     * @return \Illuminate\Http\Response
     */
    public function show(Menuitem $menuitem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menuitem  $menuitem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            $categories = Category::where('status', 1)->get();
            $menuitem = Menuitem::findorfail($id);
            return view('backend.menuitem.edit', compact('categories', 'menuitem'));
        }else{
            return view('backend.permission.permission');
        }
    }

    public function combomenuedit(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            $categories = Category::where('status', 1)->get();
            $menuitem = Menuitem::findorfail($id);
            $combomenuitems = ComboItem::where('combo_id', $menuitem->id)->get();
            $menuitems = Menuitem::where('status', 1)->where('is_combo', null)->get();
            return view('backend.combomenu.edit', compact('categories', 'menuitem', 'combomenuitems', 'menuitems'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menuitem  $menuitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $menuitem = Menuitem::findorfail($id);
        $data = $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'costprice' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'photos' =>'',
            'photos.*' => 'mimes:jpg,jpeg,png',
            'details' => 'required',
            'status' => 'required',
            'featured' => 'required',
        ]);

        $menuitem->update([
            'category_id'=>$data['category'],
            'title'=>$data['title'],
            'slug'=>Str::slug($data['title']),
            'price'=>$data['price'],
            'discount'=>$data['discount'],
            'quantity'=>$data['quantity'],
            'unit'=>$data['unit'],
            'details'=>$data['details'],
            'status'=>$data['status'],
            'featured'=>$data['featured'],
            'costprice'=>$data['costprice'],
        ]);

            $imagename = '';
            if($request->hasfile('photos')){
                $existingimages = MenuitemImage::where('menuitem_id', $menuitem->id)->get();
                foreach($existingimages as $exist)
                {
                    Storage::disk('uploads')->delete($exist->filename);
                    $exist->delete();
                }

                $images = $request->file('photos');
                foreach($images as $image){
                    $imagename = $image->store('menuitem_images', 'uploads');

                    $menuitemimage = MenuitemImage::create([
                        'menuitem_id' => $menuitem['id'],
                        'filename' => $imagename,
                    ]);
                    $menuitemimage->save();
                }
            }
            return redirect()->route('menuitem.index')->with('success', 'Menu Item successfully Updated.');

    }

    public function combomenuupdate(Request $request, $id)
    {
        //
        $menuitem = Menuitem::findorfail($id);
        $data = $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'costprice' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'photos' =>'',
            'photos.*' => 'mimes:jpg,jpeg,png',
            'details' => 'required',
            'status' => 'required',
            'featured' => 'required',
            'menuitem_id' => 'required',
        ]);

        $menuitem->update([
            'category_id'=>$data['category'],
            'title'=>$data['title'],
            'slug'=>Str::slug($data['title']),
            'price'=>$data['price'],
            'discount'=>$data['discount'],
            'quantity'=>$data['quantity'],
            'unit'=>$data['unit'],
            'details'=>$data['details'],
            'status'=>$data['status'],
            'featured'=>$data['featured'],
            'costprice'=>$data['costprice'],
        ]);

            $imagename = '';
            if($request->hasfile('photos')){
                $existingimages = MenuitemImage::where('menuitem_id', $menuitem->id)->get();
                foreach($existingimages as $exist)
                {
                    Storage::disk('uploads')->delete($exist->filename);
                    $exist->delete();
                }

                $images = $request->file('photos');
                foreach($images as $image){
                    $imagename = $image->store('menuitem_images', 'uploads');

                    $menuitemimage = MenuitemImage::create([
                        'menuitem_id' => $menuitem['id'],
                        'filename' => $imagename,
                    ]);
                    $menuitemimage->save();
                }
            }

            $comboitems = ComboItem::where('combo_id', $menuitem->id)->get();
            foreach($comboitems as $item)
            {
                $item->delete();
            }

            foreach($data['menuitem_id'] as $item_id)
            {
                $comboitem = ComboItem::create([
                    'combo_id' => $menuitem->id,
                    'menuitem_id' => $item_id,
                ]);

                $comboitem->save();
            }
            return redirect()->route('combomenu.index')->with('success', 'Combo Menu successfully Updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menuitem  $menuitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            $menuitem = Menuitem::findorfail($id);
            $comboitem = ComboItem::where('combo_id', $menuitem->id)->first();
            if($comboitem)
            {
                return redirect()->back()->with('failure', 'Menu Item present in combo menu. Cannot Delete');
            }
            $images = MenuitemImage::where('menuitem_id', $menuitem->id)->get();
            foreach($images as $image)
            {
                Storage::disk('uploads')->delete($image->filename);
                $image->delete();
            }
            $menuitem->delete();
            return redirect()->back()->with('success', 'Menu Item successfully Deleted.');
        }else{
            return view('backend.permission.permission');
        }
    }

    public function combomenudestroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            $menuitem = Menuitem::findorfail($id);
            $images = MenuitemImage::where('menuitem_id', $menuitem->id)->get();
            foreach($images as $image)
            {
                Storage::disk('uploads')->delete($image->filename);
                $image->delete();
            }
            $comboitems = ComboItem::where('combo_id', $menuitem->id)->get();
            foreach($comboitems as $item)
            {
                $item->delete();
            }
            $menuitem->delete();
            return redirect()->back()->with('success', 'Combo Menu successfully Deleted.');
        }else{
            return view('backend.permission.permission');
        }
    }

    public function combomenu(Request $request)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            if ($request->ajax()) {
                $data = Menuitem::latest()->where('is_combo', 1)->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('photo', function($row){
                            $itemimage = MenuitemImage::where('menuitem_id', $row->id)->first();
                            $photo = Storage::disk('uploads')->url($itemimage->filename);
                            $img = "<img src = '$photo' style='max-height:100px'>";
                            return $img;
                        })

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

                        ->addColumn('featured', function ($row) {
                            if($row->featured == 1)
                            {
                                $featured = '<span class="badge bg-green" style="background-color: green";>Featured</span>';
                            }
                            else
                            {
                                $featured = '<span class="badge bg-danger" style="color: white";>Not Featured</span>';
                            }
                            return $featured;
                        })

                        ->addColumn('price', function ($row) {
                            $price = 'Rs. ' . $row->price;
                            return $price;
                        })

                        ->addColumn('costprice', function ($row) {
                            $costprice = 'Rs. ' . $row->costprice;
                            return $costprice;
                        })

                        ->addColumn('discount', function ($row) {
                            $discount = $row->discount . ' %';
                            return $discount;
                        })

                        ->addColumn('title', function ($row) {
                            $title = $row->title;
                            $info = $title . '<br>' . '(' . $row->quantity . ' ' . $row->unit . ')';

                            return $info;
                        })

                        ->addColumn('category_id', function ($row) {
                            $categories = $row->category_id;
                            $category = '';
                            foreach ($categories as $cat) {
                                $categoryname = Category::where('id', $cat)->first();
                                $category .= '<span class="badge bg-green" style="background-color: green";>' . $categoryname->title . '</span>' . ' ';
                            }
                            return $category;
                        })

                        ->addColumn('action', function($row){
                                $editurl = route('combomenu.edit', $row->id);
                                $deleteurl = route('combomenu.destroy', $row->id);
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
                        ->rawColumns(['photo', 'status', 'featured', 'price', 'costprice', 'discount', 'title', 'category_id', 'action'])
                        ->make(true);
            }
            return view('backend.combomenu.index');
        }else{
            return view('backend.permission.permission');
        }
    }
}

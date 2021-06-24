<?php

namespace App\Http\Controllers;

use App\Models\CombomenuRequest;
use App\Models\MenuitemImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CombomenuRequestController extends Controller
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

            $newcombomenurequest = DB::table('notifications')->where('type','App\Notifications\ComboRequestNotification')->where('is_read', 0)->get();
            foreach ($newcombomenurequest as $newreq) {
                DB::update('update notifications set is_read = 1 where id = ?', [$newreq->id]);
            }


            if ($request->ajax()) {
                $data = CombomenuRequest::latest()->get();
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


                        ->addColumn('action', function($row){

                                $deleteurl = route('combomenuRequest.destroy', $row->id);
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
                        ->rawColumns(['photo', 'menuitem_id', 'action'])
                        ->make(true);
            }
            return view('backend.combomenu.combomenurequest');
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CombomenuRequest  $combomenuRequest
     * @return \Illuminate\Http\Response
     */
    public function show(CombomenuRequest $combomenuRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CombomenuRequest  $combomenuRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(CombomenuRequest $combomenuRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CombomenuRequest  $combomenuRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CombomenuRequest $combomenuRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CombomenuRequest  $combomenuRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('manage-menuitem')) {
            $comboreq = CombomenuRequest::findorfail($id);
            $comboreq->delete();
            return redirect()->back()->with('success', 'Request successfully Deleted.');
        }else{
            return view('backend.permission.permission');
        }
    }
}

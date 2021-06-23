<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use App\Models\Review;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->user()->can('manage-review')){
            if ($request->ajax()) {
                $data = Review::latest()->with('user')->with('chef')->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('image', function($row){
                            $chef= Chef::where('id', $row->chef_id)->first();
                            $imageurl = Storage::disk('uploads')->url($chef->photo);
                            $image = "<img src='$imageurl'style = 'max-height:100px'>";
                            return $image;
                        })
                        ->addColumn('name', function($row){
                           return $row->chef->name;
                        })
                        ->addColumn('branch', function($row){
                            return $row->chef->branch->branchlocation;
                         })



                        ->addColumn('action', function($row){

                                $enableurl = route('review.enable', $row->id);
                                $disableurl = route('review.disable', $row->id);
                                $csrf_token = csrf_token();

                                if($row->disable == 1)
                                {
                                    $btn = "
                                        <form action='$enableurl' method='POST' style='display:inline;'>
                                        <input type='hidden' name='_token' value='$csrf_token'>
                                        <input type='hidden' name='_method' value='PUT' />
                                            <button type='submit' class='btn btn-success btn-sm'>Enable</button>
                                        </form>
                                    ";
                                }
                                else
                                {
                                    $btn = "
                                        <form action='$disableurl' method='POST' style='display:inline;'>
                                        <input type='hidden' name='_token' value='$csrf_token'>
                                        <input type='hidden' name='_method' value='PUT' />
                                            <button type='submit' class='btn btn-danger btn-sm'>Disable</button>
                                        </form>
                                    ";
                                }


                            return $btn;
                        })
                        ->rawColumns(['name', 'branch', 'image', 'action'])
                        ->make(true);
            }
            return view('backend.review.index');
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
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }

    public function enableurl(Request $request, $id)
    {
        if($request->user()->can('manage-review')){
            $review = Review::findorfail($id);
            $review->update([
                'disable'=>null,
            ]);
            return redirect()->back()->with('success', 'Review Enabled');

        }else{
            return view('backend.permission.permission');
        }
    }

    public function disableurl(Request $request, $id)
    {
        if($request->user()->can('manage-review')){
            $review = Review::findorfail($id);
            $review->update([
                'disable'=>1,
            ]);
            return redirect()->back()->with('success', 'Review Disabled');

        }else{
            return view('backend.permission.permission');
        }

    }
}

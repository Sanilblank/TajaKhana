<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use DataTables;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->user()->can('manage-faq')){
            if ($request->ajax()) {
                $data = Faq::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()



                    ->addColumn('action', function($row){

                        $editurl = route('faq.edit', $row->id);
                        $deleteurl = route('faq.destroy', $row->id);
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
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('backend.faqs.index');
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
        if($request->user()->can('manage-faq')){
            return view('backend.faqs.create');
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
            'question'=>'required|string|max:255',
            'answer'=>'required|string',
        ]);

        $faq = Faq::create([
            'question'=>$data['question'],
            'answer'=>$data['answer'],
        ]);
        $faq->save();
        return redirect()->route('faq.index')->with('success', 'FAQ Successfully Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if($request->user()->can('manage-faq')){
            $faq = Faq::findorfail($id);
            return view('backend.faqs.edit', compact('faq'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $faq = Faq::findorfail($id);
        $data = $this->validate($request, [
            'question'=>'required|string|max:255',
            'answer'=>'required|string',
        ]);

        $faq->update([
            'question'=>$data['question'],
            'answer'=>$data['answer'],
        ]);
        return redirect()->route('faq.index')->with('success', 'FAQ Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if($request->user()->can('manage-faq')){
            $faq = Faq::findorfail($id);
            $faq->delete();
            return redirect()->route('faq.index')->with('success', 'FAQ Successfully Deleted.');

        }else{
            return view('backend.permission.permission');
        }
    }
}

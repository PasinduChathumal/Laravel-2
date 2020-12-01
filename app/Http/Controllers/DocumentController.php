<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= Document::all();
        return Inertia::render('Documents/list', ['data' => $data]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Documents/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validateWithBag('storeDocumentInformation', [
            'title' => ['required'],
            'description' => ['required'],
            'file' => ['nullable'],
        ]);
  
        Document::create($request->all());

        $data= Document::all();
        //return Inertia::render('Documents/list', ['data' => $data,'toast'=> ['message' => 'Post Created Successfully.']]);
        return Redirect::route('documents.index', ['data' => $data])->with('toast', ['message'=> 'Post Created Successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Document::find($id);
        return view('paperclass',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Document::find($id); 
        return Inertia::render('Documents/edit',['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validateWithBag('updateDocumentInformation', [
            'title' => ['required'],
            'description' => ['required'],
            'file' => ['nullable', 'image', 'max:1024'],
        ]);
  
        $document = Document::find($id);
        $document->fill($request->all())->save();

        $data= Document::all();
        return Redirect::route('documents.index', ['data' => $data])->with('toast', ['message'=> 'Post Created Successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Document::find($id)->delete();
        return redirect()->back()->with('toast', ['message' => 'Post Updated Successfully.']);
    }
}

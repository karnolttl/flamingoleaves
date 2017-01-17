<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Tag;
use Session;

class TagController extends Controller
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
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data (server-side)
        $this->validate($request, array(
            'name' => ['required', 'max:255', 'unique:tags'],
        ));

        // store in the database
        $tag = new Tag;
        $tag->name = $request->input('name');
        $tag->save();

        Session::flash('success', 'New tag has been created.');

        // redirect to another page
        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('tags.edit', compact('tag'));
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
        $this->validate($request, [
            'name' => ['required', 'max:255', Rule::unique('tags')->ignore($id)]]);

        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->save();

        Session::flash('success', 'This tag was successfully saved.');

        return view('tags.show', compact('tag'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $tag = Tag::find($id);

        if ($tag->posts->count() != 0) {
            Session::flash('warning', 'This tag cannot be deleted because it is used at least once.');
            return view('tags.show', compact('tag'));
        }

        $tag->posts()->detach();
        $tag->delete();

        Session::flash('success', 'The tag was succesfully deleted.');
        return redirect()->route('tags.index');
    }
}

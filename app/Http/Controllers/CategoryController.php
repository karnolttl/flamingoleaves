<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Category;
use Session;

class CategoryController extends Controller
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
        $categories = Category::all();
        return view('categories.index', compact('categories'));
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
            'name' => ['required', 'max:255', 'unique:categories'],
        ));

        // store in the database
        $category = new Category;
        $category->name = $request->input('name');
        $category->save();

        Session::flash('success', 'A new category has been created.');

        // redirect to another page
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
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
            'name' => ['required', 'max:255', Rule::unique('categories')->ignore($id)]]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        Session::flash('success', 'This category was successfully saved.');

        return view('categories.show', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category->posts->count() != 0) {
            Session::flash('warning', 'This category cannot be deleted because it is used at least once.');
            return view('categories.show', compact('category'));
        }

        $category->delete();

        Session::flash('success', 'The category was succesfully deleted.');
        return redirect()->route('categories.index');
    }
}

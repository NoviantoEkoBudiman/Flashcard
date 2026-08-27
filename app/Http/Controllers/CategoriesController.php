<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request,[
            'categories_languages_id' => [
                'required',
                Rule::exists('languages', 'languages_id')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'categories_name'           =>  'required',
            'categories_type'           =>  'required|integer|in:1,2'
        ],
        [
            'categories_languages_id.required'   =>  'Language id can\'t be null',
            'categories_name.required'           =>  'Category\'s name  can\'t be null',
            'categories_type.required'           =>  'Category\'s type  can\'t be null'
        ]);

        $category = new Category;
        $category->categories_languages_id = $validated['categories_languages_id'];
        $category->categories_name = $validated['categories_name'];
        $category->categories_type = $validated['categories_type'];
        $category->save();

        return redirect()
                ->route('category.show', $validated['categories_languages_id'])
                ->with('success', 'Kategori '.$category->categories_name.' berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $language = Language::where('user_id', auth()->id())->findOrFail($id);
        $categories = $language->categories()->orderBy('categories_name', 'asc')->get();
        return view('category.detail',compact('language','categories'));
    }
}

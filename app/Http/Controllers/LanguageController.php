<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    
    public function language()
    {
        $languages = auth()->user()
            ->languages()
            ->orderBy('languages_name', 'asc')
            ->get();
        return view('options', compact('languages'));
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
        $request->merge([
            'languages_name' => trim((string) $request->languages_name),
        ]);

        $validated = $this->validate($request,[
            'languages_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('languages', 'languages_name')
                    ->where(function ($query) {
                        return $query->where('user_id', auth()->id());
                    }),
            ],
        ],
        [
            'languages_name.required' => 'Language can\'t be null',
            'languages_name.unique' => 'You already have a language with this exact name.',
        ]);

        $language = auth()->user()->languages()->create($validated);

        return redirect()
                ->route('language_index')
                ->with('success', 'Data bahasa '.$language->languages_name.' berhasil ditambahkan');
    }
}

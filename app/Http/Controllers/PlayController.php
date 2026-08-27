<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Category;
use App\Models\Card;
use Illuminate\Support\Facades\DB;

class PlayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = auth()->user()
            ->languages()
            ->orderBy('languages_name', 'asc')
            ->get();
        return view('play.index',compact('languages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $playMode = $this->getPlayMode($request);
        $category = $this->ownedCategory($id);
        session(['language_id' => $category->categories_languages_id]);
        if($category->categories_type == 1){
            $card = Card::where('cards_categories_id', $id)->where('card_status','!=','1')->inRandomOrder()->first();
            $left = count(Card::where('cards_categories_id', $id)->where('card_status','!=','1')->get());
        }else{
            $card = Card::where('cards_categories_id', $id)->orderBy('cards_id', 'asc')->first();
            $left = count(Card::where('cards_categories_id', $id)->get());
        }
        return view('play.play',compact('card','left', 'playMode'));
    }

    function next(Request $request, $category_id, $card_id)
    {
        $playMode = $this->getPlayMode($request);
        $category = $this->ownedCategory($category_id);
        $card = $category->cards()->findOrFail($card_id);
        $card->card_status = 1;
        $card->save();
        if($category->categories_type == 1){
            $card = Card::where('cards_categories_id', $category_id)->where('card_status','!=','1')->inRandomOrder()->first();
            $left = count(Card::where('cards_categories_id', $category_id)->where('card_status','!=','1')->get());
        }else{
            $card = Card::where('cards_categories_id', $category_id)->where('card_status','!=','1')->orderBy('cards_id', 'asc')->first();
            $left = count(Card::where('cards_categories_id', $category_id)->where('card_status','!=','1')->get());
        }
        session(['language_id' => $category->categories_languages_id]);
        $languages = auth()->user()
            ->languages()
            ->orderBy('languages_name', 'asc')
            ->get();
        return view('play.play',compact('languages','card','left', 'playMode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = $this->ownedLanguage($id);
        $categories = $language->categories()->orderBy('categories_name', 'asc')->get();
        return view('play.categories',compact('language','categories'));
    }

    function replay(Request $request, $categories_id, $language_id)
    {
        $playMode = $this->getPlayMode($request);
        $category = $this->ownedCategory($categories_id);
        abort_unless((int) $category->categories_languages_id === (int) $language_id, 404);

        DB::table('cards')
              ->where('cards_categories_id', $categories_id)
              ->update(['card_status' => 0]);
        if($category->categories_type == 1){
            $card = Card::where('cards_categories_id', $categories_id)->where('card_status','!=','1')->inRandomOrder()->first();
            $left = count(Card::where('cards_categories_id', $categories_id)->where('card_status','!=','1')->get());
        }else{
            $card = Card::where('cards_categories_id', $categories_id)->orderBy('cards_id', 'asc')->first();
            $left = count(Card::where('cards_categories_id', $categories_id)->get());
        }
        return view('play.play',compact('card','left', 'playMode'));
    }

    function finish($categories_id, $language_id)
    {
        $language = $this->ownedLanguage($language_id);
        $category = $this->ownedCategory($categories_id);
        abort_unless((int) $category->categories_languages_id === (int) $language->getKey(), 404);

        DB::table('cards')
              ->where('cards_categories_id', $categories_id)
              ->update(['card_status' => 0]);
        $categories = $language->categories()->orderBy('categories_name', 'asc')->get();
        return view('play.categories',compact('language','categories'));
    }

    private function getPlayMode(Request $request)
    {
        return $request->query('mode') === 'answer-first'
            ? 'answer-first'
            : 'question-first';
    }

    private function ownedLanguage($id)
    {
        return Language::where('user_id', auth()->id())->findOrFail($id);
    }

    private function ownedCategory($id)
    {
        return Category::whereHas('language', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }
}

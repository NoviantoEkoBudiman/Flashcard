<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Category;
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
        $studyScope = $this->getStudyScope($request);
        $category = $this->ownedCategory($id);
        session(['language_id' => $category->categories_languages_id]);
        $this->resetPracticeProgress($category, $studyScope);
        [$card, $left, $deckSize] = $this->getPracticeState($category, $studyScope);

        return view('play.play', compact(
            'card',
            'left',
            'deckSize',
            'playMode',
            'studyScope'
        ));
    }

    public function assess(Request $request, $category_id, $card_id)
    {
        $validated = $request->validate([
            'result' => ['required', 'in:incorrect,correct'],
        ]);

        $playMode = $this->getPlayMode($request);
        $studyScope = $this->getStudyScope($request);
        $category = $this->ownedCategory($category_id);
        $card = $category->cards()->findOrFail($card_id);
        $card->card_status = 1;
        $card->card_last_answer_correct = $validated['result'] === 'correct';
        $card->save();

        [$card, $left, $deckSize] = $this->getPracticeState($category, $studyScope);
        session(['language_id' => $category->categories_languages_id]);

        return view('play.play', compact(
            'card',
            'left',
            'deckSize',
            'playMode',
            'studyScope'
        ));
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
        $categories = $language->categories()
            ->withCount([
                'cards as incorrect_cards_count' => function ($query) {
                    $query->where('card_last_answer_correct', false);
                },
            ])
            ->orderBy('categories_name', 'asc')
            ->get();
        return view('play.categories',compact('language','categories'));
    }

    function replay(Request $request, $categories_id, $language_id)
    {
        $playMode = $this->getPlayMode($request);
        $studyScope = $this->getStudyScope($request);
        $category = $this->ownedCategory($categories_id);
        abort_unless((int) $category->categories_languages_id === (int) $language_id, 404);

        DB::table('cards')
              ->where('cards_categories_id', $categories_id)
              ->update(['card_status' => 0]);
        [$card, $left, $deckSize] = $this->getPracticeState($category, $studyScope);

        return view('play.play', compact(
            'card',
            'left',
            'deckSize',
            'playMode',
            'studyScope'
        ));
    }

    function finish($categories_id, $language_id)
    {
        $language = $this->ownedLanguage($language_id);
        $category = $this->ownedCategory($categories_id);
        abort_unless((int) $category->categories_languages_id === (int) $language->getKey(), 404);

        DB::table('cards')
              ->where('cards_categories_id', $categories_id)
              ->update(['card_status' => 0]);
        $categories = $language->categories()
            ->withCount([
                'cards as incorrect_cards_count' => function ($query) {
                    $query->where('card_last_answer_correct', false);
                },
            ])
            ->orderBy('categories_name', 'asc')
            ->get();
        return view('play.categories',compact('language','categories'));
    }

    private function getPlayMode(Request $request)
    {
        return $request->query('mode') === 'answer-first'
            ? 'answer-first'
            : 'question-first';
    }

    private function getStudyScope(Request $request)
    {
        return $request->input('scope') === 'incorrect'
            ? 'incorrect'
            : 'all';
    }

    private function getPracticeState(Category $category, $studyScope)
    {
        $deckQuery = $category->cards();

        if ($studyScope === 'incorrect') {
            $deckQuery->where('card_last_answer_correct', false);
        }

        $deckSize = (clone $deckQuery)->count();
        $pendingQuery = $deckQuery->where('card_status', '!=', 1);
        $left = (clone $pendingQuery)->count();

        $card = $category->categories_type == 1
            ? $pendingQuery->inRandomOrder()->first()
            : $pendingQuery->orderBy('cards_id', 'asc')->first();

        return [$card, $left, $deckSize];
    }

    private function resetPracticeProgress(Category $category, $studyScope)
    {
        $query = $category->cards();

        if ($studyScope === 'incorrect') {
            $query->where('card_last_answer_correct', false);
        }

        $query->update(['card_status' => 0]);
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

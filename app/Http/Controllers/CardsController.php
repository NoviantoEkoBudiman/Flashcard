<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Card;

class CardsController extends Controller
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
            'cards_categories_id'   =>  'required',
            'cards_question'         =>  'required|array',
            'cards_question.*'       =>  'required|string',
            'cards_answer'           =>  'required|array',
            'cards_answer.*'         =>  'required|string'
        ],
        [
            'cards_categories_id.required'  =>  'Id Categories can\'t be null',
            'cards_question.required'        =>  'Card\'s question  can\'t be null',
            'cards_answer.required'          =>  'Card\'s answer  can\'t be null'
        ]);
        
        $category = $this->ownedCategory($validated['cards_categories_id']);

        foreach($validated['cards_question'] as $key => $question){
            $card = new Card;
            $card->cards_categories_id = $category->categories_id;
            $card->cards_question = $question;
            $card->cards_answer = $validated['cards_answer'][$key];
            $card->save();
        }

        return redirect()
                ->route('card.show', $category->categories_id)
                ->with('success', 'Data kartu berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->ownedCategory($id);
        $cards = $category->cards()->get();
        return view('card.detail',compact('category','cards'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cards = $this->ownedCard($id);
    }

    public function edit_card($id)
    {
        $card = $this->ownedCard($id);
        return response()->json([
            "cards_id"              => $card->cards_id,
            "cards_categories_id"   => $card->cards_categories_id,
            "cards_question"        => $card->cards_question,
            "cards_answer"          => $card->cards_answer,
        ]);
    }

    public function update_card(Request $request){
        $validated = $request->validate([
            'cards_id' => ['required', 'integer'],
            'cards_question' => ['required', 'string'],
            'cards_answer' => ['required', 'string'],
        ]);

        $card = $this->ownedCard($validated['cards_id']);
        $card->cards_question = $validated['cards_question'];
        $card->cards_answer = $validated['cards_answer'];
        $card->update();
        
        return redirect()
                ->route('card.show', $card->cards_categories_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = $this->ownedCard($id);
        if($card){
            $delete = $card->delete();
            if($delete){
                return redirect()
                        ->back()
                        ->with('success', 'Data card berhasil dihapus');
            }else{
                return redirect()
                            ->back()
                            ->with('error', 'Data card berhasil dihapus');
            }
        }else{
            return redirect()
                        ->back()
                        ->with('error', 'Data card gagal dihapus');
        }
    }

    private function ownedCategory($id)
    {
        return Category::whereHas('language', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }

    private function ownedCard($id)
    {
        return Card::whereHas('category.language', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }
}

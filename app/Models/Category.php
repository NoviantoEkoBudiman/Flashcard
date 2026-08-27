<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = "categories_id";
    protected $table = "categories";

    public function language()
    {
        return $this->belongsTo(Language::class, 'categories_languages_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'cards_categories_id');
    }
}

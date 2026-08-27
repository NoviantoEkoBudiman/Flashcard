<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $primaryKey = "cards_id";
    protected $table = "cards";

    public function category()
    {
        return $this->belongsTo(Category::class, 'cards_categories_id');
    }
}

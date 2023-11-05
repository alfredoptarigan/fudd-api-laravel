<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    protected $fillable = [
        'title',
        'picture',
        'description',
        'price',
        'quantity',
        'is_available',
        'is_vegetarian',
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'food_ingredients');
    }
}

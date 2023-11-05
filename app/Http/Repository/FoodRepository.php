<?php

namespace App\Http\Repository;

use App\Http\Repository\Eloquent\FoodRepositoryInterface;
use App\Models\Food;

class FoodRepository implements FoodRepositoryInterface
{

    public function all()
    {
        return Food::all();
    }

    public function find($id)
    {
        return Food::find($id);
    }
}

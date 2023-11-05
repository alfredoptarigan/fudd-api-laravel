<?php

namespace App\Http\Repository\Eloquent;

interface FoodRepositoryInterface
{
    public function all();

    public function find($id);

}

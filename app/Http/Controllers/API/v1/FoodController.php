<?php

namespace App\Http\Controllers\API\v1;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Repository\FoodRepository;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    protected $repository;


    public function __construct(FoodRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return ApiHelper::success($this->repository->all());
    }

    public function show($id)
    {
        return ApiHelper::success($this->repository->find($id));
    }
}

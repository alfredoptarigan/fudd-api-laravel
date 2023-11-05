<?php

namespace App\Http\Services;

use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Validator;
class UserService
{
    protected UserRepository $repository;
    // construct
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }
    /**
     * @param array<string, mixed> $data
     * @throws \Exception
     */
    public function register($data)
    {

        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $data->all();
        $input['password'] = bcrypt($input['password']);

        // create upload
        if ($data->hasFile('avatar')) {
            $file = $data->file('avatar');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $name);
            $input['avatar_url'] = $name;
        }


        $repositoryResponse = $this->repository->create($input);

        return $repositoryResponse;
    }
}

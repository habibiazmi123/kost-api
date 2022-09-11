<?php

namespace App\Services;

use App\Repositories\UserRepository;
use InvalidArgumentException;

class UserService
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function saveUser($input)
    {
        $validator = validator($input, [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6",
            "user_type" => "required|in:Owner,Regular,Premium"
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->userRepository->save($input);

        return $result;
    }
}

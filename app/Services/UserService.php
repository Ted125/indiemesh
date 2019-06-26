<?php

namespace Indiemesh\Services;

use Indiemesh\Repositories\UserRepository;
use JWTAuth;
use Illuminate\Support\Facades\Hash;

class UserService implements Service
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($firstName, $lastName, $username, $email, $birthdate, $password)
    {
        $user = $this->userRepository->createUser(
                                            $firstName,
                                            $lastName,
                                            $username,
                                            $email,
                                            $birthdate,
                                            Hash::make($password)
                                        );

        if($user){
            $token = $this->getToken($email, $password); // generate user token

            $user->auth_token = $token; // update user token
            $user->save();
        }

        return $user;
    }

    public function login($email, $password)
    {
        $user = $this->userRepository->findUserViaEmail($email);

        if($user && Hash::check($password, $user->password)){
            $token = $this->getToken($email, $password);
            $user->auth_token = $token;
            $user->save();
        }else{
            return null;
        }

        return $user;
    }

    private function getToken($email, $password)
    {
        $token = JWTAuth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        return $token;
    }
}

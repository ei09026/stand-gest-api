<?php

namespace App\Modules\Users\Services;

use App\Modules\Users\Contracts\IUserRepository;
use App\Modules\Users\Contracts\IUserService;

class UserService implements IUserService {

    /*
    |--------------------------------------------------------------------------
    | Shows Controller
    |--------------------------------------------------------------------------
    |
    |
    */

    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     *
     * @return Response
     */
    public function context($deviceId) {
        //Check if a user with this deviceId already exists
        //If true return the user
        //If false create a new user and return it

        $user = $this->userRepository->getUserByDeviceId($deviceId);

        if($user) {
            return $user;
        } else {
            return $this->userRepository->create($deviceId);
        }
    }

    public function facebookLogin($userId, $facebookId, $email,
        $firstName, $lastName, $photoUrl) {

        return $this->userRepository->facebookLogin($userId, $facebookId, $email,
            $firstName, $lastName, $photoUrl);
    }

    public function linkUserShow($userId, $showSlug) {
        return $this->userRepository->linkUserShow($userId, $showSlug);
    }

    public function linkUserSpoiler($userId, $spoilerId) {
        return $this->userRepository->linkUserSpoiler($userId, $spoilerId);
    }

    public function removeSpoilers($userId) {
        return $this->userRepository->removeSpoilers($userId);
    }
}
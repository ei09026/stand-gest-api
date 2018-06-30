<?php

namespace App\Modules\Users\Contracts;

interface IUserService {
    public function context($deviceId);
    public function facebookLogin($userId, $facebookId, $email, $firstName, $lastName, $photoUrl);
    public function linkUserShow($userId, $showSlug);
    public function linkUserSpoiler($userId, $spoilerId);
}
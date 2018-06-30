<?php

namespace App\Modules\Users\Contracts;

interface IUserRepository {
    public function getUserByDeviceId($deviceId);
    public function create($deviceId);
    public function facebookLogin($userId, $facebookId, $email, $firstName, $lastName, $photoUrl);
    public function linkUserShow($userId, $showSlug);
    public function linkUserSpoiler($userId, $spoilerId);
}
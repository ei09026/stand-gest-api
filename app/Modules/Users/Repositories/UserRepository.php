<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Contracts\IUserRepository;
use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Response;

class UserRepository implements IUserRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create($deviceId) {
        $user = new $this->model;
        $user->device_id = $deviceId;
        $user->save();

        return $user;
    }

    /**
     *
     * @return Response
     */

    public function getUserByDeviceId($deviceId) {
        return $user = $this->model->where('device_id', $deviceId)->first();
    }

    public function getByEmail($email) {
        return $user = $this->model->where('email', $email)->first();
    }

    public function facebookLogin($userId, $facebookId, $email, $firstName, $lastName, $photoUrl)
    {
        $user = $this->model->where('email', $email)
            ->orWhere('facebook_id', $facebookId)
            ->first();

        if(!empty($user)) {
            return $user;
        }

        $user = $this->model->where('id', $userId)->first();

        if(!empty($user)) {
            $user->facebook_id = $facebookId;
            $user->email = $email;
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->photo_url = $photoUrl;

            $user->save();

            return $user;
        }

        return new $this->model;
    }

    private function getLnkUserShow($userId, $showSlug) {
        return DB::select( DB::raw("SELECT * FROM pivot_user_show WHERE user_id = '$userId' AND show_slug = '$showSlug'") );
    }

    private function getLnkUserSpoiler($userId, $spoilerId) {
        return DB::select( DB::raw("SELECT * FROM pivot_user_spoiler WHERE user_id = '$userId' AND spoiler_id = '$spoilerId'") );
    }

    public function linkUserShow($userId, $showSlug) {
        //https://laravel.com/docs/5.3/eloquent-relationships#updating-many-to-many-relationships

        $lnkUserShow = $this->getLnkUserShow($userId, $showSlug);

        if(!count($lnkUserShow)) {
            $now = Carbon::now();
            DB::statement( DB::raw("INSERT INTO pivot_user_show (user_id, show_slug, created_at, updated_at) VALUES ('$userId', '$showSlug', '$now', '$now')") );
            return $this->getLnkUserShow($userId, $showSlug);
        } else {
            return $lnkUserShow;
        }
    }

    public function linkUserSpoiler($userId, $spoilerId) {
        $lnkUserSpoiler = $this->getLnkUserSpoiler($userId, $spoilerId);

        if(!count($lnkUserSpoiler)) {
            $now = Carbon::now();
            DB::statement( DB::raw("INSERT INTO pivot_user_spoiler (user_id, spoiler_id, created_at, updated_at) VALUES ('$userId', '$spoilerId', '$now', '$now')") );
            return $this->getLnkUserShow($userId, $spoilerId);
        } else {
            return $lnkUserSpoiler;
        }
    }

    public function removeSpoilers($userId) {
        if(DB::statement( DB::raw("DELETE FROM pivot_user_spoiler where user_id = '$userId'") )) {
            return array('success' => 'true');
        } else {
            return array('success' => 'false');
        }
    }
}
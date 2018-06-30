<?php
namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Api\ApiController;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Modules\Users\Repositories\UserRepository;
use Illuminate\Http\Request;
use Hash;

class AuthenticationController extends ApiController {
    private $userRepository;

    public function __construct(
        UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticate(Request $request) {        
        $email = $request->input('email');
        $password = $request->input('password');
        
        $user = $this->userRepository->getByEmail($email);

        if(!$user)
            return $this->respondFail('email-not-found', trans('users/messages.error.email-not-found'));

        if(!md5($password) == $user->password)
            return $this->respondFail('wrong-password', trans('users/messages.error.wrong-password'));

        $payload = JWTFactory::make(['sub' => $user->id]);

        $token = JWTAuth::encode($payload)->get();

        return $this->respondSuccess($token);
    }
}
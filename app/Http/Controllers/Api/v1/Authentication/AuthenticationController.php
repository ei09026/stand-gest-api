<?php
namespace App\Http\Controllers\Api\v1\Authentication;

use App\Modules\Users\Repositories\UserRepository;
use App\Http\Controllers\Api\ApiController;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Hash;

class AuthenticationController extends ApiController {
    private $userRepository;

    public function __construct(
        UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticate(Request $request) {        
        $email = $request->input('email'); // email or username
        $password = $request->input('password');
        
        $userByEmail = $this->userRepository->getByEmail($email);
        $userByUsername = $this->userRepository->getByUsername($email);

        $user = null;

        if(!empty($userByEmail)) {
            $user = $userByEmail;
        } else if (!empty($userByUsername)) {
            $user = $userByUsername;
        }

        if(!$user) {
            return $this->respondFail('email-not-found', trans('auth.email-username-not-found'));
        }

        if(md5($password) !== $user->password) {
            return $this->respondFail('wrong-password', trans('auth.wrong-password'));
        }

        $payload = JWTFactory::make(['sub' => $user->id]);

        $token = JWTAuth::encode($payload)->get();

        return $this->respondSuccess($token);
    }
}
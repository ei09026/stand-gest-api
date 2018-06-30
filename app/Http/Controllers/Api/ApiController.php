<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\Controller;
use Exception;
use Response;
use App;

class ApiController extends Controller {
    protected $statusCode = 200;

    protected function getUser() {
        return App::make('Tymon\JWTAuth\JWTAuth')->toUser();
    }
    
    public function getStatusCode() {
        return $this->statusCode;
    }
    
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }
    
    /**
     * 
     * @deprecated
     */
    protected function response($data = [], $headers = []) {
        return $this->respond($data, $headers);
    }

    protected function respondSuccess($data) {        
        return $this->respond([
            'status' => 'success',
            'data' => $data
        ]);
    }

    protected function respondFail($code, $message) {
        return $this->respond([
            'status' => 'fail',
            'error' => [
                'code' => $code,
                'message' => $message
            ],
        ]);
    }
    
    protected function respond($data = [], $headers = []) {
        return Response::json($data, $this->getStatusCode(), $headers);
    }
    
    protected function respondWithError($message = null, $headers = []) {
        if($this->getStatusCode() == 500)
            throw new Exception($message);
        
        throw new HttpException($this->getStatusCode(), $message, null, $headers);
    }
    
    protected function respondInternalError($message = 'Internal error!') {
        return $this->setStatusCode(500)->respondWithError($message);
    }
    
    protected function respondNotFound($message = 'Not found!') {
        return $this->setStatusCode(404)->respondWithError($message);
    }
    
    protected function respondBadRequest($message = 'Bad request!') {
        return $this->setStatusCode(400)->respondWithError($message);
    }
    
    protected function respondForbidden($message = 'Forbidden!') {
        return $this->setStatusCode(403)->respondWithError($message);
    }
}
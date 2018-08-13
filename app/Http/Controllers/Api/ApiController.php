<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function create(Request $request) {
        return $this->missingMethod();
    }

    public function retrieve(Request $request) {
        return $this->missingMethod();
    }

    public function update(Request $request) {
        return $this->missingMethod();
    }

    public function delete(Request $request) {
        return $this->missingMethod();
    }

    public function postIndex(Request $request) {
        switch ($request->input('method')) {
            case 'create': return $this->create($request);
            case 'retrieve': return $this->retrieve($request);
            case 'update': return $this->update($request);
            case 'delete': return $this->delete($request);
            default: return $this->missingMethod();
        }
    }
}
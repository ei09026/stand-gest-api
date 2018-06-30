<?php

namespace App\Modules\Spoilers\Services;

use App\Modules\Spoilers\Contracts\ISpoilerRepository;
use App\Modules\Spoilers\Contracts\ISpoilerService;

class SpoilerService implements ISpoilerService {

    /*
    |--------------------------------------------------------------------------
    | Shows Controller
    |--------------------------------------------------------------------------
    |
    |
    */

    private $spoilerRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ISpoilerRepository $spoilerRepository)
    {
        $this->spoilerRepository = $spoilerRepository;
    }

    /**
     *
     * @return Response
     */
    public function createSpoiler($showSlug, $description, $userId) {
        return $this->spoilerRepository->createSpoiler($showSlug, $description, $userId);
    }


    public function getSpoilers($userId, $limit) {
        return $this->spoilerRepository->getSpoilers($userId, $limit);
    }

    public function setMadness($userId, $spoilerId, $mad) {
        return $this->spoilerRepository->setMadness($userId, $spoilerId, $mad);
    }
}
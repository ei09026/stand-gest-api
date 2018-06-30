<?php

namespace App\Modules\Shows\Services;

use App\Modules\Shows\Contracts\IShowRepository;
use App\Modules\Shows\Contracts\IShowService;

class ShowService implements IShowService {

    /*
    |--------------------------------------------------------------------------
    | Shows Controller
    |--------------------------------------------------------------------------
    |
    |
    */

    private $showRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IShowRepository $showRepository)
    {
        $this->showRepository = $showRepository;
    }

    /**
     *
     * @return Response
     */
    public function getAll()
    {
        return $this->showRepository->getAll();
    }

    public function getPaginated($page, $perPage, $search) {
        return $this->showRepository->getPaginated($page, $perPage, $search);
    }

    public function getPoster($slug) {
        return $this->showRepository->getPoster($slug);
    }
}
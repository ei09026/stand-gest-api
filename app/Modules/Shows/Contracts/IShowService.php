<?php

namespace App\Modules\Shows\Contracts;

interface IShowService {
    public function getAll();
    public function getPaginated($page, $perPage, $search);
    public function getPoster($slug);
}
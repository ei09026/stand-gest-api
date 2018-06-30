<?php

namespace App\Modules\Shows\Contracts;

interface IShowRepository {
    public function getAll();
    public function getPaginated($page, $perPage, $search);
    public function getPoster($slug);
}
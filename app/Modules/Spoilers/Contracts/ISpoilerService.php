<?php

namespace App\Modules\Spoilers\Contracts;

interface ISpoilerService {
    public function getSpoilers($userId, $limit);
    public function setMadness($userId, $spoilerId, $mad);
}
<?php

namespace App\Modules\Spoilers\Contracts;

interface ISpoilerRepository {
    public function getSpoilers($userId, $limit);
    public function setMadness($userId, $spoilerId, $mad);
}
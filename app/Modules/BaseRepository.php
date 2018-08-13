<?php

namespace App\Modules;

use Illuminate\Support\Facades\Auth;

class BaseRepository {
    protected function setCCreateUpdateDeleteValues($model, $deletedAt = false) {
        $model['created_at'] = date("Y-m-d h:i:s");
        $model['updated_at'] = date("Y-m-d h:i:s");
        $model['created_by'] = Auth::user()->id;
        $model['updated_by'] = Auth::user()->id;
        $model['deleted_at'] = $deletedAt ? date("Y-m-d h:i:s") : null;
        $model['deleted_by'] = $deletedAt ? Auth::user()->id : null;

        return $model;
    }

    protected function setUCreateUpdateDeletedValues($model, $deletedAt = false) {
        $model['updated_at'] = date("Y-m-d h:i:s");
        $model['updated_by'] = Auth::user()->id;

        return $model;
    }

    protected function setDeletedValues($model) {
        $model['deleted_at'] = date("Y-m-d h:i:s");
        $model['deleted_by'] = Auth::user()->id;

        return $model;
    }

    protected function clearDeletedValues($model) {
        $model['deleted_at'] = null;
        $model['deleted_by'] = null;

        return $model;
    }
}
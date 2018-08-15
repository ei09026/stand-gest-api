<?php

namespace App\Modules\Extras\Repositories;

use App\Modules\Extras\Contracts\IExtraRepository;
use App\Modules\Extras\Models\Extra;
use App\Modules\BaseRepository;
use Paginator;

class ExtraRepository extends BaseRepository implements IExtraRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $extra;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Extra $extra)
    {
        $this->extra = $extra;
    }

    public function getExtras($filter, $orderBy, $pagination)
    {;

        $search = $filter['description'];
        $rankId = $filter['rankId'];
        $active = $filter['active'];

        $query = $this->extra->where('description', 'ILIKE', "%$search%");

        if (!empty($rankId)) {
            $query->Where('rank_id', $rankId);
        }

        if ($active === true) {
            $query->WhereNull('deleted_at');
        } else if ($active === false){
            $query->WhereNotNull('deleted_at');
        }

        $query->orderBy($orderBy['column'], $orderBy['direction']);

        return $query->paginate($pagination['itemsPerPage'], ['*'], 'page', $pagination['page']);
    }

    public function create($extraDto)
    {
        $extra = [
            'description' => $extraDto['description'],
            'rank_id' => $extraDto['rankId']
        ];

        $extra = $this->setCCreateUpdateDeleteValues($extra, !$extraDto['active']);

        $this->extra->create($extra);

        return $extra;
    }

    public function update($id, $extraDto) {
        $extra = $this->extra->find($id);

        $extra->description = $extraDto['description'];
        $extra->rank_id = $extraDto['rankId'];

        $extra = $this->setUCreateUpdateDeletedValues($extra);

        if ($extraDto['active'] === false) {
            $extra = $this->setDeletedValues($extra);
        } else {
            $extra = $this->clearDeletedValues($extra);
        }

        $extra->save();

        return $extra;
    }
}
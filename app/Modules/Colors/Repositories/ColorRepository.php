<?php

namespace App\Modules\Colors\Repositories;

use App\Modules\Colors\Contracts\IColorRepository;
use App\Modules\Colors\Models\Color;
use App\Modules\BaseRepository;
use Paginator;

class ColorRepository extends BaseRepository implements IColorRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $color;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    public function getColors($filter, $orderBy, $pagination)
    {
        if (!$pagination) {
            return $this->color->get();
        }

        $search = $filter['description'];
        $active = $filter['active'];

        $query = $this->color->where('description', 'ILIKE', "%$search%");

        if ($active === true) {
            $query->WhereNull('deleted_at');
        } else if ($active === false){
            $query->WhereNotNull('deleted_at');
        }

        $query->orderBy($orderBy['column'], $orderBy['direction']);

        return $query->paginate($pagination['itemsPerPage'], ['*'], 'page', $pagination['page']);
    }

    public function create($colorDto)
    {
        $color = [
            'description' => $colorDto['description'],
        ];

        $color = $this->setCCreateUpdateDeleteValues($color, !$colorDto['active']);

        $this->color->create($color);

        return $color;
    }

    public function update($id, $colorDto) {
        $color = $this->color->find($id);

        $color->description = $colorDto['description'];

        $color = $this->setUCreateUpdateDeletedValues($color);

        if ($colorDto['active'] === false) {
            $color = $this->setDeletedValues($color);
        } else {
            $color = $this->clearDeletedValues($color);
        }

        $color->save();

        return $color;
    }
}
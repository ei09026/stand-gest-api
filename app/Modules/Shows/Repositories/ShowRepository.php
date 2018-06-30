<?php

namespace App\Modules\Shows\Repositories;

use App\Modules\Shows\Contracts\IShowRepository;
use App\Modules\Shows\Models\Show;
use Illuminate\Support\Facades\DB;

class ShowRepository implements IShowRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Show $model)
    {
        $this->model = $model;
    }

    /**
     *
     * @return Response
     */
    public function getAll()
    {
        return Show::all();
    }

    public function getPaginated($page, $perPage, $search)
    {
        if(empty($perPage)) {
            $perPage = 10;
        }

        $query = DB::table('shows')
            ->join('show_details', 'shows.tmdb', '=', 'show_details.tmdb')
            ->select('shows.*', 'show_details.poster_url');

        if(!empty($query)) {
            $query->where('shows.title', 'ilike', '%' . $search . '%');
        }

        $shows = $query->paginate((int)$perPage);

        if(!empty($perPage)) {
            $shows->addQuery('perPage', $perPage);
        }

        if(!empty($search)) {
            $shows->addQuery('search', $search);
        }

        return $shows;
    }

    public function getPoster($slug)
    {
        $posters = DB::select('select sd.poster_url from shows s, show_details sd
                            where s.tmdb = sd.tmdb
                            and s.slug = :slug', ['slug' => $slug]);

        return array_values($posters)[0];
    }
}
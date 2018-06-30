<?php

namespace App\Modules\Spoilers\Repositories;

use App\Modules\Spoilers\Contracts\ISpoilerRepository;
use App\Modules\Spoilers\Models\Spoiler;
use Illuminate\Support\Facades\DB;
use App\Modules\Shows\Repositories;
use App\Modules\Shows\Contracts\IShowRepository;
use Image;
use URL;
use Illuminate\Support\Facades\File;

class SpoilerRepository implements ISpoilerRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $model;
    private $showRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Spoiler $model, IShowRepository $showRepository)
    {
        $this->model = $model;
        $this->showRepository = $showRepository;
    }

    /*public function createSpoiler($showSlug, $description, $userId) {

        $url = "https://spoileaks.herokuapp.com/api/spoilers";

        $showPoster = ($this->showRepository->getPoster($showSlug));

        $data = array("background" => $showPoster->poster_url, "text" => $description);

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data, JSON_UNESCAPED_SLASHES)
            )
        );
        $context  = stream_context_create($options);
        $poster = file_get_contents($url, true, $context);

        $id = DB::select('insert into spoilers 
                          (show_slug, description, mad_count, not_mad_count, relevance, poster, created_at, updated_at, created_by)
                            values (:showSlug, :description, 0, 0, 0, :poster, now(), now(), :userId) returning id',
            ['showSlug' => $showSlug, 'description' => $description, 'userId' => $userId, 'poster' => $poster]);


        return response()->json(array('id' => $id[0]->id, 'poster' => $poster), 200, [], JSON_UNESCAPED_SLASHES);
    }*/

    public function createSpoiler($showSlug, $description, $userId) {
        $url = "https://spoileaks.herokuapp.com/api/spoilers";

        $showPoster = ($this->showRepository->getPoster($showSlug));

        $data = array("background" => $showPoster->poster_url, "text" => $description);

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data, JSON_UNESCAPED_SLASHES)
            )
        );

        $context  = stream_context_create($options);
        $poster = file_get_contents($url, true, $context);

        $maxId = DB::select('select count(*) from spoilers');

        //File::exists(storage_path(public_path().'/img/spoilers')) or File::makeDirectory(storage_path(public_path().'/img/spoilers'));


        $png_url = "spoiler-".time().$maxId[0]->count.".png";
        $path = public_path().'/img/spoilers/' . $png_url;

        $posterURL = URL::to('/img/spoilers/'.$png_url);

        Image::make($poster)->save($path);

        $id = DB::select('insert into spoilers 
                          (show_slug, description, mad_count, not_mad_count, relevance, poster, created_at, updated_at, created_by)
                            values (:showSlug, :description, 0, 0, 0, :poster, now(), now(), :userId) returning id',
            ['showSlug' => $showSlug, 'description' => $description, 'userId' => $userId, 'poster' => $posterURL]);

        return array('id' => $id[0]->id, 'poster' => $posterURL);
    }

    public function getSpoilers($userId, $limit) {
        return DB::select('select s.*, sh.title, u.first_name as user_first_name, u.last_name as user_last_name, u.photo_url as user_photo, sd.poster_url as show_poster_url from spoilers s
                            join users u on s.created_by = u.id
                            join shows sh on s.show_slug = sh.slug
                            join show_details sd on sh.tmdb = sd.tmdb
                            where s.id not in
                            (select pus.spoiler_id from pivot_user_spoiler pus where pus.user_id = :userId)
                            order by s.relevance
                            limit :limit', ['userId' => $userId, 'limit' => $limit]);
    }

    private function getMadness($userId, $spoilerId) {
        return DB::select('select * from pivot_user_spoiler pus                            
                            where pus.user_id = :userId
                            and pus.spoiler_id = :spoilerId
                            limit 1',
            ['userId' => $userId, 'spoilerId' => $spoilerId]);
    }


    private function updateSpoilerMadnessCounters ($spoilerId, $mad) {
        if($mad == 'true') {
            DB::select('update spoilers set mad_count = (mad_count + 1)
                    WHERE id = :spoilerId',
                ['spoilerId' => $spoilerId]);
        } else {
            DB::select('update spoilers set not_mad_count = (not_mad_count + 1)
                    WHERE id = :spoilerId',
                ['spoilerId' => $spoilerId]);
        }
    }

    public function setMadness($userId, $spoilerId, $mad) {
        $results = $this->getMadness($userId, $spoilerId);

        if(!empty($results)) {
            if($mad == 'true') {
                DB::select('update pivot_user_spoiler set mad = TRUE 
                            WHERE user_id = :userId and spoiler_id = :spoilerId',
                    ['userId' => $userId, 'spoilerId' => $spoilerId]);

                $this->updateSpoilerMadnessCounters($spoilerId, $mad);
            } else {
                DB::select('update pivot_user_spoiler set mad = FALSE 
                            WHERE user_id = :userId and spoiler_id = :spoilerId',
                    ['userId' => $userId, 'spoilerId' => $spoilerId]);

                $this->updateSpoilerMadnessCounters($spoilerId, $mad);
            }
        } else {
            DB::insert('insert into pivot_user_spoiler (user_id, spoiler_id, mad, created_at, updated_at)
                        values (:userId, :spoilerId, :mad, now(), now())',
                ['userId' => $userId, 'spoilerId' => $spoilerId, 'mad' => $mad]);

            $this->updateSpoilerMadnessCounters($spoilerId, $mad);
        }

        return $this->getMadness($userId, $spoilerId);
    }
}
<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Contracts\IUserRepository;
use Illuminate\Support\Facades\DB;
use App\Modules\Users\Models\User;
use App\Modules\BaseRepository;
use Illuminate\Http\Response;
use Carbon\Carbon;

class UserRepository extends BaseRepository implements IUserRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function getUsers($filter, $orderBy, $pagination)
    {
        $name = $filter['name'];
        $email = $filter['email'];
        $username = $filter['username'];
        $active = $filter['active'];

        $query = $this->user->where('name', 'ILIKE', "%$name%")
        ->where('email', 'ILIKE', "%$email%")
        ->where('username', 'ILIKE', "%$username%");

        if ($active === true) {
            $query->WhereNull('deleted_at');
        } else if ($active === false){
            $query->WhereNotNull('deleted_at');
        }

        $query->orderBy($orderBy['column'], $orderBy['direction']);

        return $query->paginate($pagination['itemsPerPage'], ['*'], 'page', $pagination['page']);
    }

    public function create($userDto)
    {
        $user = [
			'name' => $userDto['name'],
			'email' =>  $userDto['email'],
			'username' => $userDto['username'],
            'picture' => $userDto['picture'],
            'password' => $userDto['password']
        ];

        $user = $this->setCCreateUpdateDeleteValues($user, !$userDto['active']);

        $this->user->create($user);

        return $user;
    }

    public function update($id, $userDto) {
        $user = $this->user->find($id);

        $user->name = $userDto['name'];
        $user->email = $userDto['email'];
        $user->username = $userDto['username'];
        $user->picture = $userDto['picture'];
        $user->password = $userDto['password'];
        
        $user = $this->setUCreateUpdateDeletedValues($user);

        if ($userDto['active'] === false) {
            $user = $this->setDeletedValues($user);
        } else {
            $user = $this->clearDeletedValues($user);
        }
        
        $user->save();

        return $user;
    }
}
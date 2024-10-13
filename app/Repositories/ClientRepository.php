<?php

namespace App\Repositories;

use Carbon\Carbon;


use App\Models\Client;
use App\Repositories\Repository;
// use App\Http\Requests\StoreClientRequest;


class ClientRepository extends Repository
{
    public function __construct(Client $model)
    {
        $this->model = $model;
    }



}

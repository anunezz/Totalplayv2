<?php

namespace App\Repositories\Formality;

use App\Http\Models\Formalities;
use App\Repositories\BaseRepository;

class FormalityRepository extends BaseRepository
{
    protected $model;

    public function __construct(Formalities $model)
    {
        $this->model = $model;
    }

}

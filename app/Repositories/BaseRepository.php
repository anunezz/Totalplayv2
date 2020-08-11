<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find(decrypt($id));
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $register = $this->model->find(decrypt($id));
        $register->update($data);
        return $register;
    }

    public function delete($id)
    {
        $this->model->destroy(decrypt($id));
    }
}

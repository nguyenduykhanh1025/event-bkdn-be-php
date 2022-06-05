<?php

namespace App\Repositories;

use Carbon\Carbon;

class BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
    public function all()
    {
        return $this->model->all();
    }
    public function findById($id)
    {
        return $this->model->where('id', $id)->first();
    }
    public function store($data)
    {
        return $this->model->create($data);
    }
    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }
    public function deleteById($id)
    {
        $dataFromDB = $this->model->where('id', $id)->first();
        if (empty($dataFromDB)) {
            return null;
        }
        return $this->model->destroy($dataFromDB);
    }
}

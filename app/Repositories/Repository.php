<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model as Model;

class Repository
{

    public function __construct(
        protected Model $model
    ) {
    }

    public function all()
    {
        return $this->model::all();
    }

    public function getById(int $id)
    {
        return $this->model::find($id);
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id)
    {
        $model = $this->model::find($id);

        return $model->update($data);
    }

    public function deleteById($id)
    {
        $model = $this->model::find($id);

        return $model->delete();
    }

    public function last()
    {
        return $this->model::latest();
    }

    public function whereFirst(array $condition)
    {
        return $this->model::where($condition)->first();
    }

    public function whereGet(array $condition)
    {
        return $this->model::where($condition)->get();
    }

    public function massDelete(array $ids)
    {
        return $this->model::destroy($ids);
    }

    public function firstOrCreate($check, $data)
    {
        return $this->model::firstOrCreate($check, $data);
    }

    public function updateOrCreate($data)
    {
        return $this->model::query()->updateOrCreate($data);
    }

}

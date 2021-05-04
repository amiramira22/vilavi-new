<?php

namespace App\Repositories;

abstract class ResourceRepository {

    protected $model;
    public function getAll($columns=array('*')) {
        return $this->model->all($columns);
    }

    public function getPaginate($n) {
        return $this->model->paginate($n);
    }

    public function store(Array $inputs) {
        return $this->model->insert($inputs);
    }

    public function getById($id) {
        return $this->model->findOrFail($id);
    }

    public function update($id, Array $inputs) {
        $this->getById($id)->fill($inputs)->save();
        
    }

    public function destroy($id) {
        $this->getById($id)->delete();
    }

}

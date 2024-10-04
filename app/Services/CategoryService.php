<?php

namespace App\Services;

use App\Models\Category;

class CategoryService extends BaseService
{
    public function setModel()
    {
        return new Category();
    }

    public function getAllCategories()
    {
        return $this->model->all();
    }

    public function getCategoryById($id){
        return $this->model->find($id);
    }
    
    public function store($data){

        return $this->model->create($data);
    }
    
    public function update($id, $data){
        $category = $this->model->find($id);
        if($category){
            $category->update($data);
            return $category;
        }
        return null;
    }
    
    public function delete($id){
        $category = $this->model->find($id);
        if($category){
            $category->delete();
            return true;
        }
        return false;
    }
}
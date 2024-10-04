<?php

namespace App\Services;

use App\Models\User;
class UserService extends BaseService
{
    public function setModel()
    {
        return new User();
    }

    public function getAllUsers(){
        return $this->model->all();
    }
    public function update($id, $data){
        $result = $this->model->find($id);
        return $result->update($data);
    }
}
<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    // Example: Create a new user
    public function createUser()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            'saldo'    => 'required',
            'email'    => 'required|valid_email|is_unique[coconut_user.email]',
            'password' => 'required|min_length[6]',
            'user_type' => 'required|max_length[1]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'user_type'    => $this->request->getPost('user_type'),
            'saldo'    => $this->request->getPost('saldo'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $this->model->save($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'User created successfully']);
    }

    // Example: Get all users
    public function getAllUsers()
    {
        $users = $this->model->findAll();
        return $this->respond(['status' => 'success', 'data' => $users]);
    }
}

?>
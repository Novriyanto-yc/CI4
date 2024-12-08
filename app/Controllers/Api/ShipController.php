<?php

namespace App\Controllers\Api;

use App\Models\ShipModel;
use CodeIgniter\RESTful\ResourceController;

class ShipController extends ResourceController
{
    protected $modelName = 'App\Models\ShipModel';
    protected $format    = 'json';

    // Example: Create a new user
    public function createShip()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'name'          => $this->request->getPost('name'),
            'is_visible'    => 1
        ];

        $this->model->save($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'User created successfully']);
    }

    public function getAllShip()
    {
        $s = $this->model->where('is_visible', 1)->findAll();
        
        // for array
        $response = array_map(function ($s) {
            return [
                'id'         => (int) $s['id'],
                'name'       => (string) $s['name'],
                'is_visible' => (bool) $s['is_visible'],
                'created_at' => (string) $s['created_at'], 
            ];
        }, $s);
        return $this->respond(['status' => 'success', 'data' => $response]);
    }
}

?>
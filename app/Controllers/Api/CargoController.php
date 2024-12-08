<?php

namespace App\Controllers\Api;

use App\Models\CargoModel;
use CodeIgniter\RESTful\ResourceController;

class CargoController extends ResourceController
{
    protected $modelName = 'App\Models\CargoModel';
    protected $format    = 'json';

    // Example: Create a new user
    public function createCargo()
    {
        $rules = [
            'ship_id'               => 'required',
            'user_id'               => 'required',
            'total_ship_cargo'      => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'ship_id'          => $this->request->getPost('ship_id'),
            'user_id'          => $this->request->getPost('user_id'),
            'total_ship_cargo' => $this->request->getPost('total_ship_cargo'),
            'is_completed'     => 0
        ];

        $this->model->save($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'User created successfully']);
    }

    public function getCargo()
    {
        $id = $this->request->getVar('user_id', FILTER_SANITIZE_STRING) ?? '';
        $date = $this->request->getVar('date', FILTER_SANITIZE_STRING) ?? '';
        $s = $this->model->getUnfinishedCargo($id, $date);

        // for array
        $response = array_map(function ($s) {
            return [
                'id'                => (int) $s['id'],
                'user_id'           => (int) $s['user_id'],
                'ship_id'           => (int) $s['ship_id'],
                'name'              => (string) $s['name'],
                'total_ship_cargo'  => (double) $s['total_ship_cargo'],
                'is_completed'      => (bool) $s['is_completed'],
                'created_at'        => (string) $s['created_at'],
                'username'        => (string) $s['username']
            ];
        }, $s);
        return $this->respond(['status' => 'success', 'data' => $response]);
    }

    public function getAllCargo()
    {
        $date = $this->request->getVar('date', FILTER_SANITIZE_STRING) ?? '';
        $s = $this->model->getAllUnfinishedCargo($date);

        // for array
        $response = array_map(function ($s) {
            return [
                'id'                => (int) $s['id'],
                'user_id'           => (int) $s['user_id'],
                'ship_id'           => (int) $s['ship_id'],
                'name'              => (string) $s['name'],
                'total_ship_cargo'  => (double) $s['total_ship_cargo'],
                'is_completed'      => (bool) $s['is_completed'],
                'created_at'        => (string) $s['created_at']
            ];
        }, $s);
        return $this->respond(['status' => 'success', 'data' => $response]);
    }

    public function updateCargoStatus($id = null){
        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'There is no data to update.',
            ], 400);
        }

        // Attempt update
        if ($this->model->update($id, $data)) {
            return $this->respond([
                'status'  => 'success',
                'message' => 'Record updated successfully. '.$id.' dan '
            ], 200);
        }

        // Return error response
        return $this->respond([
            'status'  => 'error',
            'message' => 'Failed to update the record.',
            'errors'  => $this->model->errors(), // Include validation errors if any
        ], 400);
    }
}

?>
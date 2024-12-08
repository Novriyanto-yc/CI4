<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class DataController extends ResourceController
{
    public function index()
    {
        return $this->respond(['status' => 'success', 'data' => 'This is protected data'], 200);
    }
}

?>
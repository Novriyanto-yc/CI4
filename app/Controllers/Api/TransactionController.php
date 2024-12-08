<?php

namespace App\Controllers\Api;

use App\Models\TransactionModel;
use CodeIgniter\RESTful\ResourceController;

class TransactionController extends ResourceController
{
    protected $modelName = 'App\Models\TransactionModel';
    protected $format    = 'json';

    public function createTransaction()
    {
        $rules = [
            'cargo_id'              => 'required',
            'user_id'               => 'required',
            'muatan_kg'             => 'required',
            'komisi_in_rp'          => 'required',
            'total_komisi_in_rp'    => 'required',
            'total_muatan_in_rp'    => 'required',
            'nama_petani'           => 'required',
            'tanggal_muatan'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'cargo_id'              => $this->request->getPost('cargo_id'),
            'user_id'               => $this->request->getPost('user_id'),
            'muatan_kg'             => $this->request->getPost('muatan_kg'),
            'komisi_in_rp'          => $this->request->getPost('komisi_in_rp'),
            'total_komisi_in_rp'    => $this->request->getPost('total_komisi_in_rp'),
            'total_muatan_in_rp'    => $this->request->getPost('total_muatan_in_rp'),
            'nama_petani'           => $this->request->getPost('nama_petani'),
            'tanggal_muatan'        => $this->request->getPost('tanggal_muatan'),
            'status'                => 'pending'
        ];

        $this->model->save($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'Transaction created successfully']);
    }
}

?>
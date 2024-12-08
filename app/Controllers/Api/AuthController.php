<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';
    // public function login()
    // {
    //     $username = $this->request->getVar('username');
    //     $password = $this->request->getVar('password');

    //     // Dummy authentication for demonstration
    //     if ($username === 'admin' && $password === 'password') {
    //         $key = getenv('JWT_SECRET');
    //         $payload = [
    //             'iss' => 'CodeIgniter 4 API', // Issuer
    //             'iat' => time(),             // Issued at
    //             'exp' => time() + 3600,      // Expiration time (1 hour)
    //             'uid' => 1,                  // User ID
    //             'username' => $username
    //         ];
    //         $token = JWT::encode($payload, $key, 'HS256');

    //         return $this->respond(['status' => 'success', 'token' => $token], 200);
    //     }

    //     return $this->respond(['status' => 'error', 'message' => 'Invalid credentials'], 401);
    // }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->model->findByEmail($email);

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        if (!password_verify($password, $user['password'])) {
            return $this->fail('Invalid credentials');
        }
        
        $key = getenv('JWT_SECRET');
        $payload = [
            'iss' => 'Coconut App', // Issuer
            'iat' => time(),             // Issued at
            'exp' => time() + 3600,      // Expiration time (1 hour)
            'uid' => 1,                  // User ID
            'email' => $email
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        $response = [
            'id'            => (int) $user['id'],
            'user_type'     => (int) $user['user_type'],
            'name'          => (string) $user['name'],
            'saldo'         => (float) $user['saldo'],
            'email'         => (string) $user['email'],
            'access_token'  => (string) $token,
        ];

        // for array
        // $response = array_map(function ($user) {
        //     return [
        //         'id'         => $user['id'],              // INT
        //     //     'name'       => (string) $user['name'],         // VARCHAR
        //     //     'email'      => (string) $user['email'],         // DECIMAL
        //     //     'user_type' => (int) $user['user_type'],   // DATETIME
        //     //     'saldo'  => (double) $user['saldo'],      // TINYINT -> Boolean
        //     ];
        // }, $user);

        // Return success response with user data (without password)
        unset($response['password']);
        return $this->respond([
            'status'  => 'success',
            'message' => 'Login successful',
            'data'    => $response,
        ]);
    }
}

?>
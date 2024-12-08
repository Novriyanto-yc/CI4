<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeader('Authorization');
        if (!$header) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Authorization header not found'])
                ->setStatusCode(401);
        }

        $token = explode(' ', $header->getValue())[1];
        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            // Optionally set user info to request
            $request->user = $decoded;
        } catch (\Exception $e) {
            return Services::response()->setStatusCode(401)
                               ->setJSON([
                                'error' => 'Authentication failed. Invalid token.',
                                'status' => 'failed'
                            ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

?>
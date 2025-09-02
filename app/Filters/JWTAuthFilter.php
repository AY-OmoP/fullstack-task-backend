<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['message' => 'Missing or invalid Authorization header']);
        }
        $token = substr($authHeader, 7);
        try {
            $secret = config('App')->jwtSecret ?? env('app.jwtSecret');
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            // Attach user to request for convenience
            $request->user = (array) $decoded->data;
        } catch (Exception $e) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['message' => 'Invalid token', 'error' => $e->getMessage()]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No-op
    }
}

<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->post('auth/login', 'AuthController::login'); // Endpoint for generating token
    $routes->get('data', 'DataController::index', ['filter' => 'authFilter']); // Protected endpoint
    
    $routes->post('user/create', 'UserController::createUser', ['filter' => 'authFilter']);
    $routes->get('user/get', 'UserController::getAllUsers', ['filter' => 'authFilter']);

    $routes->post('ship/create', 'ShipController::createShip', ['filter' => 'authFilter']);
    $routes->get('ship/get', 'ShipController::getAllShip', ['filter' => 'authFilter']);

    $routes->post('cargo/create', 'CargoController::createCargo', ['filter' => 'authFilter']);
    $routes->get('cargo/get', 'CargoController::getCargo', ['filter' => 'authFilter']);
    $routes->get('cargo/get_all', 'CargoController::getAllCargo', ['filter' => 'authFilter']);
    $routes->put('cargo/update/(:any)', 'CargoController::updateCargoStatus/$1', ['filter' => 'authFilter']);


    $routes->post('transaction/create', 'TransactionController::createTransaction', ['filter' => 'authFilter']);
});




// $routes->get('user/(:num)', 'UserController::profile/$1'); 
// // Maps `GET /user/1` to `UserController::profile(1)`

// $routes->get('product/(:any)', 'ProductController::details/$1'); 
// // Maps `GET /product/laptop` to `ProductController::details('laptop')`

// <?php

// namespace App\Models;

// use CodeIgniter\Model;

// class ProductModel extends Model
// {
//     protected $table = 'products';
//     protected $primaryKey = 'id';

//     public function getProducts($category = null, $price = null, $limit = 10, $page = 1)
//     {
//         // Build the query using query parameters
//         $builder = $this->builder();

//         if ($category) {
//             $builder->where('category', $category);
//         }

//         if ($price) {
//             $builder->where('price', $price);
//         }

//         // Implement pagination using limit and offset
//         $offset = ($page - 1) * $limit;
//         $builder->limit($limit, $offset);

//         // Execute the query and return the results
//         return $builder->get()->getResult();
//     }
// }
<?php
//Routes
use App\Controller\HomeController;
use App\Controller\CustomerController;
use App\Controller\TransactionController;
// use App\Controller\AuthController;

$app->get('/', CustomerController::class.':indexAction')->setName('home');
// $app->get('/welcome', HomeController::class.':welcomeAction')->setName('welcome')
// ->add(new \App\Middleware\UserAuthMiddleware($container));

$app->group('/customers', function () {
    $this->get('', CustomerController::class.':indexAction')->setName('customers');
    $this->get('/add', CustomerController::class.':addAction')->setName('customerAdd');
    $this->post('/save', CustomerController::class.':saveAction')->setName('customerSave');
    $this->get('/edit/{id}', CustomerController::class.':editAction')->setName('customerEdit');
    $this->post('/update', CustomerController::class.':updateAction')->setName('customerUpdate');
    $this->delete('/delete', CustomerController::class.':deleteAction')->setName('customerDelete');
});

$app->group('/transaction/{customer_id}', function () {
    $this->get('', TransactionController::class.':indexAction')->setName('transactions');
    $this->get('/add', TransactionController::class.':addAction')->setName('transactionAdd');
    $this->post('/save', TransactionController::class.':saveAction')->setName('transactionSave');
    $this->get('/edit/{id}', TransactionController::class.':editAction')->setName('transactionEdit');
    $this->post('/update', TransactionController::class.':updateAction')->setName('transactionUpdate');
    $this->delete('/delete', TransactionController::class.':deleteAction')->setName('transactionDelete');
});

// $app->get('/register', AuthController::class.':registerPageAction')->setName('registerPage');
// $app->post('/register', AuthController::class.':registerSaveAction')->setName('registerSave');

// $app->get('/login', AuthController::class.':loginPageAction')->setName('loginPage');
// $app->post('/login', AuthController::class.':loginAction')->setName('login');

// $app->get('/logout', AuthController::class.':logoutAction')->setName('logout');

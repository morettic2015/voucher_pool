<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


$app = new \Slim\App;
$app->config('debug', true);

/**
 * @see app front end
 * */
$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    include_once './br/com/morettic/view/index.php';
    die;
 });
/**
 * @see apigen doc
 * */
$app->get('/docs/', function (ServerRequestInterface $request, ResponseInterface $response) {
   include_once './docs/index.html';
   die;
});

/**
 * @see endpoint for verifying and redeeming vouchers
 * 
 * Provide an endpoint, reachable via HTTP, which receives a Voucher Code and Email 
 * and validates the Voucher Code. In Case it is valid, return the Percentage Discount 
 * and set the date of usage
 * 
 * @link curl -XPOST -d 'voucher_id=80&email=malacma@gmail.com' 'http://localhost:8080/redeeming'
 *  
 * */
$app->post('/redeeming', function (ServerRequestInterface $request, ResponseInterface $response) {
    $newResponse = $response->withHeader('Content-type', 'application/json');
    $model = new PersistenceManager();
    $data = $request->getParsedBody();

    $std = $model->validateVoucherCode($data['voucher_id'],$data['email']);
    return $newResponse->withJson($std, 201);
});
/**
 * @see endpoint for verifying and redeeming vouchers
 * 
 * Extra: For a given Email, return all his valid Voucher Codes with the Name of the Special Offer
 * 
 * @link curl -XPOST -d 'email=malacma@gmail.com' 'http://localhost:8080/list'
 *  
 * */
$app->post('/list', function (ServerRequestInterface $request, ResponseInterface $response) {
    $newResponse = $response->withHeader('Content-type', 'application/json');
    $model = new PersistenceManager();
    $data = $request->getParsedBody();

    $std = $model->listVoucherByEmail($data['email']);
    return $newResponse->withJson($std, 201);
});
/**
 * @see endpoint for generating Voucher Code
 * @see http://localhost:8080/newvouchers/2/2019-01-03
 * For a given Special Offer and an expiration date generate for each Recipient a Voucher Code
 * */
$app->get('/newvouchers/{offer_id}/{expiration_date}', function (ServerRequestInterface $request, ResponseInterface $response) {
    $newResponse = $response->withHeader('Content-type', 'application/json');
    $model = new PersistenceManager();
    $std = $model->generateVouchers(
            $request->getAttribute('offer_id'),
            $request->getAttribute('expiration_date')
        );
    return $newResponse->withJson($std, 201);
});
$app->run();

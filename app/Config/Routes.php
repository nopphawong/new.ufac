<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('lang/{locale}', 'Language::change');

// PAGES
$routes->get('login', 'Pages::login');
$routes->get('register', 'Pages::register');
$routes->get('forgot', 'Pages::forgot');
$routes->get('/', 'Pages::index', ['filter' => 'authGuard']);
$routes->get('/logout', 'Pages::logout', ['filter' => 'authGuard']);
$routes->get('profile', 'Pages::profile', ['filter' => 'authGuard']);
// $routes->get('change-password', 'Pages::changePassword', ['filter' => 'authGuard']);
$routes->get('deposit', 'Pages::deposit', ['filter' => 'authGuard']);
$routes->get('withdraw', 'Pages::withdraw', ['filter' => 'authGuard']);
$routes->get('history', 'Pages::history', ['filter' => 'authGuard']);
$routes->get('promotion', 'Pages::promotion', ['filter' => 'authGuard']);
// $routes->get('wheel', 'Pages::wheel', ['filter' => 'authGuard']);
// $routes->get('checkin', 'Pages::checkin', ['filter' => 'authGuard']);

// API
$routes->post('auth/login', 'api\Auth::login');
$routes->group('register', static function ($routes) {
    $routes->post('validate-phone', 'api\Auth::checkUserExits');
    $routes->post('verify-bank', 'api\Auth::verifyBank');
    $routes->post('webuser', 'api\Auth::getWebUser');
    $routes->post('unlink-webuser', 'api\Auth::unlinkWebUser');
    $routes->post('submit', 'api\Auth::register');
});
$routes->group('forgot', static function ($routes) {
    $routes->post('request-otp', 'api\Auth::requestOtp');
    $routes->post('submit', 'api\Auth::forgot');
});
$routes->group('lobby', static function ($routes) {
    $routes->post('/', 'api\Lobby::getLobby');
    $routes->post('info', 'api\Lobby::getInfo');
    $routes->post('balance', 'api\Lobby::getBalance');
    $routes->post('changepass', 'api\Lobby::changePassword');
    $routes->post('ufatoken', 'api\Lobby::getUfaToken');
});
$routes->group('financial', static function ($routes) {
    $routes->post('deposit-account', 'api\Financial::getDepositAccount');
    $routes->post('deposit/transfer', 'api\Financial::deposit');
    $routes->post('deposit/qrcode', 'api\Financial::depositQrCode');
    $routes->post('withdraw', 'api\Financial::withdraw');
    $routes->post('history', 'api\Financial::getHistory');
});
$routes->group('event', static function ($routes) {
    $routes->post('job/daily', 'api\Event::jobDaily');

    $routes->post('wheel', 'api\Event::getWheel');
    $routes->post('wheel/roll', 'api\Event::getWheelRoll');
    $routes->post('wheel/histories', 'api\Event::getWheelHistories');
    $routes->post('wheel/claim', 'api\Event::getWheelClaim');
    $routes->post('wheel/usable', 'api\Event::getWheelUsable');
    $routes->post('wheel/claimall', 'api\Event::getWheelClaimAll');

    $routes->post('checkin', 'api\Event::getCheckin');
    $routes->post('checkin/progress', 'api\Event::getCheckinList');
    $routes->post('checkin/histories', 'api\Event::getCheckinHistories');
    $routes->post('checkin/claim', 'api\Event::getCheckinClaim');
    $routes->post('checkin/claimall', 'api\Event::getCheckinClaimAll');
});

<?php
/**
 * Front-controller – monolithe PHP
 * Autoload Composer : remonter d’un niveau.
 */
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ReservationController;

$controller = new ReservationController();
$controller->handle($_SERVER['REQUEST_METHOD'], $_POST);

<?php

use Max\Aluraplay\Controllers\AddVideoController;
use Max\Aluraplay\Controllers\EditVideoController;
use Max\Aluraplay\Controllers\LoginController;
use Max\Aluraplay\Controllers\RemoveVideoController;
use Max\Aluraplay\Controllers\VideoFormController;
use Max\Aluraplay\Controllers\VideoListController;

return [
    'GET|/' => VideoListController::class,
    'GET|/add-video' => VideoFormController::class,
    'POST|/add-video' => AddVideoController::class,
    'GET|/edit-video' => VideoFormController::class,
    'POST|/edit-video' => EditVideoController::class,
    'GET|/remove' => RemoveVideoController::class,
    'GET|/login' => LoginController::class,
    'POST|/login' => LoginController::class,
    'GET|/logout' => LoginController::class,
];

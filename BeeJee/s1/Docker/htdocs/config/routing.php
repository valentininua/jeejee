<?php
return array(
    '/' => "MainController::main",
    '/Main/login/' => "MainController::index",
    '/Main/index/' => "MainController::index",
    '/ajax/rowInserted'=> "MainController::rowInserted",
    '/ajax/rowRemoved' => "MainController::rowRemoved",
    '/ajax/rowUpdated' => "MainController::rowUpdated",
    '/ajax/CheckUniqueEmailAddress' => "MainController::checkUniqueEmailAddress",
    '/Auth/login/' => "AuthController::login",
    '/Auth/logout/' => "AuthController::logout",
);

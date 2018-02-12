<?php
/*
 * Website Configuration
 */
$GLOBALS['config'] = array(
    'mysql' => array(

         'host' => 'winwinlabs.com',
        'username' => 'winwinlabs',
        'password' => 'winwinlabs2017',
        'db' => 'winwinlabs_database',
    ),
    'Upload' => array(
        'path' => '../uploads',
        'salt' => 'random_salt'
    )
);

spl_autoload_register(function ($class) {
    require_once __DIR__.'/../Controllers/'.$class.'.php';
});

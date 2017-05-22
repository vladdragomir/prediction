<?php

require __DIR__ . '/vendor/autoload.php';

function get_base_url() {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $base_url = "https://" . $_SERVER['HTTP_HOST'];
    } else {
        $base_url = "http://" . $_SERVER['HTTP_HOST'];
    }

    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

    return $base_url;
}

Flight::set('flight.views.path', 'app/views');

Flight::route('/', function(){
  Flight::render('home.php', []);
});

Flight::start();
<?php

$router->get('', 'PagesController@getHome');
$router->get('about', 'PagesController@getAbout');
$router->get('contact', 'PagesController@getContact');
$router->post('add-name', 'NameController@addName');
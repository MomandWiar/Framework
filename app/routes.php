<?php

/**
* Routes.
*
* Define here the routes
*/

$router->get('/', 'PagesController@getHome');
$router->get('/about', 'PagesController@getAbout');
$router->get('/about/culture', 'PagesController@getAboutCulture');
$router->get('/contact', 'PagesController@getContact');
$router->post('/add-name', 'NameController@addName');